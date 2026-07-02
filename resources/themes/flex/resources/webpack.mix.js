const mix = require('laravel-mix');

const assets = './../assets';
const jsPath = `${assets}/js`;
const imgPath = `${assets}/img`;


mix.disableNotifications()
    .setPublicPath(`${assets}/`)
    .js('js/app.js', jsPath)
    .sass('sass/admin-styles.scss', '/css')
    .sass('sass/styles.scss', '/css')
    .sass('sass/override-bootstrap.scss', '/css')
    .options({
        processCssUrls: false,
        children: false,
    })
    .copyDirectory('js', jsPath)
    .copyDirectory('img', imgPath)
    .version()
    .sourceMaps();
