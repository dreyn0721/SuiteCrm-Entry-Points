<?php

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}

global $current_user;
global $sugar_config;
global $mod_strings;
global $app_strings;

require_once 'modules/AsteriskIntegration/outfitterslicense.php';
if (AsteriskIntegrationOutfitters::isValid("AsteriskIntegration") !== true)
{
    header("location: index.php?module=AsteriskIntegration&action=license");
    die();
}

if (!is_admin($current_user))
{
    sugar_die("Unauthorized access to administration.");
}

if (!file_exists("modules/AsteriskIntegration/configuration.json"))
{
    $config_json_array = array();
    $config_json_array['site_url'] = $sugar_config['site_url'];
    $config_json_array['ssl']['key'] = '';
    $config_json_array['ssl']['cert'] = '';
    $config_json_array['ssl']['passphrase'] = '';

    $config_json = json_encode($config_json_array, JSON_UNESCAPED_SLASHES);

    $fp = fopen("modules/AsteriskIntegration/configuration.json", "w");
    fwrite($fp, $config_json);
    fclose($fp);
}

if (isset($_REQUEST['save_asteriskintegration_settings']))
{
    $server_name = $_REQUEST['server_name'];
    $server_ip = $_REQUEST['server_ip'];
    $ami_port = $_REQUEST['ami_port'];
    $ami_username = $_REQUEST['ami_username'];
    $ami_secret = $_REQUEST['ami_secret'];
    $socket_port = $_REQUEST['socket_port'];
    $recordinglink_ip = $_REQUEST['recordinglink_ip'];
    $recordinglink_port = $_REQUEST['recordinglink_port'];

    $sql = "INSERT INTO `asteriskintegration_servers` (`name`, `server_ip`, `ami_port`, `ami_username`, `ami_secret`, `socket_port`, `recordinglink_ip`, `recordinglink_port`) VALUES ('$server_name', '$server_ip', '$ami_port', '$ami_username', '$ami_secret', '$socket_port', '$recordinglink_ip', '$recordinglink_port')";
    $GLOBALS['db']->query($sql);

    SugarApplication::appendErrorMessage("Asterisk Server Has Been Added Successfully");
    header("location: index.php?module=AsteriskIntegration&action=configuration");
    die();
}

$servers_list = array();

$servers_list_query = "SELECT * FROM `asteriskintegration_servers` ORDER BY `id` ASC";
$servers_list_result = $GLOBALS['db']->query($servers_list_query);

while ($servers_list_row = $GLOBALS['db']->fetchByAssoc($servers_list_result))
{
    $id = $servers_list_row['id'];
    $name = $servers_list_row['name'];
    $server_ip = $servers_list_row['server_ip'];
    $ami_port = $servers_list_row['ami_port'];
    $ami_username = $servers_list_row['ami_username'];
    $ami_secret = $servers_list_row['ami_secret'];
    $socket_port = $servers_list_row['socket_port'];
    $recordinglink_ip = $servers_list_row['recordinglink_ip'];
    $recordinglink_port = $servers_list_row['recordinglink_port'];

    $system_pid = trim(shell_exec("ps aux | grep '[m]odules/AsteriskIntegration/server.js $socket_port $server_ip $ami_port ' | awk '{print\$2}'"));

    $servers_list[$id]['name'] = $name;
    $servers_list[$id]['server_ip'] = $server_ip;
    $servers_list[$id]['ami_port'] = $ami_port;
    $servers_list[$id]['ami_username'] = $ami_username;
    $servers_list[$id]['ami_secret'] = $ami_secret;
    $servers_list[$id]['socket_port'] = $socket_port;
    $servers_list[$id]['recordinglink_ip'] = $recordinglink_ip;
    $servers_list[$id]['recordinglink_port'] = $recordinglink_port;
    $servers_list[$id]['system_pid'] = $system_pid;
}

require_once 'include/Sugar_Smarty.php';
$sugar_smarty = new Sugar_Smarty();

$sugar_smarty->assign('MOD_STRINGS', $mod_strings);
$sugar_smarty->assign('APP_STRINGS', $app_strings);
$sugar_smarty->assign('ASTERISK_INTEGRATION_SERVERS_LIST', $servers_list);

$sugar_smarty->display("modules/AsteriskIntegration/configuration.tpl");
