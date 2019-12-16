const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.options({
    hmrOptions: {
        host: '192.168.56.1:8300',  // site's host name
    }
});

// fix css files 404 issue
mix.webpackConfig({
    // add any webpack dev server config here
    devServer: {
        proxy       : {
            host: '0.0.0.0',  // host machine ip
            port: 8300,
        },
        watchOptions: {
            aggregateTimeout: 200,
            poll            : 5000
        },
    }
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.browserSync({
    open : 'external', //host:'todayiread.dev',
    proxy: 'localhost:8300',
    port : 8300,
    ui   : false,
    files: [
        'resources/views/**/*.php',
        'app/**/*.php',
        'routes/**/*.php',
        'public/css/app.css',
        'public/js/app.js',
    ]
});
