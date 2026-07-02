const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

//Min Js
const TerserPlugin = require("terser-webpack-plugin");

const {CleanWebpackPlugin} = require('clean-webpack-plugin');
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

mix.disableNotifications()
    .setPublicPath(assets + '/')
    .js('js/app.js', jsPath)
    .js('js/api.js', jsPath)
    .sass('sass/styles.scss', '/css')
    .sass('sass/override_bootstrap.scss', '/css')
    .options({
        processCssUrls: false,
        children: false,
    })
    .copyDirectory('images', `${imagePath}`)
    .copyDirectory('fonts', `${fontPath}`)
    .copyDirectory('js', `${jsPath}`)
    .webpackConfig({
        devtool: 'source-map',
        plugins: [],
        optimization: {
            minimize: true,
            minimizer: [new TerserPlugin({
                parallel: true,
                terserOptions: {
                    mangle: true,
                }
            }),
                new CssMinimizerPlugin()],
        },
        module: {},
    });

mix.version();
mix.sourceMaps();
