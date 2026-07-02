(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bootstrap-col-3',
        category: 'layout',
        register({ bm, t, categories }) {
            bm.add('bootstrap-col-3', {
                label: `${t('theme::pagebuilder.column', 'Column')}-3`,
                category: categories.layout,
                content: {
                    type: 'column',
                    classes: ['col-3'],
                },
                attributes: { class: 'fa fa-columns' }
            });
        },
    });
})();
