/* global __dirname */

message = require(__dirname + '/message.js');
util = require('util');

function Response(data)
{
    Response.super_.call(this);
    this.unmarshall(data);
    this.events = [];
}

util.inherits(Response, message.Message);
exports.Response = Response;
