const {mix} = require('laravel-mix');

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
    processCssUrls: false
}).styles(['resources/css/back_2.css', 'resources/css/trix.css',], 'publishable/ZoroasterCss.css')
    .scripts(['resources/js/trix.js', 'resources/js/uikit.js', 'resources/js/uikit-icons.js'], 'publishable/ZoroasterJs.js')
    .scripts(['resources/js/jquery.js'], 'publishable/jquery.js');
