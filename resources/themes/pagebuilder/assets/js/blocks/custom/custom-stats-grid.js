(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'custom-stats-grid',
        category: 'custom',
        register({ bm, t, categories }) {
            bm.add('custom-stats-grid', {
                label: t('theme::pagebuilder.custom_stats_grid_block', 'Stats grid'),
                category: categories.custom,
                content: {
                    type: 'custom-stats-grid',
                    attributes: {
                        'data-title': 'Statistiques du serveur',
                        'data-stat-1-value': '128',
                        'data-stat-1-label': 'Joueurs en ligne',
                        'data-stat-1-icon': 'bi bi-people-fill',
                        'data-stat-2-value': '1 248',
                        'data-stat-2-label': 'Joueurs inscrits',
                        'data-stat-2-icon': 'bi bi-controller',
                        'data-stat-3-value': '99.9%',
                        'data-stat-3-label': 'Uptime',
                        'data-stat-3-icon': 'bi bi-lightning-charge-fill',
                    },
                },
                attributes: { class: 'fa fa-bar-chart' }
            });
        },
    });
})();
