(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'custom-highlight-shop',
        category: 'custom',
        when: ({ assets }) => !!assets.shopEnabled,
        register({ bm, t, categories, assets }) {
            const shopPackages = Array.isArray(assets.shopPackages) ? assets.shopPackages : [];

            bm.add('custom-highlight-shop', {
                label: 'Article mis en avant',
                category: categories.custom,
                content: {
                    type: 'custom-highlight-shop',
                    attributes: {
                        'data-package-id': String(shopPackages[0]?.id || ''),
                        'data-title': 'Article mis en avant',
                        'data-button-label': 'Voir la boutique',
                    },
                },
                attributes: { class: 'fa fa-shopping-bag' }
            });
        },
    });
})();
