<?php

ini_set("display_errors", false);
error_reporting(0);

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}

$action = $_REQUEST['action'];

switch ($action)
{
    case "ValidateServerName":
        $server_name = trim($_REQUEST['server_name']);

        ValidateServerName($server_name);
        break;

    case "ValidateSocketPort":
        $socket_port = trim($_REQUEST['socket_port']);

        ValidateSocketPort($socket_port);
        break;

    case "ValidateServerIP":
        $server_ip = trim($_GET['server_ip']);
        $socket_port = trim($_GET['socket_port']);

        ValidateServerIP($server_ip, $socket_port);
        break;

    case "DeleteServer":
        $delete_id = $_REQUEST['id'];

        DeleteServer($delete_id);
        break;

    case "ServiceStart":
        $start_id = $_REQUEST['id'];

        ServiceStart($start_id);
        break;

    case "ServiceRestart":
        $restart_id = $_REQUEST['id'];

        ServiceRestart($restart_id);
        break;
}

function ValidateServerName($server_name)
{
    $return = array();
    $return['error_asteriskintegration_server_name'] = "";

    $sql_server_name = "SELECT count(*) AS total_server_name FROM `asteriskintegration_servers` WHERE `name` = '$server_name'";
    $res_server_name = $GLOBALS['db']->query($sql_server_name);
    $row_server_name = $GLOBALS['db']->fetchByAssoc($res_server_name);
    $total_server_name = $row_server_name['total_server_name'];

    if ($total_server_name > 0)
    {
        $return['error_asteriskintegration_server_name'] = "This Server Name Already In Use";
    }

    echo json_encode($return);
}

function ValidateSocketPort($socket_port)
{
    $return = array();

    $return['error_asteriskintegration_socket_port'] = "";

    $sql_socket_port = "SELECT count(*) AS total_socket_port FROM `asteriskintegration_servers` WHERE `socket_port`='$socket_port'";
    $res_socket_port = $GLOBALS['db']->query($sql_socket_port);
    $row_socket_port = $GLOBALS['db']->fetchByAssoc($res_socket_port);
    $total_socket_port = $row_socket_port['total_socket_port'];

    if ($total_socket_port > 0)
    {
        $return['error_asteriskintegration_socket_port'] = "This Socket Port Already In Use";
    }

    echo json_encode($return);
}

function ValidateServerIP($server_ip)
{
    $return = array();
    $return['error_asteriskintegration_server_ip'] = "";

    $sql_server_ip = "SELECT count(*) AS total_server_ip FROM `asteriskintegration_servers` WHERE `server_ip`='$server_ip'";
    $res_server_ip = $GLOBALS['db']->query($sql_server_ip);
    $row_server_ip = $GLOBALS['db']->fetchByAssoc($res_server_ip);
    $total_server_ip = $row_server_ip['total_server_ip'];

    if ($total_server_ip > 0)
    {
        $return['error_asteriskintegration_server_ip'] = "This Server IP Already In Use";
    }

    echo json_encode($return);
}

function DeleteServer($delete_id)
{
    $sql = "DELETE FROM `asteriskintegration_servers` where `id` = '$delete_id'";
    $res = $GLOBALS['db']->query($sql);

    if ($res === true)
    {
        SugarApplication::appendErrorMessage('Asterisk Server Has Been Deleted Successfully');
        header("location: index.php?module=AsteriskIntegration&action=configuration");
    }
}

function ServiceStart($start_id)
{
    $sql = "SELECT * FROM `asteriskintegration_servers` where `id` = '$start_id'";
    $res = $GLOBALS['db']->query($sql);
    $row = $GLOBALS['db']->fetchByAssoc($res);

    $server_ip = $row['server_ip'];
    $ami_port = $row['ami_port'];
    $ami_username = $row['ami_username'];
    $ami_secret = $row['ami_secret'];
    $socket_port = $row['socket_port'];
    $recordinglink_ip = $row['recordinglink_ip'];
    $recordinglink_port = $row['recordinglink_port'];

    if ($res->num_rows == "1")
    {
        shell_exec("bash modules/AsteriskIntegration/server_start.sh '$socket_port' '$server_ip' '$ami_port' '$ami_username' '$ami_secret' '$recordinglink_ip' '$recordinglink_port'");

        SugarApplication::appendErrorMessage('Asterisk Service Has Been Started Successfully');
        header("location: index.php?module=AsteriskIntegration&action=configuration");
    }
}

function ServiceRestart($restart_id)
{
    $sql = "SELECT * FROM `asteriskintegration_servers` where `id` = '$restart_id'";
    $res = $GLOBALS['db']->query($sql);
    $row = $GLOBALS['db']->fetchByAssoc($res);

    $server_ip = $row['server_ip'];
    $ami_port = $row['ami_port'];
    $ami_username = $row['ami_username'];
    $ami_secret = $row['ami_secret'];
    $socket_port = $row['socket_port'];
    $recordinglink_ip = $row['recordinglink_ip'];
    $recordinglink_port = $row['recordinglink_port'];

    if ($res->num_rows == "1")
    {
        shell_exec("bash modules/AsteriskIntegration/server_restart.sh '$socket_port' '$server_ip' '$ami_port' '$ami_username' '$ami_secret' '$recordinglink_ip' '$recordinglink_port'");

        SugarApplication::appendErrorMessage('Asterisk Service Has Been Restarted Successfully');
        header("location: index.php?module=AsteriskIntegration&action=configuration");
    }
}
