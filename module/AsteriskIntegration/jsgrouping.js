jQuery.getScript('modules/AsteriskIntegration/prompt-boxes/prompt-boxes.js', function ()
{
    jQuery('<link>').appendTo('head').attr({
        type: 'text/css',
        rel: 'stylesheet',
        href: 'modules/AsteriskIntegration/prompt-boxes/prompt-boxes.css'
    });
});

jQuery.getScript('modules/AsteriskIntegration/socket.io.js', function ()
{
    jQuery('<link>').appendTo('head').attr({
        type: 'text/css',
        rel: 'stylesheet',
        href: 'modules/AsteriskIntegration/style.css'
    });

    jQuery.getScript('modules/AsteriskIntegration/client.js');
});