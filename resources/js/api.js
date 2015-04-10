Prism.hooks.add('wrap', function(env) {
    if (env.type == 'string', env.content.match(/http/))
    {
        env.content = "<a href=\"" + env.content.replace('"', '') + "\">" + env.content + "</a>";
    }
});
