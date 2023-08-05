<?php
//echo "test"; exit();

require_once('include/entryPoint.php');


//require_once('custom/formula_functions.php');

require_once('modules/Med01_Insured/Med01_Insured.php');
require_once('modules/Med01_Policy/Med01_Policy.php');
//require_once('modules/Med01_CSCases/Med01_CSCases.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$insured = new Med01_Insured();
//$Case = new Med01_CSCases();
$policy = new Med01_Policy();




//collect all insured at 1 query request, so we can grab later. this way we can save resource, instead of requesting query for each
$query_insured = "SELECT id, primarystate FROM {$insured->table_name} ";
$result_insured = $insured->db->query($query_insured);

$related_insured_by_id = [];

while ($the_insured = $insured->db->fetchByAssoc($result_insured)) {
    $related_insured_by_id[ $the_insured['id'] ] = $the_insured;
}


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








$query = "SELECT id FROM {$policy->table_name} 
WHERE 
	salesrep != 'PCHC'
	AND
	plantype LIKE '%MAPD D-SNP%'
	AND
	status NOT LIKE 'Successful%'
OR
	salesrep != 'PCHC'
	AND
	plantype LIKE '%MAPD%'
	AND
	status NOT LIKE 'Successful%'
OR
	salesrep != 'PCHC'
	AND
	plantype LIKE '%MAPD C-SNP%'
	AND
	status NOT LIKE 'Successful%'
OR
	salesrep != 'PCHC'
	AND
	plantype LIKE '%Medicare Supplement%'
	AND
	status NOT LIKE 'Successful%'
OR
	salesrep != 'PCHC'
	AND
	plantype LIKE '%PPO%'
	AND
	status NOT LIKE 'Successful%'
OR
	salesrep != 'PCHC'
	AND
	plantype LIKE '%HMO%'
	AND
	status NOT LIKE 'Successful%'
";

$result_query = $policy->db->query($query);

$the_data = [];

while ($row = $policy->db->fetchByAssoc($result_query)) {
	$state = false;

	// print_r( $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ]['primarystate'] );
	// exit();

	if( isset( $related_insured_id_by_policy_id[ $row['id'] ] ) && isset( $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ] ) && isset( $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ]['primarystate'] ) ){

		if( isset( $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ]['primarystate'] ) ){
			$state = $related_insured_by_id[ $related_insured_id_by_policy_id[ $row['id'] ] ]['primarystate'];
		} else {
			$state = "null";
		}


		if( isset( $the_data[ $state ] ) && $the_data[ $state ] ){
			$the_data[ $state ] = $the_data[ $state ]+1;
		} else {
			$the_data[ $state ] = 1;
		}
	}

}

if( isset( $the_data ) && is_array( $the_data ) && count( $the_data ) > 0 ){
	echo json_encode( $the_data );
	exit();
} else {
	echo "false";
	exit();
}





?>
