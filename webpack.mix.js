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

mix.js('resources/assets/admin/js/app.js', 'public/assets/dist/admin/scripts.js')
    .js('resources/assets/book/js/app.js', 'public/assets/dist/book/scripts.js')
    .js('resources/assets/exec/js/app.js', 'public/assets/dist/exec/scripts.js')
    .js('resources/assets/leaderboard/js/app.js', 'public/assets/dist/leaderboard/scripts.js')
    .sass('resources/assets/admin/sass/app.scss', 'public/assets/dist/admin/styles.css')
    .sass('resources/assets/book/sass/app.scss', 'public/assets/dist/book/styles.css')
    .sass('resources/assets/exec/sass/app.scss', 'public/assets/dist/exec/styles.css')
    .sass('resources/assets/leaderboard/sass/app.scss', 'public/assets/dist/leaderboard/styles.css').react();


    //mix.copyDirectory('node_modules/bootstrap/scss', 'resources/assets/admin/sass/bootstrap');
    // //mix.copyDirectory('node_modules/jquery-ui/themes', 'resources/assets/admin/sass/jquery-ui');

    /*
        mix.copyDirectory('node_modules/tinymce/plugins', 'public/assets/vendor/tinymce/plugins');
        mix.copyDirectory('node_modules/tinymce/skins', 'public/assets/vendor/tinymce/skins');
        mix.copyDirectory('node_modules/tinymce/themes', 'public/assets/vendor/tinymce/themes');
        mix.copy('node_modules/tinymce/jquery.tinymce.js', 'public/assets/vendor/tinymce/jquery.tinymce.js');
        mix.copy('node_modules/tinymce/jquery.tinymce.min.js', 'public/assets/vendor/tinymce/jquery.tinymce.min.js');
        mix.copy('node_modules/tinymce/tinymce.js', 'public/assets/vendor/tinymce/tinymce.js');
        mix.copy('node_modules/tinymce/tinymce.min.js', 'public/assets/vendor/tinymce/tinymce.min.js');
    */
