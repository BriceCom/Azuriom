const mix = require('laravel-mix');
require('laravel-mix-clean');

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
const assets = './../assets';
const jsPath = assets + '/js';
const fontPath = assets + '/fonts';

mix.disableNotifications()
    .setPublicPath(assets + '/')
    .js('js/app.js', jsPath)
    .sass('sass/styles.scss', '/css')
    .sass('sass/override-bootstrap.scss', '/css')
    .options({
        processCssUrls: false,
        children: false,
    })
    .copyDirectory('js', `${jsPath}`)
    .copyDirectory('fonts', `${fontPath}`);

mix.version();
mix.sourceMaps();
