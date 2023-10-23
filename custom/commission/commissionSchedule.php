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
$query = "SELECT id, name, commissionschedule, chargeback, first, renewal, deleted FROM {$commission->table_name} WHERE deleted != '1' ";
$result = $commission->db->query($query);



$total_rows_updated = 0;

$has_update = false; //zxc
$update_data = []; //zxc
$remaining = 0;

while ($row = $commission->db->fetchByAssoc($result)) {

    $formula = '';
    if( isset( $row['chargeback'] ) && abs( $row['chargeback'] ) > 0 && !is_null( $row['chargeback'] ) ){
        $formula = 'Chargeback';
    } else {
        if( isset( $row['first'] ) && ( $row['first'] == "true" || $row['first'] == true || $row['first'] == "1" || $row['first'] == 1 ) ){
            $formula = 'first';
        } else {
            if( isset( $row['renewal'] ) && ( $row['renewal'] == "true" || $row['renewal'] == true || $row['renewal'] == "1" || $row['renewal'] == 1 ) ){
                $formula = 'Renewal';
            } else {
                $formula = 'TBD';
            }
        }
    }

    if( is_null( $row['commissionschedule'] ) ){
        $row['commissionschedule'] = "";
    }

    if( isset( $formula ) && isset( $row['commissionschedule'] ) ){ //zxc
        if( strtolower( str_replace(" ", "", (string)$row['commissionschedule']) ) != strtolower( str_replace(" ", "", (string)$formula ) ) ){
            // if( $row['id'] == '100001'){

            //     echo "ID:".$row['id']."\n<br>";
            //     echo strtolower( str_replace(" ", "", (string)$row['commissionschedule']) ) ." ==? ". strtolower( str_replace(" ", "", (string)$formula ) );
            //     exit();
            // }
            //zxc
            if( count( $update_data ) >= 10000 ){
                $remaining++;
                continue;
            }

            $has_update = true;
            $update_data[] = '("'.$row['id'].'", "'.$formula.'")'; 
            $total_rows_updated++;// Count the total row updated

        }
    }
}



//mass update zxc
if( isset( $has_update ) && $has_update && isset( $update_data ) && is_array( $update_data ) && count( $update_data ) > 0 ){

    $update_query = "INSERT into {$commission->table_name} (id,commissionschedule) VALUES ".implode( ", ", $update_data ) . " ON DUPLICATE KEY UPDATE commissionschedule = VALUES(commissionschedule) ";

    $result = $commission->db->query($update_query);

    echo $total_rows_updated." total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.<br>';
    echo $remaining." rows remaining that needed to update, will be executed in next load.";


} else {

    echo "0 total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';
}




?>