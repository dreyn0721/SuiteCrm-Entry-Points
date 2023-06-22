function Message()
{
    this_lines = [];
    this_EOL = "\r\n";
    this_variables = {};
}

Message.prototype.marshall = function ()
{
    var output = "", key;
    for (key in this)
    {
        if (key === 'variables')
        {
            continue;
        }
        if (this.hasOwnProperty(key))
        {
            if (key !== 'lines' && key !== 'EOL' && (typeof (this[key]) !== 'function'))
            {
                output = output + key + ": " + this[key] + this_EOL;
            }
        }
    }
    for (key in this_variables)
    {
        output = output + 'Variable: ' + key + '=' + this_variables[key] + this_EOL;
    }
    output = output + this_EOL;
    return output;
};

Message.prototype.unmarshall = function (data)
{
    var value, parts, key, line = 0;
    this_lines = data.split(this_EOL);
    for (; line < this_lines.length; line = line + 1)
    {
        parts = this_lines[line].split(":");
        key = parts.shift();

        if (parts.length > 1)
        {
            value = parts.join(':');
        }
        else if (parts.length === 1)
        {
            value = parts[0];
        }
        var keySafe = key.replace(/-/, '_').toLowerCase();
        var valueSafe = value.replace(/^\s+/g, '').replace(/\s+$/g, '');

        if (keySafe.match(/variable/) !== null && valueSafe.match(/=/) !== null)
        {
            var variable = valueSafe.split("=");
            this_variables[variable[0]] = variable[1];
        }
        else
        {
            this.set(keySafe, valueSafe);
        }
    }
};

Message.prototype.set = function (name, value)
{
    this[name] = value;
};

Message.prototype.get = function (name)
{
    return this[name];
};

exports.Message = Message;
