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









// Get all the list, no limit, we only limit the number of to updates
//$query = "SELECT id FROM {$policy->table_name} WHERE DATE_MODIFIED >= DATE_SUB(NOW(), INTERVAL 1 DAY) OR DATE_ENTERED >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$query = "SELECT id, name, annualizedpremium, premium FROM {$policy->table_name}  ";
$result = $policy->db->query($query);






$count_rows_remaining = 0;
$update_limit = 10;
$total_rows_updated = 0;

while ($row = $policy->db->fetchByAssoc($result)) {

        if( isset( $related_insured_id_by_policy_id[ $row['id'] ] ) && $related_insured_id_by_policy_id[ $row['id'] ] && isset( $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ] ) && $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ] ){
            $related_insured_data = $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ];
        } else {
            $related_insured_data = false;
        }

        //Limit the row to update in the load
        if( $total_rows_updated >= $update_limit ){
                $count_rows_remaining++;
                continue;
        }

        $formula = annualizedPremium( $row, $related_insured_data );

        if( isset( $formula ) ){
            if( (string)$row['annualizedpremium'] != (string)$formula ){ // if the current value is not the same with the new value, else we don't need to update since it's already correct
                $record = $policy->retrieve($row['id']); //Retrieve only if necessary so we can save resource
                if( isset( $record ) && is_object( $record ) ){
                    $record->annualizedpremium = $formula;

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
