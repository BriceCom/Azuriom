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
const assets = './../assets'
const imagePath = assets + '/images'
const fontPath = assets + '/fonts'
const jsPath = assets + '/js'
const pluginsPath = assets + '/plugins'
const cssPath = assets + '/css'

mix.disableNotifications()
    .setPublicPath(assets + '/')
    .js('js/app.js', jsPath)
    .js('js/search.js', jsPath)
    .sass('sass/styles.scss', '/css')
    .sass('sass/override_bootstrap.scss', '/css')
    .options({
        processCssUrls: false,
        children: false,
    })
    .copyDirectory('images', `${imagePath}`)
    .copyDirectory('js/tf', `${jsPath}/tf`)
    .copyDirectory('plugins', `${pluginsPath}`)
    .copyDirectory('fonts/css', `${fontPath}/css`)
    mix.sourceMaps();
