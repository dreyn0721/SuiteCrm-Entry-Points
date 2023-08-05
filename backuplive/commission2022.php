<?php
//echo "test"; exit();





require_once('include/entryPoint.php');


require_once('custom/formula_functions.php');
require_once('modules/Med01_Policy/Med01_Policy.php');
require_once('modules/Med01_Insured/Med01_Insured.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$policy = new Med01_Policy();
$insured = new Med01_Insured();
$commission = new Med01_Commission();





/*
//collect all insured at 1 query request, so we can grab later. this way we can save resource, instead of requesting query for each
$query_insured = "SELECT id, name FROM {$insured->table_name} ";
$result_insured = $insured->db->query($query_insured);

$related_insured_by_id = [];

while ($the_insured = $insured->db->fetchByAssoc($result_insured)) {
    $related_insured_by_id[ $the_insured['id'] ] = $the_insured;
}*/






//Get relationship of Policy - Insured
$related_insured_id_by_policy_id = [];
$query_policy_insured_relationship = "SELECT * FROM `med01_insured_med01_policy_1_c` where deleted != '1' ";
$relationship_insured_policy = $insured->db->query($query_policy_insured_relationship);

while ($the_relationship_insured_policy = $insured->db->fetchByAssoc($relationship_insured_policy)) {
    $related_insured_id_by_policy_id[ $the_relationship_insured_policy['med01_insured_med01_policy_1med01_policy_idb'] ] = $the_relationship_insured_policy['med01_insured_med01_policy_1med01_insured_ida'];
}



$query_policy_insured_relationship2 = "SELECT * FROM `med01_insured_med01_policy_c` where deleted != '1' ";
$relationship_insured_policy2 = $insured->db->query($query_policy_insured_relationship2);

while ($the_relationship_insured_policy2 = $insured->db->fetchByAssoc($relationship_insured_policy2)) {
    $related_insured_id_by_policy_id[ $the_relationship_insured_policy2['med01_insured_med01_policymed01_policy_idb'] ] = $the_relationship_insured_policy2['med01_insured_med01_policymed01_insured_ida'];
}
































//collect all commissions at 1 query request, so we can grab later. this way we can save resource, instead of requesting query for each
$query_commission = "SELECT id, name, statementdate, chargeback, commission FROM {$commission->table_name} ";
$result_commission = $commission->db->query($query_commission);

$related_commission_by_id = [];

while ($the_commission = $commission->db->fetchByAssoc($result_commission)) {
    $related_commission_by_id[ $the_commission['id'] ] = $the_commission;
}


//$var[ many(commission) ] = one(policy)
//Get relationship of Policy - Commission , get related policy id by commission ID
$commission_ids_by_policy_id = [];
$query_policy_commission_relationship = "SELECT * FROM `med01_policy_med01_commission_1_c` where deleted = '9' "; //disabled this query - having dupe issue, lets set to == 9
$relationship_commission_policy = $policy->db->query($query_policy_commission_relationship);

while ($the_relationship_commission_policy = $policy->db->fetchByAssoc($relationship_commission_policy)) {

    if( isset( $commission_ids_by_policy_id[ $the_relationship_commission_policy['med01_policy_med01_commission_1med01_policy_ida'] ] ) ){
    } else {
        $commission_ids_by_policy_id[ $the_relationship_commission_policy['med01_policy_med01_commission_1med01_policy_ida'] ] = [];        
    }

    $commission_ids_by_policy_id[ $the_relationship_commission_policy['med01_policy_med01_commission_1med01_policy_ida'] ][] = $the_relationship_commission_policy['med01_policy_med01_commission_1med01_commission_idb'];

}


$query_policy_commission_relationship2 = "SELECT * FROM `med01_policy_med01_commission_c` where deleted != '1' ";
$relationship_commission_policy2 = $policy->db->query($query_policy_commission_relationship2);

while ($the_relationship_commission_policy2 = $policy->db->fetchByAssoc($relationship_commission_policy2)) {

    if( isset( $commission_ids_by_policy_id[ $the_relationship_commission_policy2['med01_policy_med01_commissionmed01_policy_ida'] ] ) ){
    } else {
        $commission_ids_by_policy_id[ $the_relationship_commission_policy2['med01_policy_med01_commissionmed01_policy_ida'] ] = [];        
    }

    $commission_ids_by_policy_id[ $the_relationship_commission_policy2['med01_policy_med01_commissionmed01_policy_ida'] ][] = $the_relationship_commission_policy2['med01_policy_med01_commissionmed01_commission_idb'];
}


































// Get all the list, no limit, we only limit the number of to updates
//$query = "SELECT id FROM {$policy->table_name} WHERE DATE_MODIFIED >= DATE_SUB(NOW(), INTERVAL 1 DAY) OR DATE_ENTERED >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$query = "SELECT id, name, commission2022, carrier FROM {$policy->table_name}  ";
$result = $policy->db->query($query);






$count_rows_remaining = 0;
$update_limit = 10;
$total_rows_updated = 0;

$has_update = false; //zxc
$update_data = []; //zxc

while ($row = $policy->db->fetchByAssoc($result)) {

    if( isset( $related_insured_id_by_policy_id[ $row['id'] ] ) && $related_insured_id_by_policy_id[ $row['id'] ] && isset( $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ] ) && $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ] ){
        $related_insured_data = $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ];
    } else {
        $related_insured_data = false;
    }


    $formula = commission2022( $row, $related_insured_data, $related_commission_by_id, $commission_ids_by_policy_id );

    if( isset( $formula ) && ( isset( $row['commission2022'] ) || is_null( $row['commission2022'] ) ) ){ //zxc
        if( strtolower( str_replace(" ", "", (string)$row['commission2022']) ) != strtolower( str_replace(" ", "", (string)$formula ) ) ){ // if the current value is not the same with the new value, else we don't need to update since it's already correct //zxc
            
            //zxc
            $has_update = true;
            $update_data[] = '("'.$row['id'].'", "'.$formula.'")';
            $total_rows_updated++;// Count the total row updated
            
        }
    }
}





//mass update zxc
if( isset( $has_update ) && $has_update && isset( $update_data ) && is_array( $update_data ) && count( $update_data ) > 0 ){


    $update_query = "INSERT into {$policy->table_name} (id,commission2022) VALUES ".implode( ", ", $update_data ) . " ON DUPLICATE KEY UPDATE commission2022 = VALUES(commission2022) ";

    $result = $policy->db->query($update_query);


    echo $total_rows_updated." total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';


} else {

    echo "0 total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';
}





?>
