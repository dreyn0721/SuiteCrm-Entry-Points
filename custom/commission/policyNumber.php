<?php


require_once('include/entryPoint.php');


require_once('custom/formula_functions.php');
require_once('modules/Med01_Policy/Med01_Policy.php');
// require_once('modules/Med01_Insured/Med01_Insured.php');
require_once('modules/Med01_Commission/Med01_Commission.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$policy = new Med01_Policy();
// $insured = new Med01_Insured();
$commission = new Med01_Commission();






//collect all policy at 1 query request, so we can grab later. this way we can save resource, instead of requesting query for each
$query_policy = "SELECT id, name, policynumber FROM {$policy->table_name} ";
$result_policy = $policy->db->query($query_policy);

$related_policy_by_id = [];
$policyid_by_policynumber = [];

while ($the_policy = $policy->db->fetchByAssoc($result_policy)) {
    $related_policy_by_id[ $the_policy['id'] ] = $the_policy;
    $policyid_by_policynumber[ $the_policy['policynumber'] ] = $the_policy['id'];
}






//Get relationship of Commission - Policy

$related_policy_id_by_commission_id = [];
$query_commission_policy_relationship = "SELECT * FROM `med01_policy_med01_commission_c` ";
$relationship_policy_commission = $policy->db->query($query_commission_policy_relationship);

while ($the_relationship_policy_commission = $policy->db->fetchByAssoc($relationship_policy_commission)) {
    $related_policy_id_by_commission_id[ $the_relationship_policy_commission['med01_policy_med01_commissionmed01_commission_idb'] ] = $the_relationship_policy_commission['med01_policy_med01_commissionmed01_policy_ida'];
}//ida is commission id







// Get all the list, no limit, we only limit the number of to updates
//$query = "SELECT id FROM {$policy->table_name} WHERE DATE_MODIFIED >= DATE_SUB(NOW(), INTERVAL 1 DAY) OR DATE_ENTERED >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$query = "SELECT id, name, policynumber FROM {$commission->table_name} ORDER BY id DESC ";
$result = $commission->db->query($query);






$count_rows_remaining = 0;
$update_limit = 10;
$total_rows_updated = 0;
$total_relational_added = 0;

$has_update = false; //zxc
$has_insert = false; //zxc
$update_data = []; //zxc
$insert_data = [];

while ($row = $commission->db->fetchByAssoc($result)) {

    // if( $row['id'] == '4c581349-bf48-ed7a-bd72-64b6cbcac0ea' ){
    //     echo "here";
    // } else {
    //     continue;
    // }


    if( isset( $related_policy_id_by_commission_id[ $row['id'] ] ) && $related_policy_id_by_commission_id[ $row['id'] ] && isset( $related_policy_by_id[ $related_policy_id_by_commission_id[ $row['id'] ] ] ) && $related_policy_by_id[ $related_policy_id_by_commission_id[ $row['id'] ] ] ){

        $related_policy_data = $related_policy_by_id[ $related_policy_id_by_commission_id[ $row['id'] ] ];
    } else {
        $related_policy_data = false;

        //insert query
        if( isset( $row['policynumber'] ) && isset( $policyid_by_policynumber ) && is_array( $policyid_by_policynumber ) && isset( $policyid_by_policynumber[ $row['policynumber'] ] ) ){
            $the_policyid_by_policynumber = $policyid_by_policynumber[ $row['policynumber'] ];
            $has_insert = true;
            $related_policy_data = $related_policy_by_id[ $the_policyid_by_policynumber ];

            $insert_data[] = '("'.create_guid().'", "'.date('Y-m-d H:i:s').'", 0, "'.$the_policyid_by_policynumber.'", "'.$row['id'].'")';
            $total_relational_added++;// Count the total row relational added

        } else {
            continue;
        }

        //id, date_modified, deleted, med01_policy_med01_commissionmed01_policy_ida, med01_policy_med01_commissionmed01_commission_idb
    }

    //$formula = accountName( $row, $related_policy_data );
    if( isset( $related_policy_data['name'] ) && $related_policy_data['name'] ){

        $policyname = $related_policy_data['name'];

        if( isset( $policyname ) && ( isset( $row['name'] ) || is_null( $row['name'] ) ) ){ //zxc
            if( strtolower( str_replace(" ", "", (string)$row['name']) ) != strtolower( str_replace(" ", "", (string)$policyname ) ) ){ // if the current value is not the same with the new value, else we don't need to update since it's already correct //zxc

                //zxc
                $has_update = true;
                $update_data[] = '("'.$row['id'].'", "'.$policyname.'")';
                $total_rows_updated++;// Count the total row updated
                
            }
        }
    }



}



//mass update zxc
if( isset( $has_update ) && $has_update && isset( $update_data ) && is_array( $update_data ) && count( $update_data ) > 0 ){


    $update_query = "INSERT into {$commission->table_name} (id,name) VALUES ".implode( ", ", $update_data ) . " ON DUPLICATE KEY UPDATE name = VALUES(name) ";

    $result = $commission->db->query($update_query);


    echo $total_rows_updated." total rows has been updated<br>";

    if( isset( $has_insert ) && $has_insert && isset( $insert_data ) && is_array( $insert_data ) && count( $insert_data ) > 0 ){


        $insert_query = "INSERT into `suitecrm.med01_policy_med01_commission_c` (id, date_modified, deleted, med01_policy_med01_commissionmed01_policy_ida, med01_policy_med01_commissionmed01_commission_idb) VALUES ".implode( ", ", $insert_data ) . " ";

        $result2 = $commission->db->query($insert_query);

        echo $total_relational_added." total relational created<br><br>";
        echo 'Recently changed or created records updated successfully.';
    }


} else {

    echo "0 total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';
}





?>
