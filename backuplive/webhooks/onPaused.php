<?php
//echo "test"; exit();

function call_api_universal_v2($method ,$url, $data = false, $auth=false, $content_type = false)
    {

    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data){
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        case "PATCH":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
            if ($data){
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }


    




    $http_header = [];

    if( isset( $content_type ) && $content_type ){
        $http_header[] = $content_type;
    } else {
        $http_header[] = "Content-Type: application/json";
        $http_header[] = "Accept: application/json";
    }
    

    if( isset( $auth ) && $auth ){
        $http_header[] = $auth;
    }


    curl_setopt($curl, CURLOPT_HTTPHEADER, $http_header);
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);



    


    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    //curl_setopt($curl, CURLOPT_PORT, 65535);


    $result = curl_exec($curl);

    $err = curl_error($curl);
    $info = curl_getinfo($curl);

    curl_close($curl);



    if ($err) {
      $error = [];
      $error[] = "failed";
      $error[] = "  cURL Error #:" . $err;
      $error[] = json_encode($info,JSON_PRETTY_PRINT);
      return $error;
      die('');
    } else {
      return $result;
    }
}




















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






$admin_status_collections = [];


$query2 = "
SELECT 
  users.id as user_id,
  admin_paused.admin_status as admin_status
 FROM suitecrm.users
LEFT JOIN suitecrm.admin_paused ON admin_paused.user_id = users.id
";

$query_admin_status = $insured->db->query($query2);

while ($admin_status = $insured->db->fetchByAssoc($query_admin_status)) {

    $admin_status_collections[ $admin_status['user_id'] ] = $admin_status['admin_status'];

}




if( isset( $id ) && $id ){


    if( isset( $admin_status_collections[ $id ] ) && $admin_status_collections[ $id ] == "paused" ){

        echo "Paused by admin, can't unpause right now.";
        exit();
        
    }


    $query = "SELECT * FROM `users` where id = '$id' ";
    $the_users = $insured->db->query($query);
    $user_name = false;

    while ($the_user = $insured->db->fetchByAssoc($the_users)) {
        



        $user_name = $the_user['user_name'];

        $username = "ernesto@withlupine.com";
        $password = "LOIKjuyh1@";
        $get_token_json_data = "grant_type=password&username=".$username."&password=".$password;

        $update_target_data = [];
        $update_target_data['enabled'] = true; // to set continue/enable
        $update_target_data_json = json_encode( $update_target_data );

        $auth = false;
        $bearer_token = false;
        $content_type = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";









        $get_token_result = call_api_universal_v2("POST", "https://api.ringba.com/v2/token", $get_token_json_data, false, $content_type);

        if( $get_token_result ){
            if( is_string( $get_token_result ) ){
                $get_token_result_arr = json_decode( $get_token_result );
                if( is_array( $get_token_result_arr ) && isset( $get_token_result_arr['access_token'] ) && $get_token_result_arr['access_token'] ){
                    $bearer_token = $get_token_result_arr['access_token'];
                } else if( is_object( $get_token_result_arr ) && isset( $get_token_result_arr->access_token ) && $get_token_result_arr->access_token ){
                    $bearer_token = $get_token_result_arr->access_token;
                }
            } else if( is_array( $get_token_result ) || is_object( $get_token_result ) ){
                if( is_array( $get_token_result ) && isset( $get_token_result['access_token'] ) && $get_token_result['access_token'] ){
                    $bearer_token = $get_token_result['access_token'];
                } else if( is_object( $get_token_result ) && isset( $get_token_result->access_token ) && $get_token_result->access_token ){
                    $bearer_token = $get_token_result->access_token;
                }
            }

            if( isset( $bearer_token ) && $bearer_token ){
                $auth = "Authorization: Bearer ".$bearer_token;
            } else {
                echo "Failed to make bearer token";
                exit();
            }

        } else {
            echo "No response from Ringba API";
            exit();
        }






        if( isset( $auth ) && $auth ){
            $account_id = "RA7af82b5bdab142f799b42a602b7dfd4f";

            /* Used to get Account ID, We do it static to save resource
            $get_account_id = call_api_universal_v2("GET", "https://api.ringba.com/v2/ringbaaccounts", false, $auth);
            if( $get_account_id ){
                $get_account_id_result = json_decode( $get_account_id );

                print_r( $get_account_id_result );
                exit();
            }*/



            //Get targets
            $get_targets = call_api_universal_v2("GET", "https://api.ringba.com/v2/".$account_id."/targets", false, $auth);
            if( $get_targets ){
                $get_targets_result = json_decode( $get_targets, true );

                if( isset( $get_targets_result['targets'] ) && is_array( $get_targets_result['targets'] ) && count( $get_targets_result['targets'] ) > 0 ){
                    foreach( $get_targets_result['targets'] as $loop_target ){

                        if( isset( $loop_target['name'] ) && $loop_target['name'] == $user_name ){
                            //The target we have to update
                            $the_target = $loop_target;
                        }
                    }
                } else {
                    echo "Response received, but no targets in the data";
                    exit();
                }
            } else {
                echo "No api response when trying to fetch all targets";
                exit();
            }





            //Update Target
            if( isset( $the_target ) && $the_target && is_array( $the_target ) ){

                $update_target = call_api_universal_v2("PATCH", "https://api.ringba.com/v2/".$account_id."/targets/".$the_target['id'], $update_target_data_json, $auth);

                if( isset( $update_target ) && $update_target ){
                    $update_target_arr = json_decode( $update_target, true );

                    if( isset( $update_target_arr ) && is_array( $update_target_arr ) && isset( $update_target_arr['message'] ) && $update_target_arr['message'] ){
                        echo $update_target_arr['message'];
                        exit();
                    } else {




                        //Log to pause_status_logs
                        $pause_status_log_data = array(
                            "user_id" => $id,
                            "status" => "unpaused",
                            "date_time_created" => date("Y-m-d H:i:s")
                        );
                        

                        $pause_status_log_data_query = "INSERT INTO pause_status_logs ( user_id, status, date_time_created ) VALUES ( '".$pause_status_log_data['user_id']."', '".$pause_status_log_data['status']."', '".$pause_status_log_data['date_time_created']."' ) ";
                        $pause_status_log_data_result = $insured->db->query($pause_status_log_data_query);










                        //ADA01 agent dialer
                        $pause_status_log_data2 = array(
                            "assigned_user_id" => $id,
                            "eventtype" => "ready",
                            "eventtimestamp" => date("Y-m-d H:i:s"),
                            "date_entered" => date("Y-m-d H:i:s"),
                            "date_modified" => date("Y-m-d H:i:s"),
                            'name' => $user_name
                        );
                        

                        $pause_status_log_data_query2 = "INSERT INTO ada01_agent_dialer_activity ( id, name, assigned_user_id, eventtype, eventtimestamp, date_entered, date_modified ) VALUES ( '".create_guid()."', '".$pause_status_log_data2['name']."', '".$pause_status_log_data2['assigned_user_id']."', '".$pause_status_log_data2['eventtype']."', '".$pause_status_log_data2['eventtimestamp']."', '".$pause_status_log_data2['date_entered']."', '".$pause_status_log_data2['date_modified']."' ) ";
                        $pause_status_log_data_result2 = $insured->db->query($pause_status_log_data_query2);





                        //success
                        echo "success";
                        exit();

                    }
                } else {
                    echo "Update target - no response";
                    exit();
                }
            } else {
                echo "Failed to get the target related with CRM logged in user";
                exit();
            }




        } else {
            echo "Failed to make auth creds";
            exit();
        }










    }


    echo "unidentified user id";
    exit();
}





?>
