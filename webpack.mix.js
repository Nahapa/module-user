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
mix
    .sass('resources/assets/admin/sass/reset.scss', 'public/assets/admin/css/reset.css')
    .sass('resources/assets/admin/sass/boot.scss', 'public/assets/admin/css/boot.css')
    .sass('resources/assets/admin/sass/login.scss', 'public/assets/admin/css/login.css')
    .sass('resources/assets/admin/sass/style.scss', 'public/assets/admin/css/style.css')

    .styles([
        'resources/assets/admin/js/datatables/css/jquery.datatables.min.css',
        'resources/assets/admin/js/datatables/css/responsive.datatables.min.css',
        'resources/assets/admin/js/select2/css/select2.min.css'
    ], 'public/assets/admin/css/libs.css')

    .scripts([
        'resources/assets/admin/js/jquery.min.js',
        'resources/assets/admin/js/tinymce/tinymce.min.js',
        'resources/assets/admin/js/datatables/js/jquery.dataTables.min.js',
        'resources/assets/admin/js/datatables/js/dataTables.responsive.min.js',
        'resources/assets/admin/js/select2/js/select2.min.js',
        'resources/assets/admin/js/select2/js/i18n/pt-BR.js',
        'resources/assets/admin/js/jquery.form.js',
        'resources/assets/admin/js/jquery.mask.js',
    ], 'public/assets/admin/js/libs.js')

    .scripts('resources/assets/admin/js/login.js', 'public/assets/admin/js/login.js')

    .scripts('resources/assets/admin/js/scripts.js', 'public/assets/admin/js/scripts.js')

    .copyDirectory('resources/assets/admin/css/fonts', 'public/assets/admin/css/fonts')

    .copyDirectory('resources/assets/admin/images', 'public/assets/admin/images')

    .options({
        processCssUrls: false
    })
    .version();
