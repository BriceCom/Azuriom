(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'site-logo',
        category: 'site',
        register({ bm, t, categories }) {
            bm.add('site-logo', {
                label: t('theme::pagebuilder.site_logo', 'Site logo'),
                category: categories.site,
                content: {
                    type: 'site-logo',
                },
                attributes: { class: 'fa fa-picture-o' }
            });
        },
    });
})();
