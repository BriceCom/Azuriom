(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'custom-feature-cards',
        category: 'custom',
        register({ bm, t, categories }) {
            bm.add('custom-feature-cards', {
                label: t('theme::pagebuilder.custom_feature_cards_block', 'Feature cards'),
                category: categories.custom,
                content: {
                    type: 'custom-feature-cards',
                    attributes: {
                        'data-title': 'Pourquoi nous rejoindre ?',
                        'data-subtitle': 'Structure inspirée de Pomodoro / Kurt / Nomad.',
                        'data-feature-1-icon': 'bi bi-shield-check',
                        'data-feature-1-title': 'Anti-cheat',
                        'data-feature-1-text': 'Protection active et modération réactive.',
                        'data-feature-2-icon': 'bi bi-stars',
                        'data-feature-2-title': 'Quêtes uniques',
                        'data-feature-2-text': 'Progression RPG, récompenses et événements.',
                        'data-feature-3-icon': 'bi bi-people',
                        'data-feature-3-title': 'Communauté',
                        'data-feature-3-text': 'Staff présent et entraide entre joueurs.',
                        'data-feature-4-icon': 'bi bi-trophy',
                        'data-feature-4-title': 'Compétitions',
                        'data-feature-4-text': 'Saisons classées, tournois et lots.',
                    },
                },
                attributes: { class: 'fa fa-th-large' }
            });
        },
    });
})();
