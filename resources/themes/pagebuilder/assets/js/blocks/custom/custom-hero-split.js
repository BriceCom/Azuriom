(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'custom-hero-split',
        category: 'custom',
        register({ bm, t, categories, assets, getImageSource }) {
            const fallbackImage = typeof assets.siteLogoUrl === 'string' && assets.siteLogoUrl.trim() !== ''
                ? assets.siteLogoUrl
                : getImageSource(0, 'Hero');

            bm.add('custom-hero-split', {
                label: t('theme::pagebuilder.custom_hero_split_block', 'Hero split'),
                category: categories.custom,
                content: {
                    type: 'custom-hero-split',
                    attributes: {
                        'data-badge': 'Nouveau',
                        'data-title': 'Construis ton univers Minecraft',
                        'data-subtitle': 'Un bloc hero inspiré des thèmes premium, prêt à personnaliser dans les traits.',
                        'data-primary-label': 'Commencer',
                        'data-primary-url': '#',
                        'data-secondary-label': 'Voir la boutique',
                        'data-secondary-url': '/shop',
                        'data-image-url': fallbackImage,
                    },
                },
                attributes: { class: 'fa fa-star' }
            });
        },
    });
})();
