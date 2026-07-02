function Blocks(editor) {
    const bm = editor.BlockManager;
    const t = (key, fallback = null, params = null) => {
        if (typeof window.trans === 'function') {
            return window.trans(key, params, fallback);
        }

        return fallback ?? key;
    };

    const assets = window.pagebuilderAssets || {};
    const routeName = window.pagebuilderContext?.routeName || '';
    const flags = {
        isVoteHomePage: routeName === 'vote.home',
        isShopHomePage: routeName === 'shop.home',
        isShopCategoryPage: routeName === 'shop.categories.show',
    };
    flags.isShopPage = flags.isShopHomePage || flags.isShopCategoryPage;

    const categoryFallbacks = {
        layout: t('theme::pagebuilder.bootstrap_layout', 'Bootstrap 5 - Layout'),
        components: t('theme::pagebuilder.bootstrap_components', 'Bootstrap 5 - Components'),
        site: t('theme::pagebuilder.base_components', 'Base Components'),
        custom: t('theme::pagebuilder.custom_components', 'Custom Components'),
        page: t('theme::pagebuilder.page_components', 'Page components'),
    };

    const registry = window.pagebuilderBlocks && typeof window.pagebuilderBlocks === 'object'
        ? window.pagebuilderBlocks
        : { categories: {}, items: [] };

    const categoryResolvers = registry.categories && typeof registry.categories === 'object'
        ? registry.categories
        : {};

    const categories = {};
    Object.keys(categoryFallbacks).forEach((categoryKey) => {
        const resolver = categoryResolvers[categoryKey];
        if (typeof resolver === 'function') {
            categories[categoryKey] = resolver({
                t,
                assets,
                routeName,
                flags,
                categoryFallbacks,
            });
        } else {
            categories[categoryKey] = categoryFallbacks[categoryKey];
        }
    });

    const azuriomImages = Array.isArray(assets.azuriomImages) ? assets.azuriomImages : [];
    const uid = (prefix) => `${prefix}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;

    const placeholderImage = (label) => {
        const svg = `<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"1200\" height=\"420\" viewBox=\"0 0 1200 420\"><rect width=\"1200\" height=\"420\" fill=\"#e9ecef\"/><text x=\"600\" y=\"210\" dominant-baseline=\"middle\" text-anchor=\"middle\" fill=\"#6c757d\" font-family=\"Arial, sans-serif\" font-size=\"42\">${label}</text></svg>`;
        return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`;
    };

    const getImageSource = (index, label) => {
        const image = azuriomImages[index];
        if (image && typeof image.url === 'string' && image.url.trim() !== '') {
            return image.url;
        }

        return placeholderImage(label);
    };

    const context = {
        editor,
        bm,
        t,
        assets,
        categories,
        routeName,
        flags,
        uid,
        getImageSource,
    };

    const blocks = Array.isArray(registry.items) ? registry.items : [];
    blocks.forEach((definition) => {
        if (!definition || typeof definition.register !== 'function') {
            return;
        }

        if (typeof definition.when === 'function' && !definition.when(context)) {
            return;
        }

        try {
            definition.register(context);
        } catch (error) {
            console.error(`Unable to register block "${definition.id || 'unknown'}"`, error);
        }
    });
}
