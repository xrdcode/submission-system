var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// elixir(function(mix) {
//     mix.styles([
//         "font-awesome.min.css",
//         "bootstrap.min.css",
//         "app.css"
//     ], 'public/css/all.css').version("public/css/all.css");
// });


elixir(function(mix) {
    mix.scripts([
        "ajaxcall.js",
        "general.js",
    ], 'public/js/ssmath.js');//.version("public/js/ssmath.js");
});

elixir(function(mix) {
   mix.scripts([
       "bootflat-admin/site.min.js"
   ],'public/js/bf-admin.js');
});

elixir(function(mix) {
    mix.sass([
        'app.scss',
    ], 'public/css/app.css');
});

elixir(function(mix) {
    mix.sass([
        'bootstrap.scss',
    ], 'public/css/bootstrap.css');
});

elixir(function(mix) {
    mix.styles([
        'bootflat-admin/site.min.css',
    ], 'public/css/sites.css');
});

elixir(function(mix) {
    mix.copy([
        'node_modules/bootstrap-sass/assets/fonts',
    ], 'public/css/fonts');
});

elixir(function(mix) {
   mix.copy([
       'resources/assets/bootflat-admin'
   ], 'public/bootflat-admin');
});
