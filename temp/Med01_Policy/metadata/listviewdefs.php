<?php
$module_name = 'Med01_Policy';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'FIRSTMAPLAN' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_FIRSTMAPLAN',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
  'MARXCHECKDATE' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_MARXCHECKDATE',
    'width' => '10%',
    'default' => true,
  ),
  'MARXNEWPLAN' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_MARXNEWPLAN',
    'width' => '10%',
    'default' => true,
  ),
  'DATESUBMITTEDTOVERIFICATION' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_DATESUBMITTEDTOVERIFICATION',
    'width' => '10%',
    'default' => true,
  ),
  'EFFECTIVEDATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_EFFECTIVEDATE',
    'width' => '10%',
    'default' => true,
  ),
  'SALESREP' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_SALESREP',
    'width' => '10%',
    'default' => true,
  ),
  'ENROLLMENTCODE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ENROLLMENTCODE',
    'width' => '10%',
    'default' => true,
  ),
  'CARRIER' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_CARRIER',
    'width' => '10%',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'ISACTIVE' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_ISACTIVE',
    'width' => '10%',
  ),
  'DECLINEREASON' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_DECLINEREASON',
    'width' => '10%',
    'default' => true,
  ),
  'CANCELDATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_CANCELDATE',
    'width' => '10%',
    'default' => true,
  ),
  'LUN' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LUN',
    'width' => '10%',
    'default' => true,
  ),
  'POLICYNUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_POLICYNUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOMERDATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_CUSTOMERDATE',
    'width' => '10%',
    'default' => true,
  ),
  'APPLICATIONACCEPTEDBYCARRIER' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_APPLICATIONACCEPTEDBYCARRIER',
    'width' => '10%',
  ),
);
;
?>
