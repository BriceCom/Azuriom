(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'custom-cta-ribbon',
        category: 'custom',
        register({ bm, t, categories }) {
            bm.add('custom-cta-ribbon', {
                label: t('theme::pagebuilder.custom_cta_ribbon_block', 'CTA ribbon'),
                category: categories.custom,
                content: {
                    type: 'custom-cta-ribbon',
                    attributes: {
                        'data-icon': 'bi bi-megaphone-fill',
                        'data-title': 'Annonce importante',
                        'data-text': 'Découvre la nouvelle saison et profite des bonus de lancement.',
                        'data-button-label': 'Lire l’annonce',
                        'data-button-url': '/posts',
                    },
                },
                attributes: { class: 'fa fa-bullhorn' }
            });
        },
    });
})();
