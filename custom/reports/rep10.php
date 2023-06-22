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






$query = "SELECT lun, COUNT( id ) as count FROM {$policy->table_name} 
WHERE 
	status NOT LIKE 'Successful%'
	AND
	plantype LIKE '%HMO%'
OR
	status NOT LIKE 'Successful%'
	AND
	plantype LIKE '%PPO%'
OR
	status NOT LIKE 'Successful%'
	AND
	plantype LIKE '%MA%'
OR
	status NOT LIKE 'Successful%'
	AND
	plantype LIKE '%Supp%'
OR
	status NOT LIKE 'Successful%'
	AND
	plantype LIKE '%PD%'
GROUP BY lun ";

$result_query = $policy->db->query($query);

$the_data = [];

while ($row = $policy->db->fetchByAssoc($result_query)) {

	$for_data = [];
	$for_data = array(
		"lun" => ( is_null( $row['lun'] )? "null" : $row['lun'] ),
		"count" => $row['count']
	);


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
