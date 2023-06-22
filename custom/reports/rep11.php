<?php
//echo "test"; exit();

require_once('include/entryPoint.php');


//require_once('custom/formula_functions.php');

//require_once('modules/Med01_Insured/Med01_Insured.php');
require_once('modules/Med01_Policy/Med01_Policy.php');
//require_once('modules/Med01_CSCases/Med01_CSCases.php');



//$moduleName = 'Med01_Policy';

// Get the module object
//$insured = new Med01_Insured();
//$Case = new Med01_CSCases();
$policy = new Med01_Policy();




//count and collect is active
$is_active_by_agerange_query = "SELECT agerange, COUNT( id ) as count  FROM {$policy->table_name} 
WHERE 
	isactive = '1'
	AND
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%MA%'
OR
	isactive = '1'
	AND
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%HMO%'
OR
	isactive = '1'
	AND
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%PPO%'
OR
	isactive = '1'
	AND
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%SNP%'
OR
	isactive = '1'
	AND
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%Supp%'
GROUP BY agerange ";



$is_active_by_agerange_res = $policy->db->query($is_active_by_agerange_query);


$is_active_by_agerange = [];
while ($is_active_row = $policy->db->fetchByAssoc($is_active_by_agerange_res)) {
	$is_active_by_agerange[ $is_active_row['agerange'] ] = $is_active_row['count'];
}












//count and collect is active
$customer_date_count_by_agerange_query = "SELECT agerange, COUNT( id ) as count  FROM {$policy->table_name} 
WHERE 
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%MA%'
OR
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%HMO%'
OR
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%PPO%'
OR
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%SNP%'
OR
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%Supp%'
GROUP BY agerange ";



$customer_date_count_by_agerange_res = $policy->db->query($customer_date_count_by_agerange_query);


$customer_date_count_by_agerange = [];
while ($customer_date_count_row = $policy->db->fetchByAssoc($customer_date_count_by_agerange_res)) {
	$customer_date_count_by_agerange[ $customer_date_count_row['agerange'] ] = $customer_date_count_row['count'];
}
















$query = "SELECT agerange, COUNT( id ) as count FROM {$policy->table_name} 
WHERE 
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%MA%'
OR
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%HMO%'
OR
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%PPO%'
OR
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%SNP%'
OR
	customerdate != ''
	AND
	customerdate != 'null'
	AND
	agerange != ''
	AND
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful'
	AND
	plantype LIKE '%Supp%'
GROUP BY agerange ";



$result_query = $policy->db->query($query);


$the_data = [];

while ($row = $policy->db->fetchByAssoc($result_query)) {

	$for_data = [];
	$for_data = array(
		"agerange" => ( is_null( $row['agerange'] )? "null" : $row['agerange'] ),
		"count" => $row['count'],
		"isactive" => ( isset( $is_active_by_agerange[ $row['agerange'] ] )? $is_active_by_agerange[ $row['agerange'] ] : "0" )
	);


	if( isset( $is_active_by_agerange[ $row['agerange'] ] ) && $is_active_by_agerange[ $row['agerange'] ] && isset( $customer_date_count_by_agerange[ $row['agerange'] ] ) && $customer_date_count_by_agerange[ $row['agerange'] ] ){
		$for_data['percistency'] = number_format( ( ( $is_active_by_agerange[ $row['agerange'] ] / $customer_date_count_by_agerange[ $row['agerange'] ] ) * 100 ) , 2, '.', '')."%";
	} else {
		$for_data['percistency'] = "0%";
	}


    $the_data[] = $for_data;
}


if( isset( $the_data ) && is_array( $the_data ) && count( $the_data ) > 0 ){
	echo json_encode( $the_data );
	exit();
} else {
	echo "false";
	exit();
}




?>
