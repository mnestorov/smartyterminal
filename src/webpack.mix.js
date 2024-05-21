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
mix.setPublicPath('resources/assets/dist');

mix.autoload({
	jquery: ['$', 'window.jQuery', 'jQuery']
});

mix.sass('resources/assets/src/scss/app.scss', 'resources/assets/dist/css/app.css')
    .options({
        processCssUrls: false
    });

mix.ts('resources/assets/src/ts/app.ts', 'resources/assets/dist/js/app.js');
