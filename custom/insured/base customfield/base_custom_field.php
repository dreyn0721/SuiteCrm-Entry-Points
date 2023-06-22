<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('include/entryPoint.php');


require_once('custom/formula_functions.php');
require_once('modules/Med01_Policy/Med01_Policy.php');
require_once('modules/Med01_Insured/Med01_Insured.php');
require_once('modules/Med01_CSCases/Med01_CSCases.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$policy = new Med01_Policy();
$insured = new Med01_Insured();
$case = new Med01_CSCases();


$related_policy_by_id = [];
$policy_ids_by_insured_id = [];


// $related_case_by_id
$related_case_by_id = [];
$related_cases_by_insured_id = [];






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



























//////////////////CASES COUNT//////////////
$case_today = date( "Y-m-d H:i:s", strtotime( date( "Y-m-d H:i:s" )." +12 hours" ) );
$last_10_days = date( "Y-m-d", strtotime( date( "Y-m-d H:i:s" )." - 10 days" ) )." 00:00:00";

$query_case = "SELECT id, name FROM {$case->table_name} WHERE date_modified <= '".$case_today."' AND date_modified >= '".$last_10_days."'";
$result_case = $case->db->query($query_case);

while ($the_case = $case->db->fetchByAssoc($result_case)) {
    $related_case_by_id[ $the_case['id'] ] = $the_case;
}

//Get relationship of Insured - case , get related insured id by case ID
$query_insured_case_relationship = "SELECT * FROM `med01_insured_med01_cscases_1_c` where deleted != '1' ";
$relationship_case_insured = $case->db->query($query_insured_case_relationship);

while ($the_relationship_case_insured = $case->db->fetchByAssoc($relationship_case_insured)) {
    if( isset( $related_case_by_id[ $the_relationship_case_insured['med01_insured_med01_cscases_1med01_cscases_idb'] ] ) ){

        if( isset( $related_cases_by_insured_id[ $the_relationship_case_insured['med01_insured_med01_cscases_1med01_insured_ida'] ] ) ){

        } else {
            $related_cases_by_insured_id[ $the_relationship_case_insured['med01_insured_med01_cscases_1med01_insured_ida'] ] = [];        
        }

        $related_cases_by_insured_id[ $the_relationship_case_insured['med01_insured_med01_cscases_1med01_insured_ida'] ][] = $the_relationship_case_insured['med01_insured_med01_cscases_1med01_cscases_idb'];

    }
}


$query_insured_case_relationship2 = "SELECT * FROM `med01_insured_med01_cscases_c` where deleted != '1' ";
$relationship_case_insured2 = $case->db->query($query_insured_case_relationship2);

while ($the_relationship_case_insured = $case->db->fetchByAssoc($relationship_case_insured2)) {
    if( isset( $related_case_by_id[ $the_relationship_case_insured['med01_insured_med01_cscasesmed01_cscases_idb'] ] ) ){

        if( isset( $related_cases_by_insured_id[ $the_relationship_case_insured['med01_insured_med01_cscasesmed01_insured_ida'] ] ) ){
        } else {
            $related_cases_by_insured_id[ $the_relationship_case_insured['med01_insured_med01_cscasesmed01_insured_ida'] ] = [];        
        }

        $related_cases_by_insured_id[ $the_relationship_case_insured['med01_insured_med01_cscasesmed01_insured_ida'] ][] = $the_relationship_case_insured['med01_insured_med01_cscasesmed01_cscases_idb'];
    
    }
}
/////////////////CASES COUNT////////////////////////








/*
"

SELECT 
med01_policy.id as policy_id, 
med01_policy.name as policy_name, 
med01_insured.id as insured_id, 
med01_insured.name as insured_name,
med01_insured_med01_policy_c.id as relation_id,
med01_insured_med01_policy_c.med01_insured_med01_policymed01_policy_idb as many,
med01_insured_med01_policy_c.med01_insured_med01_policymed01_insured_ida as one

FROM suitecrm.med01_policy

JOIN suitecrm.med01_insured_med01_policy_c ON med01_policy.id = med01_insured_med01_policy_c.med01_insured_med01_policymed01_policy_idb
JOIN suitecrm.med01_insured ON med01_insured.id = med01_insured_med01_policy_c.med01_insured_med01_policymed01_insured_ida

WHERE med01_insured_med01_policy_c.deleted = 0

LIMIT 10;


"*/
/*
"
SELECT 
  med01_commission.currency_id AS 'med01_commission_currency_id', 
  med01_commission.commission AS 'Commission0', 
  med01_commission.id AS 'med01_commission_id' 
FROM 
  med01_commission
WHERE 
  (
    med01_commission.carrier = 'UHC' 
    AND (
      med01_commission.date_entered > '2020-01-01 05:00:00' 
      OR med01_commission.date_entered BETWEEN '2020-01-01 05:00:00' 
      AND '2020-01-02 05:00:00'
    ) 
    AND (
      med01_commission.date_entered < '2023-01-01 04:45:00' 
      OR med01_commission.date_entered BETWEEN '2023-01-01 04:45:00' 
      AND '2023-01-02 04:45:00'
    )
  ) 
  AND med01_commission.deleted = 0
  "
*/




//////////////////INSURED/////////////
// Get all the list, no limit, we only limit the number of to updates
//$query = "SELECT id FROM {$insured->table_name} WHERE DATE_MODIFIED >= DATE_SUB(NOW(), INTERVAL 1 DAY) OR DATE_ENTERED >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$query = "SELECT {$insured->table_name}.id as id, {$insured->table_name}.name as name, med01_insured_cstm.id_c as id_c, med01_insured_cstm.numberofcasesinthelast10days_c as numberofcasesinthelast10days_c FROM {$insured->table_name} LEFT JOIN med01_insured_cstm ON {$insured->table_name}.id = med01_insured_cstm.id_c ";
$result = $insured->db->query($query);



$count_rows_remaining = 0;
$update_limit = 10;
$total_rows_updated = 0;

$has_update = false; //zxc
$update_data = []; //zxc

while ($row = $insured->db->fetchByAssoc($result)) {



    //$formula = insured_numberOfCasesInTheLast10days( $row, $related_policy_by_id, $policy_ids_by_insured_id );
    if( isset( $related_cases_by_insured_id[ $row['id'] ] ) && count( $related_cases_by_insured_id[ $row['id'] ] ) > 0 ){
        $formula = count( $related_cases_by_insured_id[ $row['id'] ] );
    } else {
        $formula = 0;
    }



    if( isset( $formula ) && ( isset( $row['numberofcasesinthelast10days_c'] ) || is_null( $row['numberofcasesinthelast10days_c'] ) ) && ( isset( $row['id'] ) && $row['id'] ) ){ //zxc
        if( strtolower( str_replace(" ", "", (string)$row['numberofcasesinthelast10days_c']) ) != strtolower( str_replace(" ", "", (string)$formula ) ) ){ // if the current value is not the same with the new value, else we don't need to update since it's already correct //zxc
            
    


            //zxc
            $has_update = true;
            $update_data[] = '("'.$row['id'].'", "'.$formula.'")';
            $total_rows_updated++;// Count the total row updated

        }
    }
}





//mass update zxc
if( isset( $has_update ) && $has_update && isset( $update_data ) && is_array( $update_data ) && count( $update_data ) > 0 ){


    $update_query = "INSERT into suitecrm.med01_insured_cstm (id_c,numberofcasesinthelast10days_c) VALUES ".implode( ", ", $update_data ) . " ON DUPLICATE KEY UPDATE numberofcasesinthelast10days_c = VALUES(numberofcasesinthelast10days_c) ";

    $result = $insured->db->query($update_query);


    echo $total_rows_updated." total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';


} else {

    echo "0 total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';
}




?>