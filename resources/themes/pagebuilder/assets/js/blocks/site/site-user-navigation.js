(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'site-user-navigation',
        category: 'site',
        register({ bm, t, categories }) {
            bm.add('site-user-navigation', {
                label: t('theme::pagebuilder.user_navigation', 'User navigation'),
                category: categories.site,
                content: {
                    type: 'site-user-navigation',
                },
                attributes: { class: 'fa fa-user-circle-o' }
            });
        },
    });
})();
