<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

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




    public function testHook(&$bean, $event, $arguments)
    {   

        $lead_id = $bean->id;


            // before_save
            ?>

            <!DOCTYPE html>
            <html>
            <head>
                <title>Submitting sunfire data</title>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

            </head>
            <body>
            







                <h2>Loading Sunfire...</h2>

                <div style="display: none;">
                    <form action="https://www.sunfirematrix.com/api/prospect" id="theForm" target="_blank" method="post" style="display: none;">
                        
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

                <script type="text/javascript">
                // function sunfireBtn() {
                //     var sunfireBtn = document.getElementById("sunfireBtn");
                //    sunfireBtn.click();
                // }

                jQuery( document ).ready( function(){

                    var sunfireForm = jQuery("#theForm");

                    jQuery.ajax({
                    async: false,
                    method: "GET",
                    url: "https://scrm.coverageoneinsurance.com/index.php",
                    data: {
                    },
                    success: function( xhr, status, response ) {
                    },
                    error: function(xhr, status, response) {
                    },
                    statusCode: {
                        404: function(response) {
                        },
                        500: function(response) {
                        }
                    },
                    complete: function( response ){


                        setTimeout(function(){
                            jQuery( sunfireForm ).submit();
                        }, 5000);


                        setTimeout(function(){
                          window.location.href = "https://scrm.coverageoneinsurance.com/index.php?action=DetailView&module=Leads&record=<?php echo $lead_id; ?>&return_module=Leads&return_action=DetailView&offset=1";
                        }, 3000);

                    }
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
