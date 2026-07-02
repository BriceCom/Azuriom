(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'site-copyright',
        category: 'site',
        register({ bm, t, categories }) {
            bm.add('site-copyright', {
                label: t('theme::pagebuilder.copyright', 'Copyright'),
                category: categories.site,
                content: {
                    type: 'site-copyright',
                },
                attributes: { class: 'fa fa-copyright' }
            });
        },
    });
})();
