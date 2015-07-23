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
    mix.scripts([
        // Prism.js for code highlighting
        'bower_components/prism/prism.js',

        'bower_components/prism/components/prism-bash.js',
        'bower_components/prism/components/prism-javascript.js',
        'bower_components/prism/components/prism-php.js',
        'bower_components/prism/components/prism-php-extras.js',
        'bower_components/prism/components/prism-python.js',

        'assets/js/api.js'
    ], 'public/js/api.js', 'resources');

    mix.less('api.less', 'api.css');
});
