<?php

$module_name = 'AsteriskIntegration';
$viewdefs[$module_name] = array(
    'DetailView' => array(
        'templateMeta' => array(
            'form' => array(
                'buttons' => array(
                    0 => 'EDIT',
                    2 => 'DELETE',
                ),
            ),
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
                        'name' => 'extension',
                        'label' => 'LBL_EXTENSION',
                    ),
                    1 => array(
                        'name' => 'asterisk_server',
                        'studio' => 'visible',
                        'label' => 'LBL_ASTERISK_SERVER',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'number',
                        'label' => 'LBL_NUMBER',
                    ),
                    1 => array(
                        'name' => 'parent_name',
                        'label' => 'LBL_LIST_RELATED_TO',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'description',
                        'label' => 'LBL_DESCRIPTION',
                    ),
                    1 => array(
                        'name' => 'recording_link',
                        'label' => 'LBL_RECORDING_LINK',
                        'customCode' => '<audio controls><source src=\'{$fields.recording_link.value|escape:\'htmlentitydecode\' |escape:\'html\'|strip_tags|url2html|nl2br}\' type=\'audio/wav\'>Audio not supported.</audio>',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'direction',
                        'studio' => 'visible',
                        'label' => 'LBL_DIRECTION',
                    ),
                    1 => array(
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'duration',
                        'label' => 'LBL_DURATION',
                    ),
                    1 => array(
                        'name' => 'call_date',
                        'label' => 'LBL_CALL_DATE',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'disposition',
                        'studio' => 'visible',
                        'label' => 'LBL_DISPOSITION',
                    ),
                    1 => 'assigned_user_name',
                ),
                6 => array(
                    0 => array(
                        'name' => 'date_entered',
                        'label' => 'LBL_DATE_ENTERED',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                    ),
                    1 => array(
                        'name' => 'date_modified',
                        'label' => 'LBL_DATE_MODIFIED',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                    ),
                ),
            ),
        ),
    ),
);
