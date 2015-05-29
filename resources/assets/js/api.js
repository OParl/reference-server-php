Prism.hooks.add('wrap', function(env) {
    if (env.type == 'string' && env.content.match(/http/))
    {
        var url = env.content.replace('"', '');
        url = url.replace("'", '');
        env.content = "<a href=\"" + url + "\">" + env.content + "</a>";
    }
});

$(document).ready(function () {
    $('.tab-content a[data-toggle=tab]').each(function () {
        $(this).on('click', function (event) {
            event.preventDefault();
            $('.main .nav-tabs a[href='+$(this).attr('href')+"]").tab('show');
            return false;
        })
    });
});
