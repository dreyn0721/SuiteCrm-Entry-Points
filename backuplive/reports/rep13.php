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
$is_active_by_salesrep_query = "SELECT salesrep, COUNT( id ) as count  FROM {$policy->table_name} 
WHERE 
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful%'
	AND
	isactive = '1'
GROUP BY salesrep ";



$is_active_by_salesrep_res = $policy->db->query($is_active_by_salesrep_query);


$is_active_by_salesrep = [];
while ($is_active_row = $policy->db->fetchByAssoc($is_active_by_salesrep_res)) {
	$is_active_by_salesrep[ $is_active_row['salesrep'] ] = $is_active_row['count'];
}




//count and collect is active
$customer_date_count_by_salesrep_query = "SELECT salesrep, COUNT( id ) as count  FROM {$policy->table_name} 
WHERE 
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful%'
	AND
	customerdate != ''
	AND
	customerdate != 'null'
GROUP BY salesrep ";



$customer_date_count_by_salesrep_res = $policy->db->query($customer_date_count_by_salesrep_query);


$customer_date_count_by_salesrep = [];
while ($customer_date_count_row = $policy->db->fetchByAssoc($customer_date_count_by_salesrep_res)) {
	$customer_date_count_by_salesrep[ $customer_date_count_row['salesrep'] ] = $customer_date_count_row['count'];
}








$query = "SELECT salesrep, COUNT( id ) as count FROM {$policy->table_name} 
WHERE 
	salesrep != 'PCHC'
	AND
	status NOT LIKE 'Successful%' 
GROUP BY salesrep ";



$result_query = $policy->db->query($query);


$the_data = [];

while ($row = $policy->db->fetchByAssoc($result_query)) {

	$for_data = [];
	$for_data = array(
		"salesrep" => ( is_null( $row['salesrep'] )? "null" : $row['salesrep'] ),
		"count" => $row['count'],
		"isactive" => ( isset( $is_active_by_salesrep[ $row['salesrep'] ] )? $is_active_by_salesrep[ $row['salesrep'] ] : "0" )
	);


	if( isset( $is_active_by_salesrep[ $row['salesrep'] ] ) && $is_active_by_salesrep[ $row['salesrep'] ] && isset( $customer_date_count_by_salesrep[ $row['salesrep'] ] ) && $customer_date_count_by_salesrep[ $row['salesrep'] ] ){
		$for_data['percistency'] = number_format( ( ( $is_active_by_salesrep[ $row['salesrep'] ] / $customer_date_count_by_salesrep[ $row['salesrep'] ] ) * 100 ) , 2, '.', '')."%";
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
