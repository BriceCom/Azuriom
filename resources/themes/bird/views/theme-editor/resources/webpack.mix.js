const mix = require('laravel-mix');

const assets = '../../../assets';
const jsPath = `${assets}/js`;
const imgPath = `${assets}/img`;
const themeEditorRuntimePath = `${jsPath}/theme-editor`;


mix.disableNotifications()
    .setPublicPath(`${assets}/`)
    .js('js/app.js', jsPath)
    .sass('sass/styles.scss', '/css')
    .sass('sass/override-bootstrap.scss', '/css')
    .options({
        processCssUrls: false,
        children: false,
    })
    .copyDirectory('js/admin', `${jsPath}/admin`)
    .copy('js/copyboard.js', `${jsPath}/copyboard.js`)
    .copy('js/counters.js', `${jsPath}/counters.js`)
    .copy('js/discord.js', `${jsPath}/discord.js`)
    .copy('js/particles.js', `${jsPath}/particles.js`)
    .copyDirectory('js/theme-editor', themeEditorRuntimePath)
    .copyDirectory('img', imgPath)
    .version()
    .sourceMaps();
