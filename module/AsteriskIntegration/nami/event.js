/* global __dirname */

message = require(__dirname + '/message.js');
util = require('util');

function Event(data)
{
    Event.super_.call(this);
    this.unmarshall(data);
}

util.inherits(Event, message.Message);
exports.Event = Event;
