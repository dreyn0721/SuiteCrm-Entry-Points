<?php

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}

global $mod_strings, $app_strings, $sugar_config;

if (ACLController::checkAccess('AsteriskIntegration', 'edit', true))
{
    $module_menu[] = array('index.php?module=AsteriskIntegration&action=EditView&return_module=AsteriskIntegration&return_action=DetailView', $mod_strings['LNK_NEW_RECORD'], 'Add', 'AsteriskIntegration');
}

if (ACLController::checkAccess('AsteriskIntegration', 'list', true))
{
    $module_menu[] = array('index.php?module=AsteriskIntegration&action=index&return_module=AsteriskIntegration&return_action=DetailView', $mod_strings['LNK_LIST'], 'View', 'AsteriskIntegration');
}
