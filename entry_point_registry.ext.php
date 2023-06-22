<?php 
 //WARNING: The contents of this file are auto-generated


  $entry_point_registry['updateIsActive'] = array(
      'file' => 'custom/updateIsActive.php',
      'auth' => true,
  );


$entry_point_registry['AjaxFileUpload'] = array(
	'file' => 'custom/include/SugarFields/Fields/Multifile/entryPointFileUpload.php',
	'auth' => true
);



/*
 * 'SuiteCRM Calculated Fields: Plugin' Created by Taction Software LLC - Copyright 2018
 * Website: www.tactionsoftware.com/
 * Mail: info@tactionsoftware.com
 * @Author:Akanksha Srivastava
 * Description: EntryPoint for Fields and Field Types
 * 
 */
 /*
 * 'SuiteCRM Calculated Fields: Plugin' Created by Taction Software LLC - Copyright 2018
 * Website: www.tactionsoftware.com/
 * Mail: info@tactionsoftware.com
 * @Author:Annulata
 * Description: EntryPoint for Fields and Field Types
 * 
 */
 
    $entry_point_registry['getFields'] = array(
        'file' => 'custom/modules/DynamicFields/get_fields.php',
        'auth' => true
    );
    $entry_point_registry['getFieldType'] = array(
        'file' => 'custom/modules/DynamicFields/get_field_type.php',
        'auth' => true
    );
    $entry_point_registry['subfieldType'] = array(
        'file' => 'custom/modules/DynamicFields/subfield_type.php',
        'auth' => true
    );
   



$entry_point_registry['AsteriskIntegrationController'] = array(
    'file' => 'modules/AsteriskIntegration/EntryPoints/Controller.php',
    'auth' => false,
);

$entry_point_registry['AsteriskIntegrationConfiguration'] = array(
    'file' => 'modules/AsteriskIntegration/EntryPoints/Configuration.php',
    'auth' => false,
);

$entry_point_registry['AsteriskIntegrationUserDetails'] = array(
    'file' => 'modules/AsteriskIntegration/EntryPoints/UserDetails.php',
    'auth' => true,
);

?>