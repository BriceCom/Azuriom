(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'text',
        category: 'components',
        register({ bm, t, categories }) {
            bm.add('text', {
                label: t('theme::pagebuilder.text', 'Text'),
                category: categories.components,
                content: `<p data-gjs-type=\"text\" class=\"mb-0\">${t('theme::pagebuilder.insert_text_here', 'Insert your text here')}</p>`,
                attributes: { class: 'fa fa-font' }
            });
        },
    });
})();
