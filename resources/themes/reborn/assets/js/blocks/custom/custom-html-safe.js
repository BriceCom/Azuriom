(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'custom-html-safe',
        category: 'custom',
        register({ bm, t, categories }) {
            bm.add('custom-html-safe', {
                label: t('theme::pagebuilder.custom_html_safe_block', 'HTML/CSS (safe)'),
                category: categories.custom,
                content: {
                    type: 'custom-html-safe',
                    attributes: {
                        'data-html': '<section class="p-4 border rounded-3"><h2 class="h4 mb-2">Titre</h2><p class="mb-0">Votre contenu HTML ici.</p></section>',
                        'data-css': '',
                    },
                },
                attributes: { class: 'fa fa-code' }
            });
        },
    });
})();
