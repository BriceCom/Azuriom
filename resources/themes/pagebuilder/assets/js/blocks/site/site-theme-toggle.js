(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'site-theme-toggle',
        category: 'site',
        register({ bm, t, categories }) {
            bm.add('site-theme-toggle', {
                label: t('theme::pagebuilder.theme_toggle', 'Theme toggle'),
                category: categories.site,
                content: {
                    type: 'site-theme-toggle',
                },
                attributes: { class: 'fa fa-adjust' }
            });
        },
    });
})();
