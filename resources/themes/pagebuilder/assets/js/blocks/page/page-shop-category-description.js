(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'page-shop-category-description',
        category: 'page',
        when: ({ flags }) => !!flags.isShopCategoryPage,
        register({ bm, t, categories }) {
            bm.add('page-shop-category-description', {
                label: t('theme::pagebuilder.page_shop_category_description', 'Shop - Category description'),
                category: categories.page,
                content: `<div data-gjs-type=\"page-shop-category-description\" class=\"alert alert-info mb-0\">${t('theme::pagebuilder.page_component_editor_hint', 'Dynamic page component rendered on site')}</div>`,
                attributes: { class: 'fa fa-align-left' }
            });
        },
    });
})();
