<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('include/entryPoint.php');


require_once('custom/formula_functions.php');
require_once('modules/Med01_Commission/Med01_Commission.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$commission = new Med01_Commission();
















//////////////////INSURED/////////////
// Get all the list, no limit, we only limit the number of to updates
$query = "SELECT id, name, hra, gpmpaidhra, carrier FROM {$commission->table_name} WHERE deleted != '1' ";
$result = $commission->db->query($query);



$total_rows_updated = 0;

$has_update = false; //zxc
$update_data = []; //zxc

while ($row = $commission->db->fetchByAssoc($result)) {


    if( isset( $row['hra'] ) && $row['hra'] && (int)$row['hra'] === 1 ){
    } else {
        continue;
    }




    $check_formula = 0;
    
    if( isset( $row['carrier'] ) && strtolower( str_replace(" ", "", (string)$row['carrier']) ) == "gpm" ){
        $check_formula = 1;
    }



    if( isset( $check_formula ) && ( isset( $row['gpmpaidhra'] ) || is_null( $row['gpmpaidhra'] ) ) ){ //zxc
        if( (int)$row['gpmpaidhra'] != $check_formula ){ // if the current value is not the same with the new value, else we don't need to update since it's already correct
            
            //zxc
            $has_update = true;
            $update_data[] = '("'.$row['id'].'", '.$check_formula.')'; 
            $total_rows_updated++;// Count the total row updated

        }
    }
}



//mass update zxc
if( isset( $has_update ) && $has_update && isset( $update_data ) && is_array( $update_data ) && count( $update_data ) > 0 ){

    $update_query = "INSERT into {$commission->table_name} (id,gpmpaidhra) VALUES ".implode( ", ", $update_data ) . " ON DUPLICATE KEY UPDATE gpmpaidhra = VALUES(gpmpaidhra) ";

    $result = $commission->db->query($update_query);


    echo $total_rows_updated." total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';


} else {

    echo "0 total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';
}




?>