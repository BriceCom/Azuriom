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

const assets = './../assets'
const fontPath = assets + '/css/fonts'
const imagePath = assets + '/images'
const jsPath = assets + '/js'
mix.js('js/app.js', 'js')
    .js('js/admin-config.js', 'js')
    .sass('scss/styles.scss', 'css')
    .sass('scss/style-admin.scss', 'css')
    .options({
        processCssUrls: false,
        autoprefixer: {
            options: {
                browsers: [
                    'last 6 versions',
                ]
            }
        }
    })
    .setPublicPath('./../assets')
    .copyDirectory('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', `${jsPath}`)
    .copyDirectory('images', `${imagePath}`)
    .copyDirectory('fonts', `${fontPath}`)
