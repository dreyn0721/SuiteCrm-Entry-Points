if (process.argv.length !== 9)
{
    console.log("Use: <socket_port> <server_ip> <ami_port> <ami_username> <ami_password> <recordinglink_ip> <recordinglink_port>");
    process.exit();
}

ai_socket_port = process.argv[2];
ai_server_ip = process.argv[3];
ai_ami_port = process.argv[4];
ai_ami_username = process.argv[5];
ai_ami_secret = process.argv[6];
ai_recordinglink_ip = process.argv[7];
ai_recordinglink_port = process.argv[8];

fs = require('fs');
namilib = require(__dirname + '/nami/nami.js');
http = require('http');
https = require('https');
express = require('express');
socket = require('socket.io');
request = require('request');
syncrequest = require('sync-request');
unixtimestamp = require('unix-timestamp');
app = express();

if (fs.existsSync(__dirname + '/configuration.json'))
{
    configuration = require(__dirname + '/configuration.json');
}
else
{
    console.log("Eror 404 : File not found - configuration.json");
    process.exit();
}

site_url = configuration.site_url;
var ssl_available = false;
var ssl_key;
var ssl_cert;
var ssl_passphrase;
if (configuration.hasOwnProperty("ssl"))
{
    if (configuration.ssl.hasOwnProperty("key") && configuration.ssl.hasOwnProperty("cert"))
    {
        if (configuration.ssl.key !== "" && configuration.ssl.cert !== "")
        {
            ssl_available = true;
            ssl_key = fs.readFileSync(configuration.ssl.key);
            ssl_cert = fs.readFileSync(configuration.ssl.cert);
            ssl_passphrase = configuration.ssl.passphrase;
	        // ssl_key = fs.readFileSync(__dirname + '/ssl/' + configuration.ssl.key);
            // ssl_cert = fs.readFileSync(__dirname + '/ssl/' + configuration.ssl.cert);

            ssl_options = {
                key: ssl_key,
                cert: ssl_cert,
                passphrase: ssl_passphrase,
                requestCert: false,
                rejectUnauthorized: false
            };

            server = https.createServer(ssl_options, app);
            protocol = 'HTTPS';

            process.env.NODE_TLS_REJECT_UNAUTHORIZED = "1";
console.log("if");
        }
        else
        {
            ssl_available = false;

            server = http.createServer(app);
            protocol = 'HTTP';
           console.log("else");
        }
    }
}
else
{
console.log("last else");
    ssl_available = false;
    server = http.createServer(app);
    protocol = 'HTTP';
}

var activation_status;
ActivationStatus();
//var protocol = 'HTTPS';
server.listen(ai_socket_port, function()
{
    console.log('Socket Server Started On Port : ' + ai_socket_port);
    console.log('Socket Server Serves : ' + protocol);
    console.log('Site URL Is : ' + site_url);
});

app.use(express.static(__dirname + '/public'));

io = socket(server);

io.on('connection', (socket) =>
{
    ai_extension = socket.handshake.query.ai_extension;
    socket.join(ai_extension);

    console.log('Client +++, Extension : ' + ai_extension + ', Active : ' + ActiveSocketClientsCount(ai_extension) + ', Socket Id : ' + socket.id);

    socket.on('ClickToCall', function(parameters)
    {
        if (activation_status !== false)
        {
            number = parameters.number.replace(/[ -+*(),./\\&]/g, "");
            extension = parameters.extension;
            context = parameters.context;
            user_id = parameters.user_id;
            module_name = parameters.module_name;
            record_id = parameters.record_id;

            ExtensionStateAction = new namilib.Actions.ExtensionState();
            ExtensionStateAction.ActionID = unixtimestamp.now();
            ExtensionStateAction.Exten = extension;
            ExtensionStateAction.Context = context;

            /* nami.send(ExtensionStateAction, function(response)
            {
                if (response.status === "0")
                {
                    notification = "Pickup The Call On Extension " + extension;
                    notification_type = 'info';

                    notification_event = {
                        notification: notification,
                        notification_type: notification_type
                    }

                    io.sockets.in(extension).emit('Notification', notification_event); */

                    ClickToCallAction = new namilib.Actions.Originate();
                    ClickToCallAction.ActionID = unixtimestamp.now();
                    ClickToCallAction.Channel = "SIP/" + extension;
                    ClickToCallAction.WaitTime = "30";
                    ClickToCallAction.CallerID = number + " <" + extension + ">";
                    ClickToCallAction.Exten = number;
                    ClickToCallAction.Context = context;
                    ClickToCallAction.Priority = 1;
                    ClickToCallAction.Timeout = 99999;

                    if (user_id !== undefined && module_name !== undefined && record_id !== undefined)
                    {
                        url = site_url +
                            '/index.php?entryPoint=AsteriskIntegrationController&action=ClickToCall' +
                            '&user_id=' + encodeURIComponent(user_id) +
                            '&module_name=' + encodeURIComponent(module_name) +
                            '&record_id=' + encodeURIComponent(record_id) +
                            '&number=' + encodeURIComponent(number);

                        if (ssl_available === true)
                        {
                            request.get(
                                {
                                    url: url,
                                    agentOptions:
                                    {
                                        key: ssl_key,
                                        cert: ssl_cert,
                                        passphrase: ssl_passphrase,
                                        securityOptions: 'SSL_OP_NO_SSLv3'
                                    }
                                },
                                function(error, response, data)
                                {
                                    ClickToCall(ClickToCallAction);
                                });
                        }
                        else
                        {
                            request.get(
                                {
                                    url: url
                                },
                                function(error, response, data)
                                {
                                    if (response.statusCode === 200)
                                    {
                                        ClickToCall(ClickToCallAction);
                                    }
                                });
                        }
                    }
                    else
                    {
                        ClickToCall(ClickToCallAction);
                    }
                /* }
                else
                {
                    switch (response.status)
                    {
                        case "-1":
                            notification = "Extension " + extension + " Is Not Found";
                            notification_type = 'error';
                            break;

                        case "1":
                            notification = "Extension " + extension + " Is In Use";
                            notification_type = 'info';
                            break;

                        case "2":
                            notification = "Extension " + extension + " Is Busy";
                            notification_type = 'info';
                            break;

                        case "4":
                            notification = "Extension " + extension + " Is Unavailable";
                            notification_type = 'error';
                            break;

                        case "8":
                            notification = "Extension " + extension + " Is Busy";
                            notification_type = 'info';
                            break;

                        case "16":
                            notification = "Extension " + extension + " Is On Hold";
                            notification_type = 'info';
                            break;

                        default:
                            notification = "Extension " + extension + " Is Not Available";
                            notification_type = 'error';
                            break;
                    }

                    notification_event = {
                        notification: notification,
                        notification_type: notification_type
                    }

                    io.sockets.in(extension).emit('Notification', notification_event);
                }
            }); */
        }
        else
        {
            extension = socket.handshake.query.ai_extension;

            notification_event = {
                notification: 'Please Ask Your Administrator To Validate The License, And Restart Service',
                notification_type: 'error'
            }

            if (ActiveSocketClientsCount(extension) > 0)
            {
                io.sockets.in(extension).emit('Notification', notification_event);
            }
        }
    });

    socket.on('Hangup', function(parameters)
    {
        HangupAction = new namilib.Actions.Hangup();
        HangupAction.Channel = parameters.hangupchannel;

        // console.log(HangupAction);

        nami.send(HangupAction, function(response)
        {
            // console.log(util.inspect(response));
            extension = socket.handshake.query.ai_extension;

            switch (response.response)
            {
                case "Error":
                    notification_event = {
                        notification: 'Call Hangup Has Been Failed,<br/>Or Call Has Been Already Hanged up',
                        notification_type: 'error'
                    }

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        io.sockets.in(extension).emit('Notification', notification_event);
                    }
                    break;

                case "Success":
                    notification_event = {
                        notification: 'Call Hanged up Successfully',
                        notification_type: 'success'
                    }

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        io.sockets.in(extension).emit('Notification', notification_event);
                    }
                    break;
            }
        });
    });

    socket.on('Redirect', function(parameters)
    {
        RedirectAction = new namilib.Actions.Redirect();
        RedirectAction.Channel = parameters.redirectchannel;
        RedirectAction.Exten = parameters.newextension;
        RedirectAction.Context = parameters.context;
        RedirectAction.Priority = 1;

        // console.log(RedirectAction);

        nami.send(RedirectAction, function(response)
        {
            // console.log(util.inspect(response));
            extension = socket.handshake.query.ai_extension;

            switch (response.response)
            {
                case "Error":
                    notification_event = {
                        notification: 'Call Transfer Has Been Failed.<br/>Call Has Been Already Transfered Or Hanged up',
                        notification_type: 'error'
                    }

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        io.sockets.in(extension).emit('Notification', notification_event);
                    }
                    break;

                case "Success":
                    notification_event = {
                        notification: 'Call Transfered Successfully',
                        notification_type: 'success'
                    }

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        io.sockets.in(extension).emit('Notification', notification_event);
                    }
                    break;
            }
        });
    });

    socket.on('CloseCallPopup', function(parameters)
    {
        extension = socket.handshake.query.ai_extension;

        if (ActiveSocketClientsCount(extension) > 0)
        {
            io.sockets.in(extension).emit('CloseCallPopup', parameters);
        }
    });

    socket.on('ToggleOptions', function(parameters)
    {
        extension = socket.handshake.query.ai_extension;

        if (ActiveSocketClientsCount(extension) > 0)
        {
            io.sockets.in(extension).emit('ToggleOptions', parameters);
        }
    });

    socket.on('disconnect', function(data)
    {
        ai_extension = socket.handshake.query.ai_extension;
        socket.leave(ai_extension);
        console.log('Client ---, Extension : ' + ai_extension + ', Active : ' + ActiveSocketClientsCount(ai_extension) + ', Socket Id : ' + socket.id);
    });
});

namiConfig = {
    host: ai_server_ip,
    port: ai_ami_port,
    username: ai_ami_username,
    secret: ai_ami_secret
};

nami = new namilib.Nami(namiConfig);

process.on('SIGINT', function()
{
    nami.close();
    process.exit();
});

nami.on('namiConnectionClose', function(data)
{
    console.log('Reconnecting To Asterisk Server');
    setTimeout(function()
    {
        nami.open();
    }, 5000);
});

nami.on('namiConnected', function(data)
{
    console.log('Connected To Asterisk Server using AMI');
    setTimeout(AsteriskPingAction, 10000);
});

nami.on('namiInvalidPeer', function(data)
{
    console.log("Invalid AMI Salute. Not an AMI?");
    process.exit();
});

nami.on('namiLoginIncorrect', function()
{
    console.log("Invalid Credentials");
    process.exit();
});

nami.on('namiEventDial', function(event)
{
    console.log(event);

    if (activation_status !== false)
    {
        if (event.subevent === "Begin")
        {
            if (/[\/@]/i.test(event.dialstring))
            {
                number = ExtractNumberFromString(event.dialstring);

                if (number.length >= 8)
                {
                    extension = ExtractNumberFromString(event.channel);
                    direction = 'Outbound';

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        url = site_url +
                            '/index.php?entryPoint=AsteriskIntegrationController&action=GetNumberInfo' +
                            '&number=' + encodeURIComponent(number) +
                            '&extension=' + encodeURIComponent(extension) +
                            '&direction=' + encodeURIComponent(direction) +
                            '&uniqueid=' + encodeURIComponent(event.uniqueid) +
                            '&hangup_channel=' + encodeURIComponent(event.channel) +
                            '&redirect_channel=' + encodeURIComponent(event.destination);

                        GetNumberInfo(url);
                    }
                }
            }
            else
            {
                number = ExtractNumberFromString(event.calleridnum);

                if (number.length >= 8)
                {
                    extension = ExtractNumberFromString(event.destination);
                    direction = 'Inbound';

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        url = site_url +
                            '/index.php?entryPoint=AsteriskIntegrationController&action=GetNumberInfo' +
                            '&number=' + encodeURIComponent(number) +
                            '&extension=' + encodeURIComponent(extension) +
                            '&direction=' + encodeURIComponent(direction) +
                            '&uniqueid=' + encodeURIComponent(event.uniqueid) +
                            '&hangup_channel=' + encodeURIComponent(event.destination) +
                            '&redirect_channel=' + encodeURIComponent(event.channel);

                        GetNumberInfo(url);
                    }
                }
            }
        }
    }
});

nami.on('namiEventDialBegin', function(event)
{
    console.dir(event);

    if (activation_status !== false)
    {
        if (typeof event.calleridnum !== 'undefined' && typeof event.destcalleridnum !== 'undefined')
        {
            if (event.destcalleridnum.length < event.connectedlinenum.length && event.dialstring.length > event.destcalleridnum.length)
            {
                extension = ExtractNumberFromString(event.channel);
                number = event.connectedlinenum;
                direction = 'Outbound';

                if (ActiveSocketClientsCount(extension) > 0)
                {
                    url = site_url + '/index.php?entryPoint=AsteriskIntegrationController&action=GetNumberInfo' +
                        '&number=' + encodeURIComponent(number) +
                        '&extension=' + encodeURIComponent(extension) +
                        '&direction=' + encodeURIComponent(direction) +
                        '&uniqueid=' + encodeURIComponent(event.destlinkedid) +
                        '&hangup_channel=' + encodeURIComponent(event.channel) +
                        '&redirect_channel=' + encodeURIComponent(event.destchannel);

                    GetNumberInfo(url);
                }
            }
            else if (event.calleridname.length > event.dialstring.length)
            {
                extension = event.dialstring;
                number = event.calleridname;
                direction = 'Inbound';

                if (ActiveSocketClientsCount(extension) > 0)
                {
                    url = site_url + '/index.php?entryPoint=AsteriskIntegrationController&action=GetNumberInfo' +
                        '&number=' + encodeURIComponent(number) +
                        '&extension=' + encodeURIComponent(extension) +
                        '&direction=' + encodeURIComponent(direction) +
                        '&uniqueid=' + encodeURIComponent(event.uniqueid) +
                        '&hangup_channel=' + encodeURIComponent(event.destchannel) +
                        '&redirect_channel=' + encodeURIComponent(event.channel);

                    GetNumberInfo(url);
                }
            }
        }
    }
});

nami.on('namiEventBridge', function(event)
{
    // console.dir(event);

    if (activation_status !== false)
    {
        if (['Local'].indexOf(event.channel1.split("/")[0]) > -1 && ['SIP'].indexOf(event.channel2.split("/")[0]) > -1)
        {
            if (event.callerid1 !== '' && event.callerid2 !== '')
            {
                number = event.callerid1;

                if (number.length >= 8)
                {
                    extension = ExtractNumberFromString(event.callerid2);
                    direction = 'Outbound';

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        url = site_url + '/index.php?entryPoint=AsteriskIntegrationController&action=GetNumberInfo' +
                            '&number=' + encodeURIComponent(number) +
                            '&extension=' + encodeURIComponent(extension) +
                            '&direction=' + encodeURIComponent(direction) +
                            '&uniqueid=' + encodeURIComponent(event.uniqueid1) +
                            '&hangup_channel=' + encodeURIComponent(event.channel2) +
                            '&redirect_channel=' + encodeURIComponent(event.channel1);

                        GetNumberInfo(url);
                    }
                }
            }
        }
        else if (['DAHDI', 'SIP'].indexOf(event.channel1.split("/")[0]) > -1 && ['DAHDI', 'SIP'].indexOf(event.channel2.split("/")[0]) > -1)
        {
            if (event.callerid1.length > event.callerid2.length)
            {
                number = event.callerid1;
                if (number.length >= 8)
                {
                    extension = ExtractNumberFromString(event.channel2);
                    direction = 'Inbound';

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        url = site_url + '/index.php?entryPoint=AsteriskIntegrationController&action=GetNumberInfo' +
                            '&number=' + encodeURIComponent(number) +
                            '&extension=' + encodeURIComponent(extension) +
                            '&direction=' + encodeURIComponent(direction) +
                            '&uniqueid=' + encodeURIComponent(event.uniqueid1) +
                            '&hangup_channel=' + encodeURIComponent(event.channel2) +
                            '&redirect_channel=' + encodeURIComponent(event.channel1);

                        GetNumberInfo(url);
                    }
                }
            }
            else if (event.callerid1.length < event.callerid2.length)
            {
                number = event.callerid2;
                if (number.length >= 8)
                {
                    extension = ExtractNumberFromString(event.channel1);
                    direction = 'Outbound';

                    if (ActiveSocketClientsCount(extension) > 0)
                    {
                        url = site_url + '/index.php?entryPoint=AsteriskIntegrationController&action=GetNumberInfo' +
                            '&number=' + encodeURIComponent(number) +
                            '&extension=' + encodeURIComponent(extension) +
                            '&direction=' + encodeURIComponent(direction) +
                            '&uniqueid=' + encodeURIComponent(event.uniqueid1) +
                            '&hangup_channel=' + encodeURIComponent(event.channel1) +
                            '&redirect_channel=' + encodeURIComponent(event.channel2);

                        GetNumberInfo(url);
                    }
                }
            }
        }
    }
});

nami.on('namiEventCdr', function(event)
{
    console.dir(event);

    if (activation_status !== false)
    {
        if (['Local'].indexOf(event.channel.split("/")[0]) > -1 && ['SIP'].indexOf(event.destinationchannel.split("/")[0]) > -1)
        {
            if (event.source !== '' && event.destination !== '')
            {
                source = ExtractNumberFromString(event.destinationchannel).substr(-10);
                destination = event.source.substr(-10);
            }
        }
        else if (['DAHDI', 'SIP'].indexOf(event.channel.split("/")[0]) > -1 && ['DAHDI', 'SIP'].indexOf(event.destinationchannel.split("/")[0]) > -1)
        {
            if (event.source.length > event.destination.length)
            {
                source = event.source.substr(-10);
                destination = ExtractNumberFromString(event.destinationchannel).substr(-10);
            }
            else if (event.source.length < event.destination.length)
            {
                source = ExtractNumberFromString(event.channel).substr(-10);
                destination = event.destination.substr(-10);
            }
        }
        if(event.destinationcontext == "from-internal"){
            source = ExtractNumberFromString(event.channel);
            destination = event.destination;
        }
        if (typeof source !== 'undefined' && typeof destination !== 'undefined')
        {
            url = site_url + '/index.php?entryPoint=AsteriskIntegrationController&action=LogCall' +
                '&source=' + encodeURIComponent(source) +
                '&destination=' + encodeURIComponent(destination) +
                '&disposition=' + encodeURIComponent(event.disposition) +
                '&starttime=' + encodeURIComponent(event.answertime) +
                '&duration=' + encodeURIComponent(event.billableseconds) +
                '&uniqueid=' + encodeURIComponent(event.uniqueid) +
                '&server_ip=' + encodeURIComponent(ai_server_ip) +
                '&socket_port=' + encodeURIComponent(ai_socket_port) +
                '&recordinglink_ip=' + encodeURIComponent(ai_recordinglink_ip) +
                '&recordinglink_port=' + encodeURIComponent(ai_recordinglink_port);

            LogCall(url);
        }
    }
});

nami.open();

function GetNumberInfo(url)
{
    console.log(url);
    if (ssl_available === true)
    {
        request.get(
            {
                url: url,
                agentOptions:
                {
                    key: ssl_key,
                    cert: ssl_cert,
                    passphrase: ssl_passphrase,
                    securityOptions: 'SSL_OP_NO_SSLv3'
                }
            },
            function(error, response, data)
            {
                if (response.statusCode === 200)
                {
                    DialEventCallPopup(data);
                }
            });
    }
    else
    {
        request.get(
            {
                url: url
            },
            function(error, response, data)
            {
                if (response.statusCode === 200)
                {
                    DialEventCallPopup(data);
                }
            });
    }
}

function LogCall(url)
{
    console.log(url);

    if (ssl_available === true)
    {
        request.get(
            {
                url: url,
                agentOptions:
                {
                    key: ssl_key,
                    cert: ssl_cert,
                    passphrase: ssl_passphrase,
                    securityOptions: 'SSL_OP_NO_SSLv3'
                }
            },
            function(error, response, data)
            {
                if (response.statusCode === 200)
                {
                    CdrEventCallPopup(data);
                }
            });
    }
    else
    {
        request.get(
            {
                url: url
            },
            function(error, response, data)
            {
                if (response.statusCode === 200)
                {
                    CdrEventCallPopup(data);
                }
            });
    }
}

function ClickToCall(ClickToCallAction)
{
    console.log(ClickToCallAction);
    nami.send(ClickToCallAction, function(response)
    {
        console.log(response);
        switch (response.response)
        {
            case "Success":
                notification = "Outbound Call Has Been Placed To Number " + number + " From Extension " + extension;
                notification_type = "success";
                break;

            default:
                notification = "Outbound Call Request To Number " + number + " From Extension " + extension + " Has Been Failed";
                notification_type = "error";
                break;
        }

        notification_event = {
            notification: notification,
            notification_type: notification_type
        }

        io.sockets.in(extension).emit('Notification', notification_event);
    });
}

function ActivationStatus()
{
    var activation_result = syncrequest('GET', site_url + '/index.php?entryPoint=AsteriskIntegrationController&action=ActivationStatus');
    activation_result_parse = JSON.parse(activation_result.getBody('utf8'));
    activation_status = activation_result_parse.status;
}

function DialEventCallPopup(data)
{
    var isjson = testJSON(data);
     if (isjson === true)
     {	
    dial_event_result = JSON.parse(data);
    console.log(dial_event_result);
    if (dial_event_result != null) {
        if (ActiveSocketClientsCount(dial_event_result.extension) > 0) {
            io.sockets.in(dial_event_result.extension).emit('Dial', dial_event_result);
        }
    }
    }
}

function CdrEventCallPopup(data)
{
    cdr_event_result = JSON.parse(data);

    console.log(cdr_event_result);
    if (cdr_event_result != null) {
        if (ActiveSocketClientsCount(cdr_event_result.extension) > 0) {
            io.sockets.in(cdr_event_result.extension).emit('Cdr', cdr_event_result);
        }
    }
}

function AsteriskPingAction()
{
    PingAction = new namilib.Actions.Ping();
    PingAction.ActionID = unixtimestamp.now();

    nami.send(PingAction, function(response)
    {
        if (response.response === "Success")
        {
            setTimeout(AsteriskPingAction, 10000);
        }
    });
}

function ExtractNumberFromString(string)
{
    if (/[\/]/.test(string))
    {
        string = string.split("/", 2)[1];
    }
    if (/[@]/.test(string))
    {
        string = string.split("@", 1)[0];
    }
    if (/[-]/.test(string))
    {
        string = string.split("-", 1)[0];
    }
    return string;
}

function ActiveSocketClientsCount(extension)
{
    if (io.sockets.adapter.rooms[extension] !== undefined)
    {
        return io.sockets.adapter.rooms[extension].length;
    }
    else
    {
        return 0;
    }
}

function testJSON(text){
    if (typeof text!=="string"){
        return false;
    }
    try{
        var json = JSON.parse(text);
        return (typeof json === 'object');
    }
    catch (error){
        return false;
    }
}
