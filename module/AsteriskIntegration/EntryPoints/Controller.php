<?php

ini_set("display_errors", true);
error_reporting(0);

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}

require_once 'modules/Calls/Call.php';

unset($_REQUEST['entryPoint']);
unset($_REQUEST['module']);

$action = $_REQUEST['action'];

switch ($action)
{
    case "ClickToCall":
        AsteriskIntegrationClickToCallAddToDB();
        break;

    case "GetNumberInfo":
        $number_info = AsteriskIntegrationGetRecordsFromNumber(true);
        echo json_encode($number_info);
        break;

    case "LogCall":
        $log_call_info = AsteriskIntegrationLogCall();
        echo json_encode($log_call_info);
        break;

    case "SaveDescription":
        $save_description_info = AsteriskIntegrationSaveDescription();
        echo json_encode($save_description_info);
        break;

    case "ActivationStatus":
        $activation_status = AsteriskIntegrationActivationStatus();
        echo json_encode($activation_status);
        break;
}
