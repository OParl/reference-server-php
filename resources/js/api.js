Prism.hooks.add('wrap', function(env) {
    if (env.type == 'string', env.content.match(/http/))
    {
        env.content = "<a href=\"" + env.content.replace('"', '') + "\">" + env.content + "</a>";
    }
});

$(document).ready(function()
{

    /*
    $('.token.string').each(function (i, tok)
    {
        if (tok.innerText.match(/http/))
        {
            var url = tok.innerText.replace('"', '');
            $(tok).wrapInner("<a href=\""+url+"\"></a>");
        }
    });
    */
});