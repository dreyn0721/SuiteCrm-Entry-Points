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
$is_active_by_carrier_query = "SELECT carrier, COUNT( id ) as count  FROM {$policy->table_name} 
WHERE 
	isactive = '1'
	AND
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD'
OR
	isactive = '1'
	AND
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD D-SNP'
OR
	isactive = '1'
	AND
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD C-SNP'
OR
	isactive = '1'
	AND
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype LIKE '%HMO%'
OR
	isactive = '1'
	AND
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype LIKE '%PPO%'
GROUP BY carrier ";



$is_active_by_carrier_res = $policy->db->query($is_active_by_carrier_query);


$is_active_by_carrier = [];
while ($is_active_row = $policy->db->fetchByAssoc($is_active_by_carrier_res)) {
	$is_active_by_carrier[ $is_active_row['carrier'] ] = $is_active_row['count'];
}




//count and collect is active
$customer_date_count_by_carrier_query = "SELECT carrier, COUNT( id ) as count  FROM {$policy->table_name} 
WHERE 
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD'
OR
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD D-SNP'
OR
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD C-SNP'
OR
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype LIKE '%HMO%'
OR
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype LIKE '%PPO%'
GROUP BY carrier ";



$customer_date_count_by_carrier_res = $policy->db->query($customer_date_count_by_carrier_query);


$customer_date_count_by_carrier = [];
while ($customer_date_count_row = $policy->db->fetchByAssoc($customer_date_count_by_carrier_res)) {
	$customer_date_count_by_carrier[ $customer_date_count_row['carrier'] ] = $customer_date_count_row['count'];
}








$query = "SELECT carrier, COUNT( id ) as count FROM {$policy->table_name} 
WHERE 
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD'
OR
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD D-SNP'
OR
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype = 'MAPD C-SNP'
OR
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype LIKE '%HMO%'
OR
	salesrep != 'PCHC'
	AND
	customerdate != 'null'
	AND
	customerdate != ''
	AND
	plantype LIKE '%PPO%'
GROUP BY carrier ";



$result_query = $policy->db->query($query);


$the_data = [];

while ($row = $policy->db->fetchByAssoc($result_query)) {

	$for_data = [];
	$for_data = array(
		"carrier" => ( is_null( $row['carrier'] )? "null" : $row['carrier'] ),
		"count" => $row['count'],
		"isactive" => ( isset( $is_active_by_carrier[ $row['carrier'] ] )? $is_active_by_carrier[ $row['carrier'] ] : "0" )
	);


	if( isset( $is_active_by_carrier[ $row['carrier'] ] ) && $is_active_by_carrier[ $row['carrier'] ] && isset( $customer_date_count_by_carrier[ $row['carrier'] ] ) && $customer_date_count_by_carrier[ $row['carrier'] ] ){
		$for_data['percistency'] = number_format( ( ( $is_active_by_carrier[ $row['carrier'] ] / $customer_date_count_by_carrier[ $row['carrier'] ] ) * 100 ) , 2, '.', '')."%";
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
