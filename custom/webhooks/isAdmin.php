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
    $query = "SELECT * FROM `users` where id = '$id' ";
    $the_users = $insured->db->query($query);

    while ($the_user = $insured->db->fetchByAssoc($the_users)) {
        if( isset( $the_user['is_admin'] ) && $the_user['is_admin'] === "1" ){
            echo "true";
            exit();
        } else {
            echo "false";
            exit();
        }
    }


    echo "unidentified user id";
    exit();
}





?>
