function CustomBlocks(editor) {
    const bm = editor.BlockManager;
    const assets = window.pagebuilderAssets || {};
    const shopEnabled = !!assets.shopEnabled;
    const shopPackages = Array.isArray(assets.shopPackages) ? assets.shopPackages : [];
    const t = (key, fallback = null, params = null) => {
        if (typeof window.trans === 'function') {
            return window.trans(key, params, fallback);
        }

        return fallback ?? key;
    };

    bm.add('custom-html-safe', {
        label: t('theme::pagebuilder.custom_html_safe_block', 'HTML/CSS (safe)'),
        category: t('theme::pagebuilder.custom_components', 'Custom Components'),
        content: {
            type: 'custom-html-safe',
            attributes: {
                'data-html': '<section class="p-4 border rounded-3"><h2 class="h4 mb-2">Titre</h2><p class="mb-0">Votre contenu HTML ici.</p></section>',
                'data-css': '',
            },
        },
        attributes: { class: 'fa fa-code' }
    });

    if (shopEnabled) {
        bm.add('custom-highlight-shop', {
            label: 'Article mis en avant',
            category: t('theme::pagebuilder.custom_components', 'Custom Components'),
            content: {
                type: 'custom-highlight-shop',
                attributes: {
                    'data-package-id': String(shopPackages[0]?.id || ''),
                    'data-title': 'Article mis en avant',
                    'data-button-label': 'Voir la boutique',
                },
            },
            attributes: { class: 'fa fa-shopping-bag' }
        });
    }
}
