var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.scripts(['prism.js', 'api.js'], 'public/js/api.js');
    mix.scripts([
        '../bower_components/angular/angular.js',
        '../bower_components/angular-loading-bar/src/loading-bar.js',
        'client/client.js'
    ], 'public/js/client.js');

    mix.less('api.less');
    mix.less('client.less');
});
