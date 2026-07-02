(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'page-shop-home',
        category: 'page',
        when: ({ flags }) => !!flags.isShopHomePage,
        register({ bm, t, categories }) {
            bm.add('page-shop-home', {
                label: t('theme::pagebuilder.page_shop_home_welcome', 'Shop - Home welcome'),
                category: categories.page,
                content: `<div data-gjs-type=\"page-shop-home\" class=\"alert alert-info mb-0\">${t('theme::pagebuilder.page_component_editor_hint', 'Dynamic page component rendered on site')}</div>`,
                attributes: { class: 'fa fa-home' }
            });
        },
    });
})();
