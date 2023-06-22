<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $app_strings;

$dashletMeta['AsteriskIntegrationDashlet'] = array(
    'module' => 'AsteriskIntegration',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'AsteriskIntegration'),
    'description' => 'A customizable view into AsteriskIntegration',
    'category' => 'Module Views'
);