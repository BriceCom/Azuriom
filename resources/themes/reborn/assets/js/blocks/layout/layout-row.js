(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'layout-row',
        category: 'layout',
        register({ bm, t, categories }) {
            bm.add('layout-row', {
                label: t('theme::pagebuilder.row', 'Row'),
                category: categories.layout,
                content: {
                    type: 'layout-row',
                    classes: ['row', 'g-3'],
                },
                attributes: { class: 'fa fa-th-large' }
            });
        },
    });
})();
