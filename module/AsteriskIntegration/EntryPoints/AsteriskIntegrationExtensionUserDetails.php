<?php

ini_set("display_errors", true);
error_reporting(0);

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}
$nameSearch = $_REQUEST['term'];
$query = "SELECT id, user_name, asteriskintegration_extension FROM users WHERE user_name LIKE '%$nameSearch%'";
$result = $GLOBALS['db']->query($query, false);

$list = array();
$list[''] = '';
$i = 0;
while (($row = $GLOBALS['db']->fetchByAssoc($result)) != null)
{
    $i++;
    $list[] = array("key" => $row['asteriskintegration_extension'],"value" => $row['user_name']." [".$row['asteriskintegration_extension']."]");
    
}
echo json_encode($list);