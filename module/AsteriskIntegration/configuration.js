function validate_asteriskintegration_server_name(server_name)
{
    server_name = server_name.trim();

    if (!server_name)
    {
        $("#error_asteriskintegration_server_name").html("Please Enter Name");
    }
    else
    {
        $("#error_asteriskintegration_server_name").html("Please Wait, Checking...");

        $.ajax(
        {
            url: "index.php?entryPoint=AsteriskIntegrationConfiguration&action=ValidateServerName&server_name=" + encodeURIComponent(server_name),
            success: function(result)
            {
                var output = JSON.parse(result);
                error_asteriskintegration_server_name = output["error_asteriskintegration_server_name"];
                $("#error_asteriskintegration_server_name").html(error_asteriskintegration_server_name);
            }
        });
    }
}

function validate_asteriskintegration_server_field(key, value)
{
    switch (key)
    {
        case "ami_username":
            if (!value.trim())
            {
                $("#error_asteriskintegration_ami_username").html("Please Enter AMI Username");
            }
            else
            {
                $("#error_asteriskintegration_ami_username").html("");
            }
            break;

        case "ami_secret":
            if (!value.trim())
            {
                $("#error_asteriskintegration_ami_secret").html("Please Enter AMI Secret");
            }
            else
            {
                $("#error_asteriskintegration_ami_secret").html("");
            }
            break;

        case "ami_port":
            if (!value.trim())
            {
                $("#error_asteriskintegration_ami_port").html("Please Enter AMI Port");
            }
            else
            {
                $("#error_asteriskintegration_ami_port").html("");
            }
            break;

        case "recordinglink_ip":
            if (!value.trim())
            {
                $("#error_asteriskintegration_recordinglink_ip").html("Please Enter IP For Recording Link");
            }
            else
            {
                $("#error_asteriskintegration_recordinglink_ip").html("");
            }
            break;

        case "recordinglink_port":
            if (!value.trim())
            {
                $("#error_asteriskintegration_recordinglink_port").html("Please Enter Port For Recording Link");
            }
            else
            {
                $("#error_asteriskintegration_recordinglink_port").html("");
            }
            break;

        default:
            break;
    }
}

function validate_asteriskintegration_socket_port(socket_port)
{
	socket_port = socket_port.trim();

	if (!socket_port)
    {
        $("#error_asteriskintegration_socket_port").html("Please Enter Socket Port");
    }
    else
    {
        $("#error_asteriskintegration_socket_port").html("");
    }

    if (socket_port)
    {
        $("#error_asteriskintegration_socket_port").html("Please Wait, Checking...");

        $.ajax(
        {
            url: "index.php?entryPoint=AsteriskIntegrationConfiguration&action=ValidateSocketPort&socket_port=" + encodeURIComponent(socket_port),
            success: function(result)
            {
                var output = JSON.parse(result);
                error_asteriskintegration_socket_port = output["error_asteriskintegration_socket_port"];

                $("#error_asteriskintegration_socket_port").html(error_asteriskintegration_socket_port);
            }
        });
    }
}

function validate_asteriskintegration_server_ip(server_ip)
{
    server_ip = server_ip.trim();

    if (!server_ip)
    {
        $("#error_asteriskintegration_server_ip").html("Please Enter Server IP");
    }
    else
    {
        $("#error_asteriskintegration_server_ip").html("");
    }

    if (server_ip)
    {
        $("#error_asteriskintegration_server_ip").html("Please Wait, Checking...");

        $.ajax(
        {
            url: "index.php?entryPoint=AsteriskIntegrationConfiguration&action=ValidateServerIP&server_ip=" + encodeURIComponent(server_ip),
            success: function(result)
            {
                var output = JSON.parse(result);
                error_asteriskintegration_server_ip = output["error_asteriskintegration_server_ip"];

                $("#error_asteriskintegration_server_ip").html(error_asteriskintegration_server_ip);
            }
        });
    }
}

function validate_asteriskintegration_check_form()
{
    if (!$.trim($("#error_asteriskintegration_server_name").html()) === false || !$.trim($("#error_asteriskintegration_server_ip").html()) === false || !$.trim($("#error_asteriskintegration_socket_port").html()) === false || !$.trim($("#error_asteriskintegration_ami_username").html()) === false || !$.trim($("#error_asteriskintegration_ami_secret").html()) === false || !$.trim($("#error_asteriskintegration_ami_port").html()) === false || !$.trim($("#error_asteriskintegration_recordinglink_ip").html()) === false || !$.trim($("#error_asteriskintegration_recordinglink_port").html()) === false)
    {
        alert("Warning! Please Resolve Any Error Before Saving");
        return false;
    }
}

function asteriskintegration_delete_server(id)
{
    if (confirm("Are You Sure Want To Delete Asterisk Server?"))
    {
        window.location = "index.php?entryPoint=AsteriskIntegrationConfiguration&action=DeleteServer&id=" + id;
    }
}

function asteriskintegration_service_start(id)
{
    window.location = "index.php?entryPoint=AsteriskIntegrationConfiguration&action=ServiceStart&id=" + id;
}

function asteriskintegration_service_restart(id)
{
    if (confirm("Are You Sure Want To Restart Asterisk Service?"))
    {
        window.location = "index.php?entryPoint=AsteriskIntegrationConfiguration&action=ServiceRestart&id=" + id;
    }
}
