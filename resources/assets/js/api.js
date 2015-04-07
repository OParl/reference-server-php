$(document).ready(function()
{
    $('.token.string').each(function (i, tok)
    {
        if (tok.innerText.match(/http/))
        {
            var url = tok.innerText.replace('"', '');
            $(tok).wrapInner("<a href=\""+url+"\"></a>");
        }
    });
});