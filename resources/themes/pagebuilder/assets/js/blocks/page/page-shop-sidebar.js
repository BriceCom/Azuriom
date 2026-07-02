(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'page-shop-sidebar',
        category: 'page',
        when: ({ flags }) => !!flags.isShopPage,
        register({ bm, t, categories }) {
            bm.add('page-shop-sidebar', {
                label: t('theme::pagebuilder.page_shop_sidebar', 'Shop - Sidebar'),
                category: categories.page,
                content: `<div data-gjs-type=\"page-shop-sidebar\" class=\"alert alert-info mb-0\">${t('theme::pagebuilder.page_component_editor_hint', 'Dynamic page component rendered on site')}</div>`,
                attributes: { class: 'fa fa-list' }
            });
        },
    });
})();
