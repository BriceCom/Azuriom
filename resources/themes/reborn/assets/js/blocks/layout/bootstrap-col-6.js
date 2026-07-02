(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bootstrap-col-6',
        category: 'layout',
        register({ bm, t, categories }) {
            bm.add('bootstrap-col-6', {
                label: `${t('theme::pagebuilder.column', 'Column')}-6`,
                category: categories.layout,
                content: {
                    type: 'column',
                    classes: ['col-6'],
                },
                attributes: { class: 'fa fa-columns' }
            });
        },
    });
})();
