let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/vendor/js')
   .js('resources/assets/js/employees-app.js', 'public/vendor/js')
   .sass('resources/assets/sass/app.scss', 'public/vendor/css');

mix.styles([
    'node_modules/angular-ui-tree/dist/angular-ui-tree.css'
], 'public/vendor/angular-ui-tree.css');
