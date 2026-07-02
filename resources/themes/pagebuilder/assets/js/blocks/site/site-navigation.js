(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'site-navigation',
        category: 'site',
        register({ bm, t, categories }) {
            bm.add('site-navigation', {
                label: t('theme::pagebuilder.site_navigation', 'Site navigation'),
                category: categories.site,
                content: {
                    type: 'site-navigation',
                },
                attributes: { class: 'fa fa-bars' }
            });
        },
    });
})();
