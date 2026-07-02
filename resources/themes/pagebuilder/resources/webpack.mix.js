const mix = require('laravel-mix');

const assets = './../assets';
const jsPath = `${assets}/js`;


mix.disableNotifications()
    .setPublicPath(`${assets}/`)
    .js('js/app.js', jsPath)
    .options({
        processCssUrls: false,
        children: false,
    })
    .version()
    .sourceMaps();
