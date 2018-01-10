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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css').version();
// 复制文件
// mix.copy('node_modules/blueimp-file-upload/css/jquery.fileupload.css', 'public/css/jquery-upload.css');
// mix.scripts([
//     'node_modules/blueimp-file-upload/js/vendor/jquery.ui.widget.js',
//     'node_modules/blueimp-file-upload/js/jquery.iframe-transport.js',
//     'node_modules/blueimp-file-upload/js/jquery.fileupload.js',
// ], 'public/js/jquery-upload.js');