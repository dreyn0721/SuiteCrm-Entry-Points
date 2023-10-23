<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


require_once('modules/Med01_Policy/Med01_Policy.php');
require_once('modules/Med01_Insured/Med01_Insured.php');



class SunfireHook
{
    public function __construct()
    {
    }





    public function call_api_universal_v2($method ,$url, $data = false, $auth=false, $content_type = false)
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
            $http_header = $content_type;
        } else {
            $http_header[] = "Content-Type: application/json";
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
          $error['error'] = "  cURL Error #:" . $err;
          $error[] = json_encode($info,JSON_PRETTY_PRINT);
          return $error;
          die('');
        } else {
          return $result;
        }
    }




    public function submitSunfire(&$bean, $event, $arguments)
    {   
        if( $bean->fetched_row == false ){ //Only new rows



            $policy = new Med01_Policy();
            $insured = new Med01_Insured();


            $lead_id = $bean->id;


                if( isset( $_POST['medicarenumber_c'] ) && $_POST['medicarenumber_c'] && isset( $_POST['fronterrep_c'] ) && $_POST['fronterrep_c'] && isset( $_POST['phone_mobile'] ) && $_POST['phone_mobile'] ){

                    $medicarenumber_c = $_POST['medicarenumber_c'];
                    $fronterrep_c = $_POST['fronterrep_c'];
                    $phone_mobile = preg_replace('/[^0-9]/', '', $_POST['phone_mobile']);
                    if(  preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $phone_mobile,  $matches ) ){ ////// 10 chars ( 222 )

                        $result = '('.$matches[1] . ') ' .$matches[2] . '-' . $matches[3];
                        $phone_mobile = $result;

                    } else if(preg_match( '/^\d(\d{3})(\d{3})(\d{4})$/', $number,  $matches )) { ////// 11 chars ( 1 222  )

                        $result = '('.$matches[1] . ') ' .$matches[2] . '-' . $matches[3];
                        $phone_mobile = $result;

                    } else if(preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $number,  $matches )){ ////// 12 chars ( +1 222 )

                        $result = '('.$matches[1] . ') ' .$matches[2] . '-' . $matches[3];
                        $phone_mobile = $result;

                    }



                    //find related policy, insured and update data
                    $get_related_insured_policy_query = "
                    SELECT 
                    med01_policy.id as policy_id, 
                    med01_insured.id as insured_id

                    FROM suitecrm.med01_policy

                    JOIN suitecrm.med01_insured_med01_policy_c ON med01_policy.id = med01_insured_med01_policy_c.med01_insured_med01_policymed01_policy_idb AND med01_insured_med01_policy_c.deleted = 0
                    JOIN suitecrm.med01_insured ON med01_insured.id = med01_insured_med01_policy_c.med01_insured_med01_policymed01_insured_ida AND med01_insured.deleted = 0

                    WHERE 
                        med01_insured.medicareidnumber = '".$medicarenumber_c."'
                        AND
                        med01_policy.salesrep = '".$fronterrep_c."'
                        AND
                        med01_insured.phone = '".$phone_mobile."'

                    GROUP BY med01_policy.id

                    ";



                    $has_update_policy_string = 'false';
                    $has_update_insured_string = 'false';
                    $updated_insured_ids = [];
                    $updated_policy_ids = [];



                    $get_related_insured_policy = $insured->db->query($get_related_insured_policy_query);

                    while ($the_related_insured_policy = $insured->db->fetchByAssoc($get_related_insured_policy)) {
                        $the_policy_id = $the_related_insured_policy['policy_id'];
                        $the_insured_id = $the_related_insured_policy['insured_id'];




                        //Update fields
                        if( isset( $the_policy_id ) && $the_policy_id ){

                            // sunfiredoctormismatch_c - sunfiredoctormismatch - bolean
                            // fronterrep_c - salesrep - text


                            $has_update_policy = false;





                            $update_policy_query = "UPDATE suitecrm.med01_policy SET ";


                            if( isset( $_POST['sunfiredoctormismatch_c'] ) ){

                                if( $has_update_policy ){
                                    $update_policy_query = $update_policy_query." , ";
                                }

                                $update_policy_query = $update_policy_query." sunfiredoctormismatch = '". $_POST['sunfiredoctormismatch_c'] ."' ";

                                $has_update_policy = true;
                            }



                            if( isset( $_POST['fronterrep_c'] ) ){

                                if( $has_update_policy ){
                                    $update_policy_query = $update_policy_query." , ";
                                }

                                $update_policy_query = $update_policy_query." salesrep = '". $_POST['fronterrep_c'] ."' ";

                                $has_update_policy = true;
                            }




                            if( $has_update_policy ){
                                $has_update_policy_string = "true";
                                $updated_policy_ids[] = $the_policy_id;
                            }



                            $update_policy_query = $update_policy_query." WHERE id = '".$the_policy_id."'";

                            //Submit
                            $update_policy = $policy->db->query($update_policy_query);

                        }




                        //MISING
                        // Leadsexcessiveapplications_c -  bolean
                        // securitypincolor_c - text
                        // prescriptionutilizationreq_c - text
                        


                        

                        //updat fields
                        if( isset( $the_insured_id ) && $the_insured_id ){

                            // partaeffectivedate_c - medicarepartaeffectivedate - ymdhis
                            // partbeffectivedate_c - medicarepartbeffectivedate - ymdhis
                            // subscriberssn_c - subscriberssn - text
                            // medicaidnumber_c - medicaid input
                            // vbcoffer_c - agentvbcoffered 
                            // freelancenotes_c - notes
                            // checkboxforlis_c - lis - bolean

                            $has_update_insured = false;






                            $update_insured_query = "UPDATE suitecrm.med01_insured SET ";


                            if( isset( $_POST['partaeffectivedate_c'] ) ){

                                if( $has_update_insured ){
                                    $update_insured_query = $update_insured_query." , ";
                                }
                                

                                $update_insured_query = $update_insured_query." medicarepartaeffectivedate = '". date("Y-m-d H:i:s", strtotime( $_POST['partaeffectivedate_c'] )) ."' ";

                                $has_update_insured = true;
                            }



                            if( isset( $_POST['partbeffectivedate_c'] ) ){

                                if( $has_update_insured ){
                                    $update_insured_query = $update_insured_query." , ";
                                }

                                $update_insured_query = $update_insured_query." medicarepartbeffectivedate = '". date("Y-m-d H:i:s", strtotime( $_POST['partbeffectivedate_c'] )) ."' ";

                                $has_update_insured = true;
                            }



                            if( isset( $_POST['subscriberssn_c'] ) ){

                                if( $has_update_insured ){
                                    $update_insured_query = $update_insured_query." , ";
                                }

                                $update_insured_query = $update_insured_query." subscriberssn = '". $_POST['subscriberssn_c'] ."' ";
                            }



                            if( isset( $_POST['medicaidnumber_c'] ) ){

                                if( $has_update_insured ){
                                    $update_insured_query = $update_insured_query." , ";
                                }

                                $update_insured_query = $update_insured_query." medicaid = '". $_POST['medicaidnumber_c'] ."' ";

                                $has_update_insured = true;
                            }



                            if( isset( $_POST['vbcoffer_c'] ) ){

                                if( $has_update_insured ){
                                    $update_insured_query = $update_insured_query." , ";
                                }

                                $update_insured_query = $update_insured_query." agentvbcoffered = '". $_POST['vbcoffer_c'] ."' ";
                                
                                $has_update_insured = true;
                            }



                            if( isset( $_POST['freelancenotes_c'] ) ){

                                if( $has_update_insured ){
                                    $update_insured_query = $update_insured_query." , ";
                                }

                                $update_insured_query = $update_insured_query." notes = '". $_POST['freelancenotes_c'] ."' ";
                                
                                $has_update_insured = true;
                            }



                            if( isset( $_POST['checkboxforlis_c'] ) ){

                                if( $has_update_insured ){
                                    $update_insured_query = $update_insured_query." , ";
                                }

                                $update_insured_query = $update_insured_query." lis = '". $_POST['checkboxforlis_c'] ."' ";
                                
                                $has_update_insured = true;
                            }



                            if( $has_update_insured ){
                                $has_update_insured_string = "true";
                                $updated_insured_ids[] = $the_insured_id;
                            }


                            $update_insured_query = $update_insured_query." WHERE id = '".$the_insured_id."'";

                            //Submit
                            $update_insured = $insured->db->query($update_insured_query);

                        }

                    }









                    if( isset( $medicarenumber_c ) && $medicarenumber_c ){
                    } else {
                        $medicarenumber_c = "null";
                    }

                    if( isset( $fronterrep_c ) && $fronterrep_c ){
                    } else {
                        $fronterrep_c = "null";
                    }

                    if( isset( $phone_mobile ) && $phone_mobile ){
                    } else {
                        $phone_mobile = "null";
                    }




                    //Log
                    $lead_update_related_log_query = "INSERT INTO 
                    lead_update_related_log

                    ( 
                        lead_id, 
                        medicarenumber_c, 
                        fronterrep_c, 
                        phone_mobile, 
                        has_update_insured_string, 
                        updated_insured_ids, 
                        has_update_policy_string, 
                        updated_policy_ids, 
                        datetime_created 
                    ) 

                    VALUES 

                    ( 
                        '".$lead_id."', 
                        '".$medicarenumber_c."', 
                        '".$fronterrep_c."', 
                        '".$phone_mobile."', 
                        '".$has_update_insured_string."', 
                        '".json_encode( $updated_insured_ids )."', 
                        '".$has_update_policy_string."', 
                        '".json_encode( $updated_policy_ids )."', 
                        '".date("Y-m-d H:i:s")."'
                    ) ";

                   $lead_update_related_log = $insured->db->query($lead_update_related_log_query);






                }




                // before_save
                ?>

                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Submitting sunfire data</title>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

                    </head>
                    <body>
                    







                        <h2 class="loading-text">Loading Sunfire...</h2>
                        <h3 class="wait-text">Please Wait at least 5 seconds</h3>
                        <!-- <h4>Please allow popup for this website</h4> -->

                        <div style="display: none;">
                            <form action="https://www.sunfirematrix.com/api/prospect" id="theForm" method="post" target="_blank" style="display: none;">
                                
                                <input type="text" name="metadata.partnerId" value="88881940" class="form-control" />
                                <input type="text" name="metadata.app" value="blaze" class="form-control" />
                                <input type="text" name="metadata.appId" value="sunfire" class="form-control" />
                                <input type="text" name="parameters.leadId" value="999111" class="form-control" />


                                <input type="text" name="applicant.firstName" class="form-control" value="<?php 
                                if( isset( $_POST['first_name'] ) && $_POST['first_name'] ): echo $_POST['first_name']; endif; 
                                ?>">

                                <input type="text" name="applicant.lastName" class="form-control" value="<?php 
                                if( isset( $_POST['last_name'] ) && $_POST['last_name'] ): echo $_POST['last_name']; endif; 
                                ?>">

                                <input type="text" name="applicant.partADate.year" class="form-control paedyear" value="<?php 
                                if( isset( $_POST['partaeffectivedate_c'] ) && $_POST['partaeffectivedate_c'] ): echo date("Y", strtotime( $_POST['partaeffectivedate_c'] )); endif; 
                                ?>">

                                <input type="text" name="applicant.partADate.month" class="form-control paedmonth" value="<?php 
                                if( isset( $_POST['partaeffectivedate_c'] ) && $_POST['partaeffectivedate_c'] ): echo date("m", strtotime( $_POST['partaeffectivedate_c'] )); endif; 
                                ?>">

                                <input type="text" name="applicant.partADate.day" class="form-control paedday" value="<?php 
                                if( isset( $_POST['partaeffectivedate_c'] ) && $_POST['partaeffectivedate_c'] ): echo date("d", strtotime( $_POST['partaeffectivedate_c'] )); endif; 
                                ?>">

                                <input type="text" name="applicant.dob.year" class="form-control dobyear" value="<?php 
                                if( isset( $_POST['dob_c'] ) && $_POST['dob_c'] ): echo date("Y", strtotime( $_POST['dob_c'] )); endif; 
                                ?>">
                                
                                <input type="text" name="applicant.dob.month" class="form-control dobmonth" value="<?php 
                                if( isset( $_POST['dob_c'] ) && $_POST['dob_c'] ): echo date("m", strtotime( $_POST['dob_c'] )); endif; 
                                ?>">
                                
                                <input type="text" name="applicant.dob.day" class="form-control dobday" value="<?php 
                                if( isset( $_POST['dob_c'] ) && $_POST['dob_c'] ): echo date("d", strtotime( $_POST['dob_c'] )); endif; 
                                ?>">
                                
                                <input type="text" name="applicant.home.zip" class="form-control" value="<?php 
                                if( isset( $_POST['primaryzippostalcode_c'] ) && $_POST['primaryzippostalcode_c'] ): echo $_POST['primaryzippostalcode_c']; endif; 
                                ?>">

                                <button type="submit" class="btn btn-info sunfireBtn" id="sunfireBtn">Submit</button>

                            </form>
                        </div>



                        <div class="container warning-blocked" style="display: none;">
                            <div class="alert alert-danger">
                                Your browser blocked the pop up, please allow pop up for this website.
                                For now you can click here to manually submit to sunfire
                                <a href="https://scrm.coverageoneinsurance.com/index.php?action=DetailView&module=Leads&record=<?php echo $lead_id; ?>&return_module=Leads&return_action=DetailView&offset=1" class="manual-link btn btn-success" target="_blank">Submit to sunfire</a>
                            </div>
                        </div>

                        <script type="text/javascript">
                        // function sunfireBtn() {
                        //     var sunfireBtn = document.getElementById("sunfireBtn");
                        //    sunfireBtn.click();
                        // }

                        jQuery( document ).ready( function(){


                            setTimeout(function(){
                                console.log("started");
                            }, 2000);







                            

                            jQuery( "#theForm" ).submit();


                            var url = "https://scrm.coverageoneinsurance.com/index.php?action=DetailView&module=Leads&record=<?php echo $lead_id; ?>&return_module=Leads&return_action=DetailView&offset=1";
                            window.open( url , '_self' );

                            


                            /*if (form) {
                                //Browser has allowed it to be opened
                                form.focus();

                                var url = "https://scrm.coverageoneinsurance.com/index.php?action=DetailView&module=Leads&record=<?php echo $lead_id; ?>&return_module=Leads&return_action=DetailView&offset=1";
                                window.open( url , '_self' );

                            } else {*/

                                /*
                                $.ajax({
                                    url:      "https://scrm.coverageoneinsurance.com/index.php?action=DetailView&module=Leads&record=<?php echo $lead_id; ?>&return_module=Leads&return_action=DetailView&offset=1",
                                    async:    false,
                                    dataType: "json",
                                    data:     {},
                                    success:  function(status) {
                                        window.open("https://scrm.coverageoneinsurance.com/index.php?action=DetailView&module=Leads&record=<?php echo $lead_id; ?>&return_module=Leads&return_action=DetailView&offset=1");
                                    }
                                });


                                jQuery(".manual-link").click();*/ 





                                //Browser has blocked it
                                // alert('Please allow popups for this website');
                                // jQuery(".loading-text").hide();
                                // jQuery(".wait-text").hide();
                                // jQuery(".warning-blocked").show();
                            //}





                            jQuery(".manual-link").click( function(){
                                jQuery( "#theForm" ).submit();

                                var url = "https://scrm.coverageoneinsurance.com/index.php?action=DetailView&module=Leads&record=<?php echo $lead_id; ?>&return_module=Leads&return_action=DetailView&offset=1";
                                window.open( url , '_self' );
                            });







                        });

                        </script>

                    </body>
                </html>

                <?php
                sleep(2);
                exit();

                //Redirect after 


    /*
                //https://www.sunfirematrix.com/api/prospect

                $sunfire_postdata = [];

                $sunfire_postdata['metadata'] = [];
                $sunfire_postdata['parameters'] = [];
                $sunfire_postdata['applicant'] = [];


                $sunfire_postdata['metadata']['partnerId'] = "88881940";
                $sunfire_postdata['metadata']['app'] = "blaze";
                $sunfire_postdata['metadata']['appId'] = "sunfire";
                $sunfire_postdata['parameters']['leadId'] = "999111";

                $sunfire_postdata['applicant']['firstName'] = "";
                $sunfire_postdata['applicant']['lastName'] = "";

                //$sunfire_postdata['applicant']['partADate'] = [];
                $sunfire_postdata['applicant']['partADate']['year'] = "";
                $sunfire_postdata['applicant']['partADate']['month'] = "";
                $sunfire_postdata['applicant']['partADate']['day'] = "";

                //$sunfire_postdata['applicant']['dob'] = [];
                $sunfire_postdata['applicant']['dob']['year'] = "";
                $sunfire_postdata['applicant']['dob']['month'] = "";
                $sunfire_postdata['applicant']['dob']['day'] = "";

                //$sunfire_postdata['applicant']['home'] = [];
                $sunfire_postdata['applicant']['home']['zip'] = "";


                echo "<pre>";
                print_r( $sunfire_postdata );
                echo "</pre>";
                exit();*/

        }

    }



}
