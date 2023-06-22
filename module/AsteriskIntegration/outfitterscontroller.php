<?php

if (empty($_REQUEST['method']))
{
    header('HTTP/1.1 400 Bad Request');
    $response = "method is required.";
    $json = getJSONobj();
    echo $json->encode($response);
}

//load license validation config
global $currentModule;
require_once 'modules/' . $currentModule . '/outfitterslicense.php';

if ($_REQUEST['method'] == 'validate')
{
    AsteriskIntegrationOutfitters::validate();
}
else if ($_REQUEST['method'] == 'change')
{
    AsteriskIntegrationOutfitters::change();
}
else if ($_REQUEST['method'] == 'add')
{
    AsteriskIntegrationOutfitters::add();
}
else if ($_REQUEST['method'] == 'test')
{
    $user_id = null;
    if (!empty($_REQUEST['user_id']))
    {
        $user_id = $_REQUEST['user_id'];
    }
    $validate_license = AsteriskIntegrationOutfitters::isValid($currentModule, $user_id, true);

    if ($validate_license !== true)
    {

        echo "License did NOT validate.<br/><br/>Reason: " . $validate_license;

        $validated = AsteriskIntegrationOutfitters::doValidate($currentModule);

        if (is_array($validated['result']))
        {
            echo "<br/><br/>Key validation = " . !empty($validated['result']['validated']);
            require 'modules/' . $currentModule . '/outfittersconfig.php';

            if ($outfitters_config['validate_users'] == true)
            {
                echo "<br/>User validation = " . !empty($validated['result']['validated_users']);
                echo "<br/>Licensed User Count = " . $validated['result']['licensed_user_count'];
                echo "<br/>Current User Count = " . $validated['result']['user_count'];

                if ($validated['result']['user_count'] > $validated['result']['licensed_user_count'])
                {
                    echo "<br/><br/>Additional Users Required = " . ($validated['result']['user_count'] - $validated['result']['licensed_user_count']);
                }
            }
        }

    }
    else
    {
        echo "License validated";
    }
}
