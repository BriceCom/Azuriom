function CustomComponents(editor) {
    const dc = editor.DomComponents;
    const assets = window.pagebuilderAssets || {};
    const shopEnabled = !!assets.shopEnabled;
    const shopPackages = Array.isArray(assets.shopPackages) ? assets.shopPackages : [];
    const siteName = typeof assets.siteName === 'string' && assets.siteName.trim() !== ''
        ? assets.siteName.trim()
        : 'Azuriom';
    const siteLogoUrl = typeof assets.siteLogoUrl === 'string' && assets.siteLogoUrl.trim() !== ''
        ? assets.siteLogoUrl.trim()
        : '';
    const defaultVisual = Array.isArray(assets.azuriomImages) && assets.azuriomImages[0]?.url
        ? assets.azuriomImages[0].url
        : siteLogoUrl;

    const t = (key, fallback = null, params = null) => {
        if (typeof window.trans === 'function') {
            return window.trans(key, params, fallback);
        }

        return fallback ?? key;
    };

    const escapeHtml = (value) => {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    };

    const sanitizeUrl = (value, fallback = '#') => {
        const raw = String(value ?? '').trim();
        if (raw === '') {
            return fallback;
        }

        const normalized = raw.replace(/\s+/g, '').toLowerCase();
        if (/^(javascript:|vbscript:|data:)/.test(normalized)) {
            return fallback;
        }

        if (
            raw.startsWith('#')
            || raw.startsWith('/')
            || raw.startsWith('./')
            || raw.startsWith('../')
        ) {
            return raw;
        }

        if (/^(https?:|mailto:|tel:)/i.test(raw)) {
            return raw;
        }

        return fallback;
    };

    const normalizeIconClass = (value, fallback = 'bi bi-star-fill') => {
        const raw = String(value ?? '').trim();
        if (raw === '' || /[^a-z0-9\-_ ]/i.test(raw)) {
            return fallback;
        }

        if (raw.startsWith('bi bi-')) {
            return raw;
        }

        if (raw.startsWith('bi-')) {
            return `bi ${raw}`;
        }

        if (raw.startsWith('bi ')) {
            return raw;
        }

        return `bi ${raw}`;
    };

    const lockChildrenTree = (model) => {
        const children = model.components?.();
        if (!children || !Array.isArray(children.models)) {
            return;
        }

        children.models.forEach((child) => {
            child.set({
                selectable: false,
                hoverable: false,
                editable: false,
                copyable: false,
                draggable: false,
                removable: false,
                layerable: false,
                badgable: false,
                highlightable: false,
            }, { silent: true });

            lockChildrenTree(child);
        });
    };

    const stripUnsafeMarkup = (value) => {
        return String(value ?? '')
            .replace(/<script[\s\S]*?>[\s\S]*?<\/script>/gi, '')
            .replace(/<iframe[\s\S]*?>[\s\S]*?<\/iframe>/gi, '')
            .replace(/<object[\s\S]*?>[\s\S]*?<\/object>/gi, '')
            .replace(/<embed[\s\S]*?>[\s\S]*?<\/embed>/gi, '')
            .replace(/\son[a-z0-9_-]+\s*=\s*(".*?"|'.*?'|[^\s>]+)/gi, '')
            .replace(/\s(href|src)\s*=\s*("|\')\s*(javascript:|vbscript:|data:).*?\2/gi, '');
    };

    const toPreviewText = (value, maxLength = 320) => {
        const normalized = String(value ?? '')
            .replace(/<[^>]+>/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();

        if (normalized.length <= maxLength) {
            return normalized;
        }

        return `${normalized.slice(0, maxLength - 1)}…`;
    };

    const customShopPackageOptions = [
        { value: '', name: 'Choisir un article...' },
        ...shopPackages.map((pkg) => ({
            value: String(pkg.id),
            name: `${pkg.name} (#${pkg.id})`,
        })),
    ];

    const defaultSafeHtml = '<section class="p-4 border rounded-3"><h2 class="h4 mb-2">Titre</h2><p class="mb-0">Votre contenu HTML ici.</p></section>';

    dc.addType('custom-html-safe', {
        isComponent: (element) => {
            if (element?.getAttribute?.('data-gjs-type') === 'custom-html-safe') {
                return { type: 'custom-html-safe' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'div',
                name: t('theme::pagebuilder.custom_html_safe_block', 'HTML/CSS (safe)'),
                droppable: false,
                editable: false,
                classes: ['pb-custom-html-safe', 'border', 'rounded-3'],
                attributes: {
                    'data-html': defaultSafeHtml,
                    'data-css': '',
                },
                traits: [
                    {
                        type: 'pb-textarea',
                        label: t('theme::pagebuilder.custom_html_safe_html', 'HTML'),
                        name: 'data-html',
                        rows: 12,
                        placeholder: '<div class="p-3">...</div>',
                    },
                    {
                        type: 'pb-textarea',
                        label: t('theme::pagebuilder.custom_html_safe_css', 'CSS'),
                        name: 'data-css',
                        rows: 10,
                        placeholder: '.selector { color: #0d6efd; }',
                    },
                ],
            },
            init() {
                this.on('change:attributes', this.syncPreview);
                this.syncPreview();
            },
            onLoad() {
                this.syncPreview();
            },
            syncPreview() {
                const attributes = this.getAttributes?.() || {};
                const html = String(attributes['data-html'] || defaultSafeHtml);
                const css = String(attributes['data-css'] || '');
                const htmlPreview = toPreviewText(stripUnsafeMarkup(html), 280);
                const compactCss = css
                    .replace(/\/\*[\s\S]*?\*\//g, '')
                    .replace(/\s+/g, ' ')
                    .trim();
                const cssPreview = compactCss.length > 220 ? `${compactCss.slice(0, 219)}…` : compactCss;

                this.components(`
                    <div class="card-body">
                        <h3 class="h6 mb-2">${escapeHtml(t('theme::pagebuilder.custom_html_safe_block', 'HTML/CSS (safe)'))}</h3>
                        <p class="small text-muted mb-3">${escapeHtml(t('theme::pagebuilder.custom_html_safe_hint', 'JavaScript est bloqué. Seuls HTML et CSS sont rendus.'))}</p>
                        <p class="small fw-semibold mb-1">HTML</p>
                        <pre class="small bg-body-tertiary border rounded p-2 mb-2" style="white-space:pre-wrap;max-height:120px;overflow:auto;">${escapeHtml(htmlPreview || t('theme::pagebuilder.custom_html_safe_empty', 'Aucun HTML saisi.'))}</pre>
                        <p class="small fw-semibold mb-1">CSS</p>
                        <pre class="small bg-body-tertiary border rounded p-2 mb-0" style="white-space:pre-wrap;max-height:120px;overflow:auto;">${escapeHtml(cssPreview || t('theme::pagebuilder.custom_html_safe_no_css', 'Aucun CSS.'))}</pre>
                    </div>
                `);

                lockChildrenTree(this);
            },
        }
    });

    dc.addType('custom-highlight-shop', {
        isComponent: (element) => {
            if (element?.getAttribute?.('data-gjs-type') === 'custom-highlight-shop') {
                return { type: 'custom-highlight-shop' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'div',
                name: 'Custom - Article mis en avant',
                droppable: false,
                editable: false,
                classes: ['card', 'border-warning-subtle', 'shadow-sm'],
                attributes: {
                    'data-package-id': String(shopPackages[0]?.id || ''),
                    'data-title': 'Article mis en avant',
                    'data-button-label': 'Voir la boutique',
                },
                traits: [
                    {
                        type: 'select',
                        label: 'Article Shop',
                        name: 'data-package-id',
                        options: customShopPackageOptions,
                    },
                    {
                        type: 'text',
                        label: 'Titre',
                        name: 'data-title',
                        placeholder: 'Article mis en avant',
                    },
                    {
                        type: 'text',
                        label: 'Texte bouton',
                        name: 'data-button-label',
                        placeholder: 'Voir la boutique',
                    },
                ],
            },
            init() {
                this.on('change:attributes', this.syncPreview);
                this.syncPreview();
            },
            onLoad() {
                this.syncPreview();
            },
            syncPreview() {
                const attributes = this.getAttributes?.() || {};
                const packageId = String(attributes['data-package-id'] || '');
                const selectedPackage = shopPackages.find((pkg) => String(pkg.id) === packageId) || null;
                const title = String(attributes['data-title'] || '').trim() || 'Article mis en avant';
                const buttonLabel = String(attributes['data-button-label'] || '').trim() || 'Voir la boutique';

                const safeTitle = escapeHtml(title);
                const safeButtonLabel = escapeHtml(buttonLabel);

                if (!shopEnabled) {
                    this.components(`
                        <div class="card-body">
                            <h3 class="h6 mb-2">${safeTitle}</h3>
                            <div class="alert alert-warning mb-0">Plugin Shop requis.</div>
                        </div>
                    `);
                    lockChildrenTree(this);
                    return;
                }

                const packageName = selectedPackage ? selectedPackage.name : 'Aucun article sélectionné';
                const packagePrice = selectedPackage ? selectedPackage.price : '';
                const safePackageName = escapeHtml(packageName);
                const safePackagePrice = escapeHtml(packagePrice);
                const packageImage = selectedPackage && selectedPackage.has_image && selectedPackage.image_url
                    ? `<img src="${escapeHtml(selectedPackage.image_url)}" alt="${safePackageName}" width="56" height="56" style="object-fit:cover;border-radius:8px;">`
                    : '';

                this.components(`
                    <div class="card-body">
                        <h3 class="h5 mb-3">${safeTitle}</h3>
                        <div class="d-flex align-items-center gap-2 mb-3" style="pointer-events:none;">
                            ${packageImage}
                            <div>
                                <p class="mb-1 fw-semibold">${safePackageName}</p>
                                <p class="mb-0 text-primary">${safePackagePrice}</p>
                            </div>
                        </div>
                        <span class="btn btn-primary btn-sm" style="pointer-events:none;">${safeButtonLabel}</span>
                    </div>
                `);

                lockChildrenTree(this);
            },
        }
    });

    dc.addType('custom-hero-split', {
        isComponent: (element) => {
            if (element?.getAttribute?.('data-gjs-type') === 'custom-hero-split') {
                return { type: 'custom-hero-split' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'section',
                name: t('theme::pagebuilder.custom_hero_split_block', 'Hero split'),
                droppable: false,
                editable: false,
                classes: ['card', 'text-bg-dark', 'border-0', 'shadow-sm', 'overflow-hidden'],
                attributes: {
                    'data-badge': 'Nouveau',
                    'data-title': `Bienvenue sur ${siteName}`,
                    'data-subtitle': 'Crée un hero moderne inspiré des thèmes premium Azuriom.',
                    'data-primary-label': 'Commencer',
                    'data-primary-url': '#',
                    'data-secondary-label': 'Boutique',
                    'data-secondary-url': '/shop',
                    'data-image-url': defaultVisual,
                },
                traits: [
                    { type: 'text', label: t('theme::pagebuilder.custom_hero_badge', 'Badge'), name: 'data-badge' },
                    { type: 'text', label: t('theme::pagebuilder.custom_hero_title', 'Titre hero'), name: 'data-title' },
                    { type: 'text', label: t('theme::pagebuilder.custom_hero_subtitle', 'Sous-titre hero'), name: 'data-subtitle' },
                    { type: 'text', label: t('theme::pagebuilder.custom_primary_label', 'Texte bouton principal'), name: 'data-primary-label' },
                    { type: 'text', label: t('theme::pagebuilder.custom_primary_url', 'URL bouton principal'), name: 'data-primary-url' },
                    { type: 'text', label: t('theme::pagebuilder.custom_secondary_label', 'Texte bouton secondaire'), name: 'data-secondary-label' },
                    { type: 'text', label: t('theme::pagebuilder.custom_secondary_url', 'URL bouton secondaire'), name: 'data-secondary-url' },
                    { type: 'text', label: t('theme::pagebuilder.custom_visual_url', 'URL visuel'), name: 'data-image-url' },
                ],
            },
            init() {
                this.on('change:attributes', this.syncPreview);
                this.syncPreview();
            },
            onLoad() {
                this.syncPreview();
            },
            syncPreview() {
                const attributes = this.getAttributes?.() || {};
                const badge = String(attributes['data-badge'] || '').trim() || 'Nouveau';
                const title = String(attributes['data-title'] || '').trim() || `Bienvenue sur ${siteName}`;
                const subtitle = String(attributes['data-subtitle'] || '').trim() || 'Crée un hero moderne inspiré des thèmes premium Azuriom.';
                const primaryLabel = String(attributes['data-primary-label'] || '').trim() || 'Commencer';
                const secondaryLabel = String(attributes['data-secondary-label'] || '').trim() || 'Découvrir';
                const primaryUrl = sanitizeUrl(attributes['data-primary-url'], '#');
                const secondaryUrl = sanitizeUrl(attributes['data-secondary-url'], '#');
                const imageUrl = sanitizeUrl(attributes['data-image-url'], defaultVisual || '#');
                const imagePreview = imageUrl && imageUrl !== '#'
                    ? `<img src="${escapeHtml(imageUrl)}" alt="${escapeHtml(title)}" class="img-fluid rounded-3 border" style="max-height:160px;object-fit:cover;">`
                    : `<div class="border rounded-3 p-3 text-center small text-muted">Aucun visuel</div>`;

                this.components(`
                    <div class="card-body p-4">
                        <span class="badge text-bg-light mb-2">${escapeHtml(badge)}</span>
                        <div class="row align-items-center g-3">
                            <div class="col-lg-8">
                                <h3 class="h4 mb-2">${escapeHtml(title)}</h3>
                                <p class="small mb-3">${escapeHtml(subtitle)}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="btn btn-primary btn-sm" style="pointer-events:none;">${escapeHtml(primaryLabel)}</span>
                                    <span class="btn btn-outline-light btn-sm" style="pointer-events:none;">${escapeHtml(secondaryLabel)}</span>
                                </div>
                                <p class="small opacity-75 mt-3 mb-0">${escapeHtml(primaryUrl)} • ${escapeHtml(secondaryUrl)}</p>
                            </div>
                            <div class="col-lg-4">${imagePreview}</div>
                        </div>
                    </div>
                `);

                lockChildrenTree(this);
            },
        }
    });

    dc.addType('custom-stats-grid', {
        isComponent: (element) => {
            if (element?.getAttribute?.('data-gjs-type') === 'custom-stats-grid') {
                return { type: 'custom-stats-grid' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'section',
                name: t('theme::pagebuilder.custom_stats_grid_block', 'Stats grid'),
                droppable: false,
                editable: false,
                classes: ['card', 'border-0', 'shadow-sm'],
                attributes: {
                    'data-title': 'Statistiques du serveur',
                    'data-stat-1-value': '128',
                    'data-stat-1-label': 'Joueurs en ligne',
                    'data-stat-1-icon': 'bi bi-people-fill',
                    'data-stat-2-value': '1 248',
                    'data-stat-2-label': 'Comptes',
                    'data-stat-2-icon': 'bi bi-controller',
                    'data-stat-3-value': '99.9%',
                    'data-stat-3-label': 'Uptime',
                    'data-stat-3-icon': 'bi bi-lightning-charge-fill',
                },
                traits: [
                    { type: 'text', label: t('theme::pagebuilder.custom_stats_title', 'Titre stats'), name: 'data-title' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_value', 'Valeur')} #1`, name: 'data-stat-1-value' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_label', 'Label')} #1`, name: 'data-stat-1-label' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_icon', 'Icône')} #1`, name: 'data-stat-1-icon' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_value', 'Valeur')} #2`, name: 'data-stat-2-value' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_label', 'Label')} #2`, name: 'data-stat-2-label' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_icon', 'Icône')} #2`, name: 'data-stat-2-icon' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_value', 'Valeur')} #3`, name: 'data-stat-3-value' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_label', 'Label')} #3`, name: 'data-stat-3-label' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_stats_icon', 'Icône')} #3`, name: 'data-stat-3-icon' },
                ],
            },
            init() {
                this.on('change:attributes', this.syncPreview);
                this.syncPreview();
            },
            onLoad() {
                this.syncPreview();
            },
            syncPreview() {
                const attributes = this.getAttributes?.() || {};
                const title = String(attributes['data-title'] || '').trim() || 'Statistiques du serveur';
                const cards = [1, 2, 3].map((index) => ({
                    value: String(attributes[`data-stat-${index}-value`] || '').trim() || '0',
                    label: String(attributes[`data-stat-${index}-label`] || '').trim() || `Label ${index}`,
                    icon: normalizeIconClass(attributes[`data-stat-${index}-icon`], 'bi bi-bar-chart-fill'),
                }));

                const items = cards.map((card) => `
                    <div class="col-md-4">
                        <div class="border rounded-3 h-100 p-3 text-center">
                            <i class="${escapeHtml(card.icon)} fs-4 text-primary mb-2"></i>
                            <p class="h4 mb-0">${escapeHtml(card.value)}</p>
                            <p class="small text-muted mb-0">${escapeHtml(card.label)}</p>
                        </div>
                    </div>
                `).join('');

                this.components(`
                    <div class="card-body p-4">
                        <h3 class="h5 mb-3">${escapeHtml(title)}</h3>
                        <div class="row g-3">${items}</div>
                    </div>
                `);

                lockChildrenTree(this);
            },
        }
    });

    dc.addType('custom-feature-cards', {
        isComponent: (element) => {
            if (element?.getAttribute?.('data-gjs-type') === 'custom-feature-cards') {
                return { type: 'custom-feature-cards' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'section',
                name: t('theme::pagebuilder.custom_feature_cards_block', 'Feature cards'),
                droppable: false,
                editable: false,
                classes: ['card', 'border-0', 'shadow-sm'],
                attributes: {
                    'data-title': 'Pourquoi nous rejoindre ?',
                    'data-subtitle': 'Bloc inspiré des sections features de thèmes premium.',
                    'data-feature-1-icon': 'bi bi-shield-check',
                    'data-feature-1-title': 'Sécurité',
                    'data-feature-1-text': 'Protection active et modération.',
                    'data-feature-2-icon': 'bi bi-stars',
                    'data-feature-2-title': 'Contenu',
                    'data-feature-2-text': 'Gameplay unique et évolutif.',
                    'data-feature-3-icon': 'bi bi-people',
                    'data-feature-3-title': 'Communauté',
                    'data-feature-3-text': 'Équipe proche de ses joueurs.',
                    'data-feature-4-icon': 'bi bi-trophy',
                    'data-feature-4-title': 'Compétition',
                    'data-feature-4-text': 'Tournois et classements.',
                },
                traits: [
                    { type: 'text', label: t('theme::pagebuilder.custom_features_title', 'Titre features'), name: 'data-title' },
                    { type: 'text', label: t('theme::pagebuilder.custom_features_subtitle', 'Sous-titre features'), name: 'data-subtitle' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_icon', 'Icône feature')} #1`, name: 'data-feature-1-icon' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_title', 'Titre feature')} #1`, name: 'data-feature-1-title' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_text', 'Texte feature')} #1`, name: 'data-feature-1-text' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_icon', 'Icône feature')} #2`, name: 'data-feature-2-icon' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_title', 'Titre feature')} #2`, name: 'data-feature-2-title' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_text', 'Texte feature')} #2`, name: 'data-feature-2-text' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_icon', 'Icône feature')} #3`, name: 'data-feature-3-icon' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_title', 'Titre feature')} #3`, name: 'data-feature-3-title' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_text', 'Texte feature')} #3`, name: 'data-feature-3-text' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_icon', 'Icône feature')} #4`, name: 'data-feature-4-icon' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_title', 'Titre feature')} #4`, name: 'data-feature-4-title' },
                    { type: 'text', label: `${t('theme::pagebuilder.custom_feature_text', 'Texte feature')} #4`, name: 'data-feature-4-text' },
                ],
            },
            init() {
                this.on('change:attributes', this.syncPreview);
                this.syncPreview();
            },
            onLoad() {
                this.syncPreview();
            },
            syncPreview() {
                const attributes = this.getAttributes?.() || {};
                const title = String(attributes['data-title'] || '').trim() || 'Pourquoi nous rejoindre ?';
                const subtitle = String(attributes['data-subtitle'] || '').trim() || '';
                const features = [1, 2, 3, 4].map((index) => ({
                    icon: normalizeIconClass(attributes[`data-feature-${index}-icon`], 'bi bi-star-fill'),
                    title: String(attributes[`data-feature-${index}-title`] || '').trim() || `Feature ${index}`,
                    text: String(attributes[`data-feature-${index}-text`] || '').trim() || '',
                }));

                const items = features.map((feature) => `
                    <div class="col-md-6">
                        <div class="h-100 border rounded-3 p-3">
                            <i class="${escapeHtml(feature.icon)} text-primary fs-4"></i>
                            <h4 class="h6 mt-2 mb-1">${escapeHtml(feature.title)}</h4>
                            <p class="small text-muted mb-0">${escapeHtml(feature.text)}</p>
                        </div>
                    </div>
                `).join('');

                this.components(`
                    <div class="card-body p-4">
                        <h3 class="h5 mb-1">${escapeHtml(title)}</h3>
                        <p class="small text-muted mb-3">${escapeHtml(subtitle)}</p>
                        <div class="row g-3">${items}</div>
                    </div>
                `);

                lockChildrenTree(this);
            },
        }
    });

    dc.addType('custom-cta-ribbon', {
        isComponent: (element) => {
            if (element?.getAttribute?.('data-gjs-type') === 'custom-cta-ribbon') {
                return { type: 'custom-cta-ribbon' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'section',
                name: t('theme::pagebuilder.custom_cta_ribbon_block', 'CTA ribbon'),
                droppable: false,
                editable: false,
                classes: ['card', 'border-0', 'shadow-sm'],
                attributes: {
                    'data-icon': 'bi bi-megaphone-fill',
                    'data-title': 'Annonce importante',
                    'data-text': 'Active ce composant pour pousser une action forte vers tes utilisateurs.',
                    'data-button-label': 'En savoir plus',
                    'data-button-url': '/posts',
                },
                traits: [
                    { type: 'text', label: t('theme::pagebuilder.custom_cta_icon', 'Icône CTA'), name: 'data-icon' },
                    { type: 'text', label: t('theme::pagebuilder.custom_cta_title', 'Titre CTA'), name: 'data-title' },
                    { type: 'text', label: t('theme::pagebuilder.custom_cta_text', 'Texte CTA'), name: 'data-text' },
                    { type: 'text', label: t('theme::pagebuilder.custom_cta_button_label', 'Texte bouton CTA'), name: 'data-button-label' },
                    { type: 'text', label: t('theme::pagebuilder.custom_cta_button_url', 'URL bouton CTA'), name: 'data-button-url' },
                ],
            },
            init() {
                this.on('change:attributes', this.syncPreview);
                this.syncPreview();
            },
            onLoad() {
                this.syncPreview();
            },
            syncPreview() {
                const attributes = this.getAttributes?.() || {};
                const icon = normalizeIconClass(attributes['data-icon'], 'bi bi-megaphone-fill');
                const title = String(attributes['data-title'] || '').trim() || 'Annonce importante';
                const text = String(attributes['data-text'] || '').trim() || '';
                const buttonLabel = String(attributes['data-button-label'] || '').trim() || 'En savoir plus';
                const buttonUrl = sanitizeUrl(attributes['data-button-url'], '#');

                this.components(`
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                                <i class="${escapeHtml(icon)}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="h6 mb-1">${escapeHtml(title)}</h3>
                                <p class="small text-muted mb-0">${escapeHtml(text)}</p>
                            </div>
                            <span class="btn btn-primary btn-sm" style="pointer-events:none;" title="${escapeHtml(buttonUrl)}">${escapeHtml(buttonLabel)}</span>
                        </div>
                    </div>
                `);

                lockChildrenTree(this);
            },
        }
    });

    dc.addType('custom-trailer-card', {
        isComponent: (element) => {
            if (element?.getAttribute?.('data-gjs-type') === 'custom-trailer-card') {
                return { type: 'custom-trailer-card' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'section',
                name: t('theme::pagebuilder.custom_trailer_card_block', 'Trailer card'),
                droppable: false,
                editable: false,
                classes: ['card', 'border-0', 'shadow-sm', 'overflow-hidden'],
                attributes: {
                    'data-title': 'Trailer du serveur',
                    'data-text': 'Ajoute un trailer avec un visuel fort.',
                    'data-video-url': 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'data-poster-url': defaultVisual,
                    'data-button-label': 'Voir la vidéo',
                },
                traits: [
                    { type: 'text', label: t('theme::pagebuilder.custom_trailer_title', 'Titre trailer'), name: 'data-title' },
                    { type: 'text', label: t('theme::pagebuilder.custom_trailer_text', 'Texte trailer'), name: 'data-text' },
                    { type: 'text', label: t('theme::pagebuilder.custom_trailer_url', 'URL vidéo'), name: 'data-video-url' },
                    { type: 'text', label: t('theme::pagebuilder.custom_trailer_poster', 'URL image trailer'), name: 'data-poster-url' },
                    { type: 'text', label: t('theme::pagebuilder.custom_trailer_button_label', 'Texte bouton trailer'), name: 'data-button-label' },
                ],
            },
            init() {
                this.on('change:attributes', this.syncPreview);
                this.syncPreview();
            },
            onLoad() {
                this.syncPreview();
            },
            syncPreview() {
                const attributes = this.getAttributes?.() || {};
                const title = String(attributes['data-title'] || '').trim() || 'Trailer du serveur';
                const text = String(attributes['data-text'] || '').trim() || '';
                const videoUrl = sanitizeUrl(attributes['data-video-url'], '#');
                const posterUrl = sanitizeUrl(attributes['data-poster-url'], defaultVisual || '#');
                const buttonLabel = String(attributes['data-button-label'] || '').trim() || 'Voir la vidéo';
                const posterPreview = posterUrl && posterUrl !== '#'
                    ? `<img src="${escapeHtml(posterUrl)}" alt="${escapeHtml(title)}" class="w-100" style="height:180px;object-fit:cover;">`
                    : '<div class="w-100 d-flex align-items-center justify-content-center bg-body-tertiary" style="height:180px;">Aucune image</div>';

                this.components(`
                    <div>
                        ${posterPreview}
                        <div class="card-body p-4">
                            <h3 class="h5 mb-2">${escapeHtml(title)}</h3>
                            <p class="small text-muted mb-3">${escapeHtml(text)}</p>
                            <span class="btn btn-primary btn-sm" style="pointer-events:none;" title="${escapeHtml(videoUrl)}">${escapeHtml(buttonLabel)}</span>
                        </div>
                    </div>
                `);

                lockChildrenTree(this);
            },
        }
    });
}
