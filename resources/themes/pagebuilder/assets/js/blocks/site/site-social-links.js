(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'site-social-links',
        category: 'site',
        register({ bm, t, categories }) {
            bm.add('site-social-links', {
                label: t('theme::pagebuilder.social_links', 'Social links'),
                category: categories.site,
                content: {
                    type: 'site-social-links',
                },
                attributes: { class: 'fa fa-share-alt' }
            });
        },
    });
})();
