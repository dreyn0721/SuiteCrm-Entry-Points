<?php
//echo "test"; exit();





require_once('include/entryPoint.php');


require_once('custom/formula_functions.php');
require_once('modules/Med01_Policy/Med01_Policy.php');
require_once('modules/Med01_Insured/Med01_Insured.php');
require_once('modules/Leads/Lead.php');



//$moduleName = 'Med01_Policy';

// Get the module object
$policy = new Med01_Policy();
$insured = new Med01_Insured();
$lead = new Lead();















//Get relationship Policy
$leads_notes_by_agent_by_medicareid_by_phone = [];
$query_leads_with_custom = "SELECT 
  leads.id AS 'lead_id',
  leads.date_entered AS 'date_created', 
  leads.phone_mobile AS 'phone', 
  leads.phone_home AS 'phone_home', 

  leads_cstm.medicarenumber_c AS 'medicarenumber_c',
  leads_cstm.agent_c AS 'agent_c',
  leads_cstm.freelancenotes_c AS freelancenotes_c

FROM 
  leads 
  LEFT JOIN leads_cstm leads_cstm ON leads.id = leads_cstm.id_c 
WHERE 
  leads.deleted = 0

LIMIT 50
";

$related_leads = $lead->db->query($query_leads_with_custom);

while ($the_relationship_lead = $lead->db->fetchByAssoc($related_leads)) {
    if( $the_relationship_lead['agent_c'] && $the_relationship_lead['medicarenumber_c'] && $the_relationship_lead['phone'] ){
        $leads_notes_by_agent_by_medicareid_by_phone[ strtolower( str_replace("co_", "co", $the_relationship_lead['agent_c']) ) ][ strtolower( $the_relationship_lead['medicarenumber_c'] ) ][ preg_replace( '/[^0-9]/', '', $the_relationship_lead['phone'] ) ] = $the_relationship_lead;
    }
}











// Get all the list, no limit, we only limit the number of to updates
//$query = "SELECT id FROM {$policy->table_name} WHERE DATE_MODIFIED >= DATE_SUB(NOW(), INTERVAL 1 DAY) OR DATE_ENTERED >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$query = "
    SELECT 
    med01_policy.id as policy_id,
    med01_insured.id as insured_id,
    med01_policy.name as name,
    med01_policy.salesrep as salesrep,
    med01_insured.medicareidnumber as medicareidnumber,
    med01_insured.phone as phone,
    med01_insured.notes as notes


    FROM suitecrm.med01_policy

    JOIN suitecrm.med01_insured_med01_policy_c ON med01_policy.id = med01_insured_med01_policy_c.med01_insured_med01_policymed01_policy_idb AND med01_insured_med01_policy_c.deleted = 0
    JOIN suitecrm.med01_insured ON med01_insured.id = med01_insured_med01_policy_c.med01_insured_med01_policymed01_insured_ida AND med01_insured.deleted = 0

    WHERE 
        med01_policy.deleted = 0


    ";

$result = $policy->db->query($query);






$count_rows_remaining = 0;
$update_limit = 10;
$total_rows_updated = 0;

$has_update = false; //zxc
$update_data = []; //zxc
$insured_to_be_updated_ids = [];

while ($row = $policy->db->fetchByAssoc($result)) {
    if( isset( $row['insured_id'] ) && !in_array( $row['insured_id'] , $insured_to_be_updated_ids) ){ // dedupe multiple loops
        if( isset( $row['salesrep'] ) && isset( $row['medicareidnumber'] ) && isset( $row['phone'] ) && $row['salesrep'] && $row['medicareidnumber'] && $row['phone'] ){
            if( 
                isset( $leads_notes_by_agent_by_medicareid_by_phone[ strtolower( $row['salesrep'] ) ][ strtolower( $row['medicareidnumber'] ) ][ preg_replace( '/[^0-9]/', '', $row['phone'] ) ] ) && 
                is_array( $leads_notes_by_agent_by_medicareid_by_phone[ strtolower( $row['salesrep'] ) ][ strtolower( $row['medicareidnumber'] ) ][ preg_replace( '/[^0-9]/', '', $row['phone'] ) ] ) && 
                isset( $leads_notes_by_agent_by_medicareid_by_phone[ strtolower( $row['salesrep'] ) ][ strtolower( $row['medicareidnumber'] ) ][ preg_replace( '/[^0-9]/', '', $row['phone'] ) ]['freelancenotes_c'] ) ){

                $formula = $leads_notes_by_agent_by_medicareid_by_phone[ strtolower( $row['salesrep'] ) ][ strtolower( $row['medicareidnumber'] ) ][ preg_replace( '/[^0-9]/', '', $row['phone'] ) ]['freelancenotes_c'];

                if( isset( $formula ) && ( isset( $row['notes'] ) || is_null( $row['notes'] ) ) ){ //zxc
                    if( (string)$row['notes'] != (string)$formula ){ // if the current value is not the same with the new value, else we don't need to update since it's already correct 
                        
                        $insured_to_be_updated_ids[] = $row['insured_id'];
                        $has_update = true;
                        $update_data[] = '("'.$row['insured_id'].'", "'.$formula.'")';
                        $total_rows_updated++;// Count the total row updated
                        
                    }
                }
            }
        }
    }
}



//mass update zxc
if( isset( $has_update ) && $has_update && isset( $update_data ) && is_array( $update_data ) && count( $update_data ) > 0 ){


    $update_query = "INSERT into {$insured->table_name} (id,notes) VALUES ".implode( ", ", $update_data ) . " ON DUPLICATE KEY UPDATE notes = VALUES(notes) ";

    $result = $insured->db->query($update_query);


    echo $total_rows_updated." total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';


} else {

    echo "0 total rows has been updated<br>";
    echo 'Recently changed or created records updated successfully.';
}





?>
