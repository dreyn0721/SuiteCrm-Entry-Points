<?php

error_reporting(-1);
ini_set('display_errors', 1);

require_once('include/entryPoint.php');


require_once('custom/formula_functions.php');
require_once('modules/Med01_Policy/Med01_Policy.php');
require_once('modules/Med01_Insured/Med01_Insured.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$policy = new Med01_Policy();
$insured = new Med01_Insured();


$related_policy_by_id = [];

$policy_ids_by_insured_id = [];









//////////////////POLICIES//////////////
/*
//collect all policies at 1 query request, so we can grab later. this way we can save resource, instead of requesting query for each
$query_policy = "SELECT id, name FROM {$policy->table_name} ";
$result_policy = $policy->db->query($query_policy);


while ($the_policy = $policy->db->fetchByAssoc($result_policy)) {
    $related_policy_by_id[ $the_policy['id'] ] = $the_policy;
}


//$var[ many(policy) ] = one(insured)
//Get relationship of Insured - Policy , get related insured id by policy ID
$query_insured_policy_relationship = "SELECT * FROM `med01_insured_med01_policy_1_c` where deleted != '1' ";
$relationship_policy_insured = $policy->db->query($query_insured_policy_relationship);

while ($the_relationship_policy_insured = $policy->db->fetchByAssoc($relationship_policy_insured)) {

    if( isset( $policy_ids_by_insured_id[ $the_relationship_policy_insured['med01_insured_med01_policy_1med01_insured_ida'] ] ) ){
    } else {
        $policy_ids_by_insured_id[ $the_relationship_policy_insured['med01_insured_med01_policy_1med01_insured_ida'] ] = [];        
    }

    $policy_ids_by_insured_id[ $the_relationship_policy_insured['med01_insured_med01_policy_1med01_insured_ida'] ][] = $the_relationship_policy_insured['med01_insured_med01_policy_1med01_policy_idb'];
}
*/
/////////////////POLICIES////////////////////////






































//////////////////INSURED/////////////
// Get all the list, no limit, we only limit the number of to updates
//$query = "SELECT id FROM {$insured->table_name} WHERE DATE_MODIFIED >= DATE_SUB(NOW(), INTERVAL 1 DAY) OR DATE_ENTERED >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$query = "SELECT id, name, fullmailingaddress, mailingstreetaddress, mailingcity, mailingstateprovince, mailingzippostalcode FROM {$insured->table_name}  ";
$result = $insured->db->query($query);



$count_rows_remaining = 0;
$update_limit = 10;
$total_rows_updated = 0;

while ($row = $insured->db->fetchByAssoc($result)) {


        //Limit the row to update in the load
        if( $total_rows_updated >= $update_limit ){
                $count_rows_remaining++;
                continue;
        }



        $formula = insured_fullMailingAddress( $row, $related_policy_by_id, $policy_ids_by_insured_id );


        if( isset( $formula ) ){
            if( (string)$row['fullmailingaddress'] != (string)$formula ){ // if the current value is not the same with the new value, else we don't need to update since it's already correct
                $record = $insured->retrieve($row['id']); //Retrieve only if necessary so we can save resource
                if( isset( $record ) && is_object( $record ) ){
                    $record->fullmailingaddress = $formula;

                    //save row
                    $record->save();
                    $total_rows_updated++;// Count the total row updated
                }
            }
        }

        //$status = $row[field_name];

        /* 

        $record = $policy->retrieve($row['id']);

        $record->{$isActiveField} = 1;

        //save row
        $record->save();

        $total_rows_updated++;*/


}







echo $count_rows_remaining." total rows remaining<br>";

echo $total_rows_updated." total rows has been updated<br>";

echo 'Recently changed or created records updated successfully.';

?>
