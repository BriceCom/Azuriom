(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'page-shop-category-packages',
        category: 'page',
        when: ({ flags }) => !!flags.isShopCategoryPage,
        register({ bm, t, categories }) {
            bm.add('page-shop-category-packages', {
                label: t('theme::pagebuilder.page_shop_category_packages', 'Shop - Package grid'),
                category: categories.page,
                content: `<div data-gjs-type=\"page-shop-category-packages\" class=\"alert alert-info mb-0\">${t('theme::pagebuilder.page_component_editor_hint', 'Dynamic page component rendered on site')}</div>`,
                attributes: { class: 'fa fa-shopping-bag' }
            });
        },
    });
})();
