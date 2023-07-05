<?php
//echo "test"; exit();





require_once('include/entryPoint.php');


require_once('custom/formula_functions.php');
require_once('modules/Med01_Policy/Med01_Policy.php');
require_once('modules/Med01_Insured/Med01_Insured.php');
require_once('modules/Med01_CSCases/Med01_CSCases.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$policy = new Med01_Policy();
$insured = new Med01_Insured();
$cscase = new Med01_CSCases();






//collect all insured at 1 query request, so we can grab later. this way we can save resource, instead of requesting query for each
$query_insured = "SELECT id, name FROM {$insured->table_name} ";
$result_insured = $insured->db->query($query_insured);

$related_insured_by_id = [];

while ($the_insured = $insured->db->fetchByAssoc($result_insured)) {
    $related_insured_by_id[ $the_insured['id'] ] = $the_insured;
}






//Get relationship of CSCases - Insured

$related_insured_id_by_cscase_id = [];
$query_cscase_insured_relationship = "SELECT * FROM `med01_insured_med01_cscases_c` ";
$relationship_insured_cscase = $insured->db->query($query_cscase_insured_relationship);

while ($the_relationship_insured_cscase = $insured->db->fetchByAssoc($relationship_insured_cscase)) {
    $related_insured_id_by_cscase_id[ $the_relationship_insured_cscase['med01_insured_med01_cscasesmed01_cscases_idb'] ] = $the_relationship_insured_cscase['med01_insured_med01_cscasesmed01_insured_ida'];
}



// $query_cscase_insured_relationship2 = "SELECT * FROM `med01_insured_med01_cscases_1_c` where deleted != '1' ";
// $relationship_insured_cscase2 = $insured->db->query($query_cscase_insured_relationship2);

// while ($the_relationship_insured_cscase2 = $insured->db->fetchByAssoc($relationship_insured_cscase2)) {
//     $related_insured_id_by_cscase_id[ $the_relationship_insured_cscase2['med01_cscases_med01_insuredmed01_cscases_idb'] ] = $the_relationship_insured_cscase2['med01_cscases_med01_insuredmed01_insured_ida'];
// }









// Get all the list, no limit, we only limit the number of to updates
//$query = "SELECT id FROM {$policy->table_name} WHERE DATE_MODIFIED >= DATE_SUB(NOW(), INTERVAL 1 DAY) OR DATE_ENTERED >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$query = "SELECT id, name FROM {$cscase->table_name} ORDER BY id DESC ";
$result = $cscase->db->query($query);






$count_rows_remaining = 0;
$update_limit = 10;
$total_rows_updated = 0;

$has_update = false; //zxc
$update_data = []; //zxc

while ($row = $cscase->db->fetchByAssoc($result)) {


    if( isset( $related_insured_id_by_cscase_id[ $row['id'] ] ) && $related_insured_id_by_cscase_id[ $row['id'] ] && isset( $related_insured_by_id[ $related_insured_id_by_cscase_id[ $row['id'] ] ] ) && $related_insured_by_id[ $related_insured_id_by_cscase_id[ $row['id'] ] ] ){

        $related_insured_data = $related_insured_by_id[ $related_insured_id_by_cscase_id[ $row['id'] ] ];
        // echo "existed\n";
    } else {
        $related_insured_data = false;
        // echo "not existed\n";

        //insured is required to be accurate, so we will not update if it's missing
        continue;
    }

    

    //$formula = accountName( $row, $related_insured_data );
    if( isset( $related_insured_data['name'] ) && $related_insured_data['name'] ){

        $account_name = $related_insured_data['name'];

        if( isset( $account_name ) && ( isset( $row['name'] ) || is_null( $row['name'] ) ) ){ //zxc
            if( strtolower( str_replace(" ", "", (string)$row['name']) ) != strtolower( str_replace(" ", "", (string)$account_name ) ) ){ // if the current value is not the same with the new value, else we don't need to update since it's already correct //zxc

                
                //zxc
                $has_update = true;
                $update_data[] = '("'.$row['id'].'", "'.$account_name.'")';
                $total_rows_updated++;// Count the total row updated
                
            }
        }
        
    }
}

// exit();

//mass update zxc
if( isset( $has_update ) && $has_update && isset( $update_data ) && is_array( $update_data ) && count( $update_data ) > 0 ){


    $update_query = "INSERT into {$cscase->table_name} (id,name) VALUES ".implode( ", ", $update_data ) . " ON DUPLICATE KEY UPDATE name = VALUES(name) ";

    $result = $cscase->db->query($update_query);


    echo $total_rows_updated." total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';


} else {

    echo "0 total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';
}





?>
