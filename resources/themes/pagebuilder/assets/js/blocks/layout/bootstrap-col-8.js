(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bootstrap-col-8',
        category: 'layout',
        register({ bm, t, categories }) {
            bm.add('bootstrap-col-8', {
                label: `${t('theme::pagebuilder.column', 'Column')}-8`,
                category: categories.layout,
                content: {
                    type: 'column',
                    classes: ['col-8'],
                },
                attributes: { class: 'fa fa-columns' }
            });
        },
    });
})();
