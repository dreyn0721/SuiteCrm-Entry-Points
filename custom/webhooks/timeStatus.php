<?php
//echo "test"; exit();



require_once('include/entryPoint.php');


require_once('modules/Med01_Insured/Med01_Insured.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$insured = new Med01_Insured();



if( isset( $_POST['id'] ) && $_POST['id'] ){
    $id = $_POST['id'];
} else if( isset( $_GET['id'] ) && $_GET['id'] ){
    $id = $_GET['id'];
}


if( isset( $id ) && $id ){
    $query = "SELECT * FROM `pause_status_logs` where user_id = '$id' order by date_time_created desc limit 1";
    $the_recent_time_status = $insured->db->query($query);

    while ($recent_time_status = $insured->db->fetchByAssoc($the_recent_time_status)) {
        if( isset( $recent_time_status['date_time_created'] ) && $recent_time_status['date_time_created'] ){

            if( ( strtotime( date("Y-m-d")." 00:00:00" ) ) > ( strtotime( date("Y-m-d H:i:s") ) - strtotime( $recent_time_status['date_time_created'] ) ) ){
                echo ( strtotime( date("Y-m-d H:i:s") ) - strtotime( $recent_time_status['date_time_created'] ) );
            } else {
                echo ( strtotime( date("Y-m-d")." 00:00:00" ) );
            }

            
            exit();
        } else {


            echo "0";
            exit();
        }
    }

    //If no record. we must create at least one


    //Log to pause_status_logs
    $pause_status_log_data = array(
        "user_id" => $id,
        "status" => "paused",
        "date_time_created" => date("Y-m-d H:i:s")
    );
    

    $pause_status_log_data_query = "INSERT INTO pause_status_logs ( user_id, status, date_time_created ) VALUES ( '".$pause_status_log_data['user_id']."', '".$pause_status_log_data['status']."', '".$pause_status_log_data['date_time_created']."' ) ";
    $pause_status_log_data_result = $insured->db->query($pause_status_log_data_query);


    echo "0";
    exit();
    

}





?>
