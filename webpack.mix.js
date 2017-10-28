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

/*
Scripts
    jquery
    bootstrap-sass
    angular
    angular-ui-tree
Styles
    bootstrap
    angular-ui-tree
 */
mix.js('resources/assets/js/app.js', 'public/assets/js')
   .sass('resources/assets/sass/app.scss', 'public/assets/css');

mix.js('resources/assets/js/employees-app.js', 'public/assets/js');
mix.styles([
    'node_modules/angular-ui-tree/dist/angular-ui-tree.css'
], 'public/assets/angular-ui-tree.css');
