(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-badge',
        category: 'components',
        register({ bm, t, categories }) {
            bm.add('bs-badge', {
                label: t('theme::pagebuilder.badge', 'Badge'),
                category: categories.components,
                content: `<span data-gjs-type=\"bs-badge\" class=\"badge text-bg-primary\">${t('theme::pagebuilder.badge_text', 'New')}</span>`,
                attributes: { class: 'fa fa-tag' }
            });
        },
    });
})();
