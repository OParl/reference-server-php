Prism.hooks.add('wrap', function(env) {
    if (env.type == 'string', env.content.match(/http/))
    {
        var url = env.content.replace('"', '');
        url = url.replace("'", '');
        env.content = "<a href=\"" + url + "\">" + env.content + "</a>";
    }
});
