<?php

$module_name = 'AsteriskIntegration';
$viewdefs[$module_name] = array(
    'EditView' => array(
        'templateMeta' => array(
            'maxColumns' => '2',
            'widths' => array(
                0 => array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 => array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'useTabs' => true,
            'tabDefs' => array(
                'DEFAULT' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
        ),
        'panels' => array(
            'default' => array(
                0 => array(
                    0 => array(
                        'name' => 'description',
                        'label' => 'LBL_DESCRIPTION',
                        'displayParams' => array(
                            'field' => array(
                                'disabled' => 'disabled',
                            ),
                        ),
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'add_description',
                        'label' => 'LBL_ADD_DESCRIPTION',
                    ),
                    1 => array(
                        'name' => 'disposition',
                        'label' => 'LBL_DISPOSITION',
                    ),
                ),
            ),
        ),
    ),
);
