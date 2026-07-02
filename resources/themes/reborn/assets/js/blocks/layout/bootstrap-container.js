(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bootstrap-container',
        category: 'layout',
        register({ bm, t, categories }) {
            bm.add('bootstrap-container', {
                label: t('theme::pagebuilder.container', 'Container'),
                category: categories.layout,
                content: {
                    type: 'container',
                    classes: ['container', 'py-4'],
                },
                attributes: { class: 'fa fa-square-o' }
            });
        },
    });
})();
