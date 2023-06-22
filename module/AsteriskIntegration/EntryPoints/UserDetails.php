<?php

ini_set("display_errors", true);
error_reporting(1);

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}

global $current_user;

$ai_user_id = $current_user->id;
$ai_show_notification = $current_user->asteriskintegration_show_notification;
$ai_server_ip_socket_port = $current_user->asteriskintegration_server_ip;
$ai_extension = $current_user->asteriskintegration_extension;
$ai_context = $current_user->asteriskintegration_context;

if (!empty($ai_server_ip_socket_port))
{
    list($ai_server_ip, $ai_socket_port) = explode(":", $ai_server_ip_socket_port);
}
else
{
    $ai_server_ip = "";
    $ai_socket_port = "";
}

$ai_user_details_array = array();
$ai_user_details_array['ai_user_id'] = $ai_user_id;
$ai_user_details_array['ai_show_notification'] = $ai_show_notification;
$ai_user_details_array['ai_server_ip'] = $ai_server_ip;
$ai_user_details_array['ai_extension'] = $ai_extension;
$ai_user_details_array['ai_context'] = $ai_context;
$ai_user_details_array['ai_socket_port'] = $ai_socket_port;
$ai_user_details_array['ai_toggle_status'] = "Minimized";

echo json_encode($ai_user_details_array);
die();
