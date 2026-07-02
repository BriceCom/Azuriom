const mix = require('laravel-mix');
const TerserPlugin = require("terser-webpack-plugin");
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
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
const imagePath = assets + '/image'
const jsPath = assets + '/js'
const cssPath = assets + '/css'

mix.disableNotifications()
    .setPublicPath(assets + '/')
    .js('js/app.js', jsPath)
    .sass('sass/styles.scss', '/css')
    .options({
        processCssUrls: false,
        children: false,
    })
    .copyDirectory('image', `${imagePath}`)
    .webpackConfig({
        optimization: {
            minimize: true,
            minimizer: [new TerserPlugin()],
        },
        plugins: [
            new CleanWebpackPlugin(),
        ]
    });

if(!mix.inProduction()) {
    mix.sourceMaps();
    mix.webpackConfig({ devtool: 'inline-source-map'})
}
