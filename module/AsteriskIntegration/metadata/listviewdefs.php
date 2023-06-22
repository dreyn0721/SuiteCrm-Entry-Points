<?php

$module_name = 'AsteriskIntegration';
$listViewDefs[$module_name] = array(
    'NAME' => array(
        'type' => 'name',
        'label' => 'LBL_NAME',
        'width' => '10%',
        'default' => true,
    ),
    'NUMBER' => array(
        'type' => 'varchar',
        'label' => 'LBL_NUMBER',
        'width' => '10%',
        'default' => true,
    ),
    'EXTENSION' => array(
        'type' => 'varchar',
        'label' => 'LBL_EXTENSION',
        'width' => '10%',
        'default' => true,
    ),
    'DIRECTION' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DIRECTION',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'DURATION' => array(
        'type' => 'varchar',
        'label' => 'LBL_DURATION',
        'width' => '10%',
        'default' => true,
    ),
    'DISPOSITION' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DISPOSITION',
        'width' => '10%',
        'default' => true,
    ),
    'CALL_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_CALL_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
);
