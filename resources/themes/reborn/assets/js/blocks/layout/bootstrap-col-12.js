(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bootstrap-col-12',
        category: 'layout',
        register({ bm, t, categories }) {
            bm.add('bootstrap-col-12', {
                label: `${t('theme::pagebuilder.column', 'Column')}-12`,
                category: categories.layout,
                content: {
                    type: 'column',
                    classes: ['col-12'],
                },
                attributes: { class: 'fa fa-columns' }
            });
        },
    });
})();
