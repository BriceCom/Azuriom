(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'pb-icon',
        category: 'components',
        register({ bm, t, categories }) {
            bm.add('pb-icon', {
                label: t('theme::pagebuilder.icon', 'Icon'),
                category: categories.components,
                content: '<i data-gjs-type="pb-icon" class="bi bi-house" aria-hidden="true"></i>',
                attributes: { class: 'fa fa-star-o' }
            });
        },
    });
})();
