/* global __dirname */

var net = require('net');
var events = require('events');
var action = require(__dirname + '/action.js');
var namiResponse = require(__dirname + '/response.js');
var util = require('util');
var namiEvents = require(__dirname + '/event.js');
var timer = require('timers');

function Nami(amiData)
{
    var self = this;
    Nami.super_.call(this);
    this.logLevel = 2; // debug level by default.

    var genericLog = function (minLevel, fun, msg)
    {
        if (self.logLevel >= minLevel)
        {
            fun(msg);
        }
    };
    this.logger = amiData.logger || {
        error: function (msg)
        {
            genericLog(0, console.error, msg);
        },
        warn: function (msg)
        {
            genericLog(1, console.warn, msg);
        },
        info: function (msg)
        {
            genericLog(2, console.info, msg);
        },
        debug: function (msg)
        {
            genericLog(3, console.log, msg);
        }
    };
    this.connected = false;
    this.amiData = amiData;
    this.EOL = "\r\n";
    this.EOM = this.EOL + this.EOL;
    this.welcomeMessage = "Asterisk Call Manager/.*" + this.EOL;
    this.received = false;
    this.responses = {};
    this.callbacks = {};
    this.on('namiRawMessage', this.onRawMessage);
    this.on('namiRawResponse', this.onRawResponse);
    this.on('namiRawEvent', this.onRawEvent);
}

// Nami inherits from the EventEmitter so Nami itself can throw events.
util.inherits(Nami, events.EventEmitter);

Nami.prototype.onRawEvent = function (event)
{
    this.logger.debug('Got event: ' + util.inspect(event));
    if (typeof (event.actionid) !== 'undefined' && typeof (this.responses[event.actionid]) !== 'undefined' && typeof (this.callbacks[event.actionid]) !== 'undefined')
    {
        this.responses[event.actionid].events.push(event);
        if (event.event.indexOf('Complete') !== -1 || ((typeof (event.eventlist) !== 'undefined') && event.eventlist.indexOf('Complete') !== -1) || event.event.indexOf('DBGetResponse') !== -1)
        {
            this.callbacks[event.actionid](this.responses[event.actionid]);
            delete this.callbacks[event.actionid];
            delete this.responses[event.actionid];
        }
    }
    else
    {
        this.emit('namiEvent', event);
        this.emit('namiEvent' + event.event, event);
    }
};

Nami.prototype.onRawResponse = function (response)
{
    this.logger.debug('Got response: ' + util.inspect(response));
    if ((typeof (response.message) !== 'undefined') && (response.message.indexOf('follow') !== -1))
    {
        this.responses[response.actionid] = response;
    }
    else if (typeof (this.callbacks[response.actionid]) !== 'undefined')
    {
        this.callbacks[response.actionid](response);
        delete this.callbacks[response.actionid];
        delete this.responses[response.actionid];
    }
};

Nami.prototype.onRawMessage = function (buffer)
{
    var response, event;
    this.logger.debug('Building raw message: ' + util.inspect(buffer));
    if (buffer.match(/^Event: /) !== null)
    {
        event = new namiEvents.Event(buffer);
        this.emit('namiRawEvent', event);
    }
    else if (buffer.match(/^Response: /) !== null)
    {
        response = new namiResponse.Response(buffer);
        this.emit('namiRawResponse', response);
    }
    else
    {
        this.logger.warn("Discarded: |" + buffer + "|");
    }
};

Nami.prototype.onData = function (data)
{
    var theEOM = -1, msg;
    this.logger.debug('Got data: ' + util.inspect(data));
    this.received = this.received.concat(data);
    theEOM = -1;
    while ((theEOM = this.received.indexOf(this.EOM)) !== -1)
    {
        msg = this.received.substr(0, theEOM);
        this.emit('namiRawMessage', msg);
        var startOffset = theEOM + this.EOM.length;
        var skippedEolChars = 0;
        var nextChar = this.received.substr(startOffset + skippedEolChars, 1);
        while (nextChar === "\r" || nextChar === "\n")
        {
            skippedEolChars++;
            nextChar = this.received.substr(startOffset + skippedEolChars, 1);
        }
        ;
        this.logger.debug('Skipped ' + skippedEolChars + ' bytes');
        this.received = this.received.substr(startOffset + skippedEolChars);
    }
};

Nami.prototype.onConnect = function ()
{
    this.connected = true;
};

Nami.prototype.onClosed = function ()
{
    this.connected = false;
};

Nami.prototype.onWelcomeMessage = function (data)
{
    var self = this, welcome;
    this.logger.debug('Got welcome message: ' + util.inspect(data));
    var re = new RegExp(this.welcomeMessage, "");
    if (data.match(re) === null)
    {
        this.emit('namiInvalidPeer', data);
    }
    else
    {
        this.socket.on('data', function (data)
        {
            self.onData(data);
        });
        this.send(
                new action.Login(this.amiData.username, this.amiData.secret),
                function (response)
                {
                    if (response.response !== 'Success')
                    {
                        self.emit('namiLoginIncorrect');
                    }
                    else
                    {
                        self.emit('namiConnected');
                    }
                }
        );
    }
};

Nami.prototype.close = function ()
{
    var self = this;
    this.send(new action.Logoff(), function ()
    {
        self.logger.info('Logged out');
    });
    this.logger.info('Closing connection');
    this.removeAllListeners();
    this.socket.removeAllListeners();
    this.socket.end();
    this.onClosed();
};

Nami.prototype.open = function ()
{
    this.logger.debug('Opening connection');
    this.received = "";
    this.initializeSocket();
};

Nami.prototype.initializeSocket = function ()
{
    this.logger.debug('Initializing socket');
    var self = this;

    if (this.socket && !this.socket.destroyed)
    {
        this.socket.removeAllListeners();
        this.socket.end();
    }

    this.socket = new net.Socket();
    this.socket.setEncoding('ascii');

    var baseEvent = 'namiConnection';

    this.socket.on('connect', function ()
    {
        self.logger.debug('Socket connected');
        self.onConnect();
        var event = {event: 'Connect'};
        self.emit(baseEvent + event.event, event);
    });

    // @param {Error} error Fires right before the `close` event
    this.socket.on('error', function (error)
    {
        self.logger.debug('Socket error: ' + util.inspect(error));
        var event = {event: 'Error', error: error};
        self.emit(baseEvent + event.event, event);
    });

    // @param {Boolean} had_error If the connection closed from an error.
    this.socket.on('close', function (had_error)
    {
        self.logger.debug('Socket closed');
        self.onClosed();
        var event = {event: 'Close', had_error: had_error};
        self.emit(baseEvent + event.event, event);
    });

    this.socket.on('timeout', function ()
    {
        self.logger.debug('Socket timeout');
        var event = {event: 'Timeout'};
        self.emit(baseEvent + event.event, event);
    });

    this.socket.on('end', function ()
    {
        self.logger.debug('Socket ended');
        var event = {event: 'End'};
        self.emit(baseEvent + event.event, event);
    });

    this.socket.once('data', function (data)
    {
        self.onWelcomeMessage(data);
    });

    this.socket.connect(this.amiData.port, this.amiData.host);
};

Nami.prototype.reopen = function ()
{
    this.logger.debug('Reopening connection');
    this.initializeSocket();
};

Nami.prototype.send = function (action, callback)
{
    this.logger.debug('Sending: ' + util.inspect(action));
    this.callbacks[action.ActionID] = callback;
    this.responses[action.ActionID] = "";
    this.socket.write(action.marshall());
};

exports.Nami = Nami;
exports.Actions = action;
exports.Event = namiEvents;
exports.Response = namiResponse;
