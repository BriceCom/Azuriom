function Component(editor) {
    const dc = editor.DomComponents;

    const t = (key, fallback = null, params = null) => {
        if (typeof window.trans === 'function') {
            return window.trans(key, params, fallback);
        }

        return fallback ?? key;
    };

    const pagebuilderAssets = window.pagebuilderAssets || {};
    const azuriomImages = Array.isArray(pagebuilderAssets.azuriomImages) ? pagebuilderAssets.azuriomImages : [];

    const imagePlaceholder = () => {
        const svg = '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="420" viewBox="0 0 1200 420"><rect width="1200" height="420" fill="#e9ecef"/><text x="600" y="210" dominant-baseline="middle" text-anchor="middle" fill="#6c757d" font-family="Arial, sans-serif" font-size="42">Image</text></svg>';
        return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`;
    };

    const fallbackImage = azuriomImages[0]?.url || imagePlaceholder();
    const siteName = typeof pagebuilderAssets.siteName === 'string' && pagebuilderAssets.siteName.trim() !== ''
        ? pagebuilderAssets.siteName.trim()
        : 'Azuriom';
    const siteLogoUrl = typeof pagebuilderAssets.siteLogoUrl === 'string' && pagebuilderAssets.siteLogoUrl.trim() !== ''
        ? pagebuilderAssets.siteLogoUrl
        : fallbackImage;
    const siteCopyright = typeof pagebuilderAssets.siteCopyright === 'string' && pagebuilderAssets.siteCopyright.trim() !== ''
        ? pagebuilderAssets.siteCopyright.trim()
        : `Copyright ${new Date().getFullYear()}`;
    const siteSocialLinks = Array.isArray(pagebuilderAssets.socialLinks) ? pagebuilderAssets.socialLinks : [];

    const escapeHtml = (value) => {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    };

    const sanitizeClassList = (classes) => {
        if (!Array.isArray(classes)) {
            return [];
        }

        return classes.filter((className) => typeof className === 'string' && className.trim() !== '');
    };

    const removeClassesByPredicate = (classes, predicate) => {
        return sanitizeClassList(classes).filter((className) => !predicate(className));
    };

    const getComponentType = (component) => {
        if (!component) {
            return '';
        }

        if (typeof Element !== 'undefined' && component instanceof Element) {
            return component.getAttribute('data-gjs-type') || '';
        }

        if (typeof component.getAttribute === 'function') {
            return component.getAttribute('data-gjs-type') || '';
        }

        if (typeof component.get === 'function') {
            return component.get('type')
                || component.get('attributes')?.['data-gjs-type']
                || component.getAttributes?.()['data-gjs-type']
                || '';
        }

        if (typeof component === 'object') {
            return component.type || component.attributes?.['data-gjs-type'] || '';
        }

        return '';
    };

    const allowOnlyTypes = (allowedTypes) => {
        return (component) => allowedTypes.includes(getComponentType(component));
    };

    const disallowedCompactTypes = [
        'container',
        'layout-row',
        'column',
        'bs-carousel',
        'bs-tabs',
        'bs-accordion',
        'bs-navbar',
        'bs-section',
        'bs-card',
        'custom-highlight-shop',
        'custom-html-safe',
        'custom-hero-split',
        'custom-stats-grid',
        'custom-feature-cards',
        'custom-cta-ribbon',
        'custom-trailer-card',
        'page-vote-card',
        'page-vote-top',
        'page-vote-rewards',
        'page-shop-sidebar',
        'page-shop-home',
        'page-shop-category-description',
        'page-shop-category-packages',
        'site-navigation',
        'site-user-navigation',
        'site-logo',
        'site-theme-toggle',
        'site-social-links',
        'site-copyright',
    ];

    const allowCompactContent = (component) => {
        const type = getComponentType(component);
        if (!type) {
            return true;
        }

        return !disallowedCompactTypes.includes(type);
    };

    const colorOptions = [
        { value: 'primary', name: t('theme::pagebuilder.primary', 'Primary') },
        { value: 'secondary', name: t('theme::pagebuilder.secondary', 'Secondary') },
        { value: 'success', name: t('theme::pagebuilder.success', 'Success') },
        { value: 'danger', name: t('theme::pagebuilder.danger', 'Danger') },
        { value: 'warning', name: t('theme::pagebuilder.warning', 'Warning') },
        { value: 'info', name: t('theme::pagebuilder.info', 'Info') },
        { value: 'light', name: t('theme::pagebuilder.light', 'Light') },
        { value: 'dark', name: t('theme::pagebuilder.dark', 'Dark') },
    ];

    const isPlaceholderComponent = (component) => {
        return component?.getAttributes?.()['data-gjs-placeholder'] === '1';
    };

    const buildEditorPlaceholder = (label) => ({
        tagName: 'div',
        attributes: {
            'data-gjs-placeholder': '1',
        },
        content: label,
        style: {
            margin: '10px 0',
            padding: '8px 10px',
            textAlign: 'center',
            color: '#6c757d',
            fontSize: '13px',
            border: '1px dashed rgba(108, 117, 125, 0.6)',
            borderRadius: '6px',
            backgroundColor: 'rgba(108, 117, 125, 0.06)',
            pointerEvents: 'none',
        },
        draggable: false,
        droppable: false,
        selectable: false,
        hoverable: false,
        copyable: false,
        removable: false,
        editable: false,
    });

    const isRowLikeComponent = (component) => {
        const type = getComponentType(component);
        if (type === 'layout-row') {
            return true;
        }

        if (component?.classList?.contains('row')) {
            return true;
        }

        const classes = sanitizeClassList(component?.getClasses?.() || []);
        return classes.includes('row');
    };

    const isColumnLikeComponent = (component) => {
        const type = getComponentType(component);
        if (type === 'column') {
            return true;
        }

        if (component?.classList) {
            return Array.from(component.classList).some((className) => /^col($|-)/.test(className));
        }

        const classes = sanitizeClassList(component?.getClasses?.() || []);
        return classes.some((className) => /^col($|-)/.test(className));
    };

    const bindPlaceholderBehavior = (model, label, isRealChild) => {
        const components = model.components();

        const sync = () => {
            const placeholders = components.filter((child) => isPlaceholderComponent(child));
            const realChildren = components.filter((child) => !isPlaceholderComponent(child) && isRealChild(child));

            if (realChildren.length > 0) {
                placeholders.forEach((placeholder) => components.remove(placeholder));
                return;
            }

            if (placeholders.length === 0) {
                components.add(buildEditorPlaceholder(label));
            }
        };

        model.listenTo(components, 'add remove reset', sync);
        setTimeout(sync, 0);
    };

    const lockChildrenTree = (model) => {
        const lock = (parent) => {
            const children = parent.components?.();
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
                    droppable: false,
                }, { silent: true });

                lock(child);
            });
        };

        setTimeout(() => lock(model), 0);
    };

    dc.addType('layout-row', {
        model: {
            defaults: {
                tagName: 'div',
                name: t('theme::pagebuilder.row', 'Row'),
                classes: ['row', 'g-3'],
                droppable: (component) => isColumnLikeComponent(component),
            },
            init() {
                bindPlaceholderBehavior(
                    this,
                    t('theme::pagebuilder.drop_columns_here', 'Drop Columns (Col) here'),
                    (component) => isColumnLikeComponent(component)
                );
            }
        }
    });

    dc.addType('column', {
        model: {
            defaults: {
                tagName: 'div',
                name: t('theme::pagebuilder.column', 'Column'),
                classes: ['col'],
                draggable: '[data-gjs-type="layout-row"]',
                droppable: true,
                traits: [
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.size_xs', 'Size (XS)'),
                        name: 'col-size',
                        changeProp: 1,
                        options: [
                            { value: 'col', name: t('theme::pagebuilder.auto', 'Auto') },
                            ...Array.from({ length: 12 }, (_, index) => ({
                                value: `col-${index + 1}`,
                                name: `${t('theme::pagebuilder.column', 'Column')} ${index + 1}`
                            }))
                        ]
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.size_sm', 'Size (SM)'),
                        name: 'col-sm-size',
                        changeProp: 1,
                        options: [
                            { value: '', name: t('theme::pagebuilder.none', 'None') },
                            { value: 'col-sm', name: t('theme::pagebuilder.auto', 'Auto') },
                            ...Array.from({ length: 12 }, (_, index) => ({
                                value: `col-sm-${index + 1}`,
                                name: `${t('theme::pagebuilder.column', 'Column')} SM ${index + 1}`
                            }))
                        ]
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.size_md', 'Size (MD)'),
                        name: 'col-md-size',
                        changeProp: 1,
                        options: [
                            { value: '', name: t('theme::pagebuilder.none', 'None') },
                            { value: 'col-md', name: t('theme::pagebuilder.auto', 'Auto') },
                            ...Array.from({ length: 12 }, (_, index) => ({
                                value: `col-md-${index + 1}`,
                                name: `${t('theme::pagebuilder.column', 'Column')} MD ${index + 1}`
                            }))
                        ]
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.size_lg', 'Size (LG)'),
                        name: 'col-lg-size',
                        changeProp: 1,
                        options: [
                            { value: '', name: t('theme::pagebuilder.none', 'None') },
                            { value: 'col-lg', name: t('theme::pagebuilder.auto', 'Auto') },
                            ...Array.from({ length: 12 }, (_, index) => ({
                                value: `col-lg-${index + 1}`,
                                name: `${t('theme::pagebuilder.column', 'Column')} LG ${index + 1}`
                            }))
                        ]
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.offset_md', 'Offset (MD)'),
                        name: 'offset-md',
                        changeProp: 1,
                        options: [
                            { value: '', name: t('theme::pagebuilder.none', 'None') },
                            ...Array.from({ length: 11 }, (_, index) => ({
                                value: `offset-md-${index + 1}`,
                                name: `Offset MD ${index + 1}`
                            }))
                        ]
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.order_md', 'Order (MD)'),
                        name: 'order-md',
                        changeProp: 1,
                        options: [
                            { value: '', name: t('theme::pagebuilder.none', 'None') },
                            { value: 'order-md-first', name: t('theme::pagebuilder.first', 'First') },
                            { value: 'order-md-last', name: t('theme::pagebuilder.last', 'Last') },
                            ...Array.from({ length: 12 }, (_, index) => ({
                                value: `order-md-${index + 1}`,
                                name: `Order MD ${index + 1}`
                            }))
                        ]
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.vertical_alignment', 'Vertical Alignment'),
                        name: 'align-self',
                        changeProp: 1,
                        options: [
                            { value: '', name: t('theme::pagebuilder.none', 'None') },
                            { value: 'align-self-start', name: t('theme::pagebuilder.start', 'Start') },
                            { value: 'align-self-center', name: t('theme::pagebuilder.center', 'Center') },
                            { value: 'align-self-end', name: t('theme::pagebuilder.end', 'End') }
                        ]
                    },
                ],
            },

            init() {
                this.on('change:col-size', this.handleResponsiveChange);
                this.on('change:col-sm-size', this.handleResponsiveChange);
                this.on('change:col-md-size', this.handleResponsiveChange);
                this.on('change:col-lg-size', this.handleResponsiveChange);
                this.on('change:offset-md', this.handleResponsiveChange);
                this.on('change:order-md', this.handleResponsiveChange);
                this.on('change:align-self', this.handleResponsiveChange);

                bindPlaceholderBehavior(
                    this,
                    t('theme::pagebuilder.drop_content_here', 'Drop content here'),
                    (component) => !isPlaceholderComponent(component)
                );
            },

            onLoad() {
                this.syncTraitsFromClasses();
            },

            syncTraitsFromClasses() {
                const classes = sanitizeClassList(this.getClasses());

                const colSize = classes.find((className) => /^col-\d+$/.test(className)) || (classes.includes('col') ? 'col' : '');
                this.set('col-size', colSize || 'col', { silent: true });

                const colSmSize = classes.find((className) => /^col-sm(-\d+)?$/.test(className)) || '';
                this.set('col-sm-size', colSmSize, { silent: true });

                const colMdSize = classes.find((className) => /^col-md(-\d+)?$/.test(className)) || '';
                this.set('col-md-size', colMdSize, { silent: true });

                const colLgSize = classes.find((className) => /^col-lg(-\d+)?$/.test(className)) || '';
                this.set('col-lg-size', colLgSize, { silent: true });

                const offsetMd = classes.find((className) => className.startsWith('offset-md-')) || '';
                this.set('offset-md', offsetMd, { silent: true });

                const orderMd = classes.find((className) => className.startsWith('order-md-')) || '';
                this.set('order-md', orderMd, { silent: true });

                const alignSelf = classes.find((className) => className.startsWith('align-self-')) || '';
                this.set('align-self', alignSelf, { silent: true });
            },

            handleResponsiveChange() {
                const currentClasses = sanitizeClassList(this.getClasses());
                const newClasses = currentClasses.filter((className) => {
                    return !/^col(-sm|-md|-lg)?(-\d+)?$/.test(className)
                        && !/^offset-md-\d+$/.test(className)
                        && !/^order-md-(first|last|\d+)$/.test(className)
                        && !/^align-self-(start|center|end)$/.test(className);
                });

                const traits = ['col-size', 'col-sm-size', 'col-md-size', 'col-lg-size', 'offset-md', 'order-md', 'align-self'];
                traits.forEach((traitName) => {
                    const value = this.get(traitName);
                    if (value && value !== '') {
                        newClasses.push(value);
                    }
                });

                this.setClass([...new Set(newClasses)]);
            }
        }
    });

    dc.addType('container', {
        model: {
            defaults: {
                tagName: 'div',
                name: t('theme::pagebuilder.container', 'Container'),
                classes: ['container', 'py-4'],
                droppable: (component) => isRowLikeComponent(component),
                traits: [
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.type', 'Type'),
                        name: 'container-type',
                        changeProp: 1,
                        options: [
                            { value: 'container', name: t('theme::pagebuilder.fixed_container', 'Fixed (container)') },
                            { value: 'container-fluid', name: t('theme::pagebuilder.fluid_container', 'Fluid (container-fluid)') }
                        ]
                    },
                ]
            },
            init() {
                this.on('change:container-type', this.handleContainerTypeChange);
                bindPlaceholderBehavior(
                    this,
                    t('theme::pagebuilder.drop_row_here', 'Drop a Row here'),
                    (component) => isRowLikeComponent(component)
                );
            },
            onLoad() {
                const classes = sanitizeClassList(this.getClasses());
                this.set('container-type', classes.includes('container-fluid') ? 'container-fluid' : 'container', { silent: true });
            },
            handleContainerTypeChange() {
                const selected = this.get('container-type') || 'container';
                const classes = removeClassesByPredicate(this.getClasses(), (className) => className === 'container' || className === 'container-fluid');
                classes.push(selected);
                this.setClass([...new Set(classes)]);
            }
        }
    });

    dc.addType('text', {
        extend: 'text',
        model: {
            defaults: {
                traits: [
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.tag', 'Tag'),
                        name: 'tagName',
                        changeProp: 1,
                        options: [
                            { value: 'p', name: t('theme::pagebuilder.paragraph', 'Paragraph (p)') },
                            { value: 'h1', name: t('theme::pagebuilder.heading_1', 'Heading 1 (h1)') },
                            { value: 'h2', name: t('theme::pagebuilder.heading_2', 'Heading 2 (h2)') },
                            { value: 'h3', name: t('theme::pagebuilder.heading_3', 'Heading 3 (h3)') },
                            { value: 'h4', name: t('theme::pagebuilder.heading_4', 'Heading 4 (h4)') },
                            { value: 'h5', name: t('theme::pagebuilder.heading_5', 'Heading 5 (h5)') },
                            { value: 'h6', name: t('theme::pagebuilder.heading_6', 'Heading 6 (h6)') },
                            { value: 'div', name: t('theme::pagebuilder.div', 'Div (div)') }
                        ],
                    }
                ]
            },

            init() {
                this.on('change:tagName', this.handleTagChange);
            },

            handleTagChange() {
                const newTag = this.get('tagName');
                if (newTag) {
                    this.set('tagName', newTag);
                }
            }
        }
    });

    const imageOptions = [
        { value: '', name: t('theme::pagebuilder.select_image', 'Select image') },
        ...azuriomImages
            .filter((image) => image && typeof image.url === 'string' && image.url.trim() !== '')
            .map((image) => ({
                value: image.url,
                name: image.name || image.url,
            }))
    ];

    dc.addType('pb-image', {
        extend: 'image',
        isComponent: (element) => {
            if (element?.tagName === 'IMG' && element.getAttribute('data-gjs-type') === 'pb-image') {
                return { type: 'pb-image' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'img',
                name: t('theme::pagebuilder.image', 'Image'),
                draggable: true,
                droppable: false,
                attributes: {
                    src: fallbackImage,
                    alt: t('theme::pagebuilder.image_alt', 'Image'),
                },
                traits: [
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.library_image', 'Library image'),
                        name: 'asset-src',
                        changeProp: 1,
                        options: imageOptions,
                    },
                    {
                        type: 'text',
                        label: t('theme::pagebuilder.url', 'URL'),
                        name: 'src',
                    },
                    {
                        type: 'text',
                        label: t('theme::pagebuilder.alt_text', 'Alt text'),
                        name: 'alt',
                    },
                ]
            },
            init() {
                this.on('change:asset-src', this.handleAssetSourceChange);
                this.on('change:attributes', this.syncSelectedAsset);
            },
            onLoad() {
                this.syncSelectedAsset();
            },
            handleAssetSourceChange() {
                const selected = this.get('asset-src');
                if (!selected) {
                    return;
                }

                this.addAttributes({ src: selected });
            },
            syncSelectedAsset() {
                const src = this.getAttributes?.().src || '';
                const found = imageOptions.find((option) => option.value === src);
                this.set('asset-src', found ? src : '', { silent: true });
            }
        }
    });

    dc.addType('pb-icon', {
        isComponent: (element) => {
            if (element?.tagName === 'I' || (element?.classList && element.classList.contains('bi'))) {
                return { type: 'pb-icon' };
            }

            return false;
        },
        model: {
            defaults: {
                tagName: 'i',
                name: t('theme::pagebuilder.icon', 'Icon'),
                classes: ['bi', 'bi-house'],
                attributes: {
                    'aria-hidden': 'true',
                },
                draggable: true,
                droppable: false,
                traits: [
                    {
                        type: 'text',
                        label: t(
                            'theme::pagebuilder.icon_class_help',
                            'Icon classes (bi bi-home). Browse: https://icons.getbootstrap.com/#icons'
                        ),
                        name: 'icon-class',
                        changeProp: 1,
                        placeholder: 'bi bi-home',
                    },
                ],
            },
            init() {
                this.on('change:icon-class', this.handleIconClassChange);
                this.syncIconClassFromClasses();
                this.ensureAriaHidden();
            },
            onLoad() {
                this.syncIconClassFromClasses();
                this.ensureAriaHidden();
            },
            ensureAriaHidden() {
                const attributes = { ...(this.getAttributes?.() || {}) };
                attributes['aria-hidden'] = 'true';
                this.setAttributes(attributes);
            },
            handleIconClassChange() {
                const input = (this.get('icon-class') || '').trim();
                const parsed = input.split(/\s+/).filter(Boolean);
                const sanitized = parsed.filter((token) => /^[a-zA-Z0-9_-]+$/.test(token));

                const nextClasses = sanitized.length > 0 ? sanitized : ['bi', 'bi-house'];

                if (!nextClasses.includes('bi')) {
                    nextClasses.unshift('bi');
                }

                if (!nextClasses.some((token) => token.startsWith('bi-'))) {
                    nextClasses.push('bi-house');
                }

                this.setClass([...new Set(nextClasses)]);
                this.ensureAriaHidden();
            },
            syncIconClassFromClasses() {
                const classes = sanitizeClassList(this.getClasses());
                const withDefaults = classes.length > 0 ? classes : ['bi', 'bi-house'];
                this.set('icon-class', withDefaults.join(' '), { silent: true });
            },
        }
    });

    dc.addType('bs-button', {
        extend: 'link',
        model: {
            defaults: {
                tagName: 'a',
                name: t('theme::pagebuilder.button', 'Button'),
                classes: ['btn', 'btn-primary'],
                attributes: { href: '#' },
                traits: [
                    {
                        type: 'text',
                        label: t('theme::pagebuilder.text', 'Text'),
                        name: 'content',
                        changeProp: 1
                    },
                    {
                        type: 'text',
                        label: t('theme::pagebuilder.url', 'URL'),
                        name: 'href'
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.variant', 'Variant'),
                        name: 'variant',
                        changeProp: 1,
                        options: [...colorOptions, { value: 'link', name: t('theme::pagebuilder.link', 'Link') }],
                    },
                    {
                        type: 'checkbox',
                        label: t('theme::pagebuilder.outline', 'Outline'),
                        name: 'outline',
                        changeProp: 1
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.size', 'Size'),
                        name: 'size',
                        changeProp: 1,
                        options: [
                            { value: 'sm', name: t('theme::pagebuilder.small', 'Small') },
                            { value: 'default', name: t('theme::pagebuilder.default', 'Default') },
                            { value: 'lg', name: t('theme::pagebuilder.large', 'Large') }
                        ]
                    },
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.target', 'Target'),
                        name: 'target',
                        options: [
                            { value: '', name: t('theme::pagebuilder.same_window', 'Same window') },
                            { value: '_blank', name: t('theme::pagebuilder.new_window', 'New window') }
                        ]
                    },
                ]
            },

            init() {
                this.on('change:content', this.handleContentChange);
                this.on('change:variant', this.updateButtonClasses);
                this.on('change:outline', this.updateButtonClasses);
                this.on('change:size', this.updateButtonClasses);
                this.syncTraitsFromClasses();
            },

            handleContentChange() {
                const content = this.get('content');
                if (content) {
                    this.components(content);
                }
            },

            updateButtonClasses() {
                const variant = this.get('variant') || 'primary';
                const outline = !!this.get('outline');
                const size = this.get('size') || 'default';

                const classes = ['btn', outline ? `btn-outline-${variant}` : `btn-${variant}`];
                if (size === 'sm') classes.push('btn-sm');
                if (size === 'lg') classes.push('btn-lg');

                this.setClass([...new Set(classes)]);
            },

            syncTraitsFromClasses() {
                const classes = sanitizeClassList(this.getClasses());

                const variantClass = classes.find((className) => className.startsWith('btn-') && !className.startsWith('btn-outline-') && !['btn-sm', 'btn-lg'].includes(className));
                if (variantClass) {
                    this.set('variant', variantClass.replace('btn-', ''), { silent: true });
                }

                const outlineClass = classes.find((className) => className.startsWith('btn-outline-'));
                if (outlineClass) {
                    this.set('outline', true, { silent: true });
                    this.set('variant', outlineClass.replace('btn-outline-', ''), { silent: true });
                } else {
                    this.set('outline', false, { silent: true });
                }

                if (classes.includes('btn-sm')) {
                    this.set('size', 'sm', { silent: true });
                } else if (classes.includes('btn-lg')) {
                    this.set('size', 'lg', { silent: true });
                } else {
                    this.set('size', 'default', { silent: true });
                }

                const firstChild = this.components().models[0];
                const content = firstChild?.get?.('content');
                if (typeof content === 'string') {
                    this.set('content', content, { silent: true });
                }
            }
        }
    });

    dc.addType('bs-section', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.section', 'Section'),
            }
        }
    });

    dc.addType('bs-navbar', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.navbar', 'Navbar'),
                droppable: false,
                traits: [
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.variant', 'Variant'),
                        name: 'navbar-variant',
                        changeProp: 1,
                        options: [
                            { value: 'light', name: t('theme::pagebuilder.light', 'Light') },
                            { value: 'dark', name: t('theme::pagebuilder.dark', 'Dark') },
                            { value: 'primary', name: t('theme::pagebuilder.primary', 'Primary') },
                            { value: 'secondary', name: t('theme::pagebuilder.secondary', 'Secondary') },
                            { value: 'success', name: t('theme::pagebuilder.success', 'Success') },
                            { value: 'danger', name: t('theme::pagebuilder.danger', 'Danger') },
                        ]
                    },
                ]
            },
            init() {
                this.on('change:navbar-variant', this.handleNavbarVariantChange);
                this.syncVariantFromClasses();
            },
            onLoad() {
                this.syncVariantFromClasses();
            },
            syncVariantFromClasses() {
                const classes = sanitizeClassList(this.getClasses());
                const bgClass = classes.find((className) => /^bg-(light|dark|primary|secondary|success|danger)$/.test(className));
                if (bgClass) {
                    this.set('navbar-variant', bgClass.replace('bg-', ''), { silent: true });
                    return;
                }
                this.set('navbar-variant', 'light', { silent: true });
            },
            handleNavbarVariantChange() {
                const variant = this.get('navbar-variant') || 'light';
                const classes = removeClassesByPredicate(this.getClasses(), (className) => {
                    return className === 'navbar-light' || className === 'navbar-dark' || /^bg-(light|dark|primary|secondary|success|danger|body-tertiary)$/.test(className);
                });

                if (variant === 'light') {
                    classes.push('navbar-light', 'bg-light');
                } else if (variant === 'dark') {
                    classes.push('navbar-dark', 'bg-dark');
                } else {
                    classes.push('navbar-dark', `bg-${variant}`);
                }

                this.setClass([...new Set(classes)]);
            }
        }
    });

    dc.addType('bs-card', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.card', 'Card'),
                droppable: allowOnlyTypes(['bs-card-body']),
                traits: [
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.card_style', 'Card style'),
                        name: 'card-style',
                        changeProp: 1,
                        options: [
                            { value: '', name: t('theme::pagebuilder.default', 'Default') },
                            { value: 'shadow-sm', name: 'Shadow sm' },
                            { value: 'shadow', name: 'Shadow' },
                            { value: 'shadow-lg', name: 'Shadow lg' },
                            { value: 'border-0', name: 'Border 0' },
                        ]
                    },
                ]
            },
            init() {
                this.on('change:card-style', this.handleCardStyleChange);
            },
            onLoad() {
                const classes = sanitizeClassList(this.getClasses());
                const currentStyle = classes.find((className) => ['shadow-sm', 'shadow', 'shadow-lg', 'border-0'].includes(className)) || '';
                this.set('card-style', currentStyle, { silent: true });
            },
            handleCardStyleChange() {
                const styleClass = this.get('card-style') || '';
                const classes = removeClassesByPredicate(this.getClasses(), (className) => ['shadow-sm', 'shadow', 'shadow-lg', 'border-0'].includes(className));
                if (styleClass) classes.push(styleClass);
                this.setClass([...new Set(classes)]);
            }
        }
    });

    dc.addType('bs-card-body', {
        isComponent: (element) => {
            if (element?.classList?.contains('card-body')) {
                return { type: 'bs-card-body' };
            }

            return false;
        },
        model: {
            defaults: {
                name: t('theme::pagebuilder.card', 'Card') + ' body',
                draggable: '[data-gjs-type="bs-card"]',
                droppable: allowCompactContent,
            }
        }
    });

    dc.addType('bs-alert', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.alert', 'Alert'),
                droppable: allowCompactContent,
                traits: [
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.variant', 'Variant'),
                        name: 'alert-variant',
                        changeProp: 1,
                        options: colorOptions,
                    },
                ]
            },
            init() {
                this.on('change:alert-variant', this.handleVariantChange);
                this.syncVariantFromClasses();
            },
            onLoad() {
                this.syncVariantFromClasses();
            },
            syncVariantFromClasses() {
                const classes = sanitizeClassList(this.getClasses());
                const alertClass = classes.find((className) => /^alert-(primary|secondary|success|danger|warning|info|light|dark)$/.test(className));
                this.set('alert-variant', alertClass ? alertClass.replace('alert-', '') : 'primary', { silent: true });
            },
            handleVariantChange() {
                const variant = this.get('alert-variant') || 'primary';
                const classes = removeClassesByPredicate(this.getClasses(), (className) => /^alert-(primary|secondary|success|danger|warning|info|light|dark)$/.test(className));
                if (!classes.includes('alert')) classes.push('alert');
                classes.push(`alert-${variant}`);
                this.setClass([...new Set(classes)]);
            }
        }
    });

    dc.addType('bs-badge', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.badge', 'Badge'),
                droppable: false,
                traits: [
                    {
                        type: 'select',
                        label: t('theme::pagebuilder.variant', 'Variant'),
                        name: 'badge-variant',
                        changeProp: 1,
                        options: colorOptions,
                    },
                ]
            },
            init() {
                this.on('change:badge-variant', this.handleVariantChange);
                this.syncVariantFromClasses();
            },
            onLoad() {
                this.syncVariantFromClasses();
            },
            syncVariantFromClasses() {
                const classes = sanitizeClassList(this.getClasses());
                const badgeClass = classes.find((className) => /^text-bg-(primary|secondary|success|danger|warning|info|light|dark)$/.test(className));
                this.set('badge-variant', badgeClass ? badgeClass.replace('text-bg-', '') : 'primary', { silent: true });
            },
            handleVariantChange() {
                const variant = this.get('badge-variant') || 'primary';
                const classes = removeClassesByPredicate(this.getClasses(), (className) => /^text-bg-(primary|secondary|success|danger|warning|info|light|dark)$/.test(className));
                if (!classes.includes('badge')) classes.push('badge');
                classes.push(`text-bg-${variant}`);
                this.setClass([...new Set(classes)]);
            }
        }
    });

    dc.addType('bs-list-group', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.list_group', 'List group'),
                droppable: false,
                traits: [
                    {
                        type: 'checkbox',
                        label: t('theme::pagebuilder.flush', 'Flush'),
                        name: 'list-flush',
                        changeProp: 1,
                    },
                ]
            },
            init() {
                this.on('change:list-flush', this.handleFlushChange);
            },
            onLoad() {
                this.set('list-flush', sanitizeClassList(this.getClasses()).includes('list-group-flush'), { silent: true });
            },
            handleFlushChange() {
                const isFlush = !!this.get('list-flush');
                const classes = removeClassesByPredicate(this.getClasses(), (className) => className === 'list-group-flush');
                if (isFlush) classes.push('list-group-flush');
                this.setClass([...new Set(classes)]);
            }
        }
    });

    dc.addType('bs-accordion', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.accordion', 'Accordion'),
                droppable: allowOnlyTypes(['bs-accordion-item']),
            }
        }
    });

    dc.addType('bs-accordion-item', {
        isComponent: (element) => {
            if (element?.classList?.contains('accordion-item')) {
                return { type: 'bs-accordion-item' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Accordion item',
                draggable: '[data-gjs-type="bs-accordion"]',
                droppable: allowOnlyTypes(['bs-accordion-header', 'bs-accordion-collapse']),
            }
        }
    });

    dc.addType('bs-accordion-header', {
        isComponent: (element) => {
            if (element?.classList?.contains('accordion-header')) {
                return { type: 'bs-accordion-header' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Accordion header',
                draggable: '[data-gjs-type="bs-accordion-item"]',
                droppable: allowOnlyTypes(['bs-accordion-button']),
            }
        }
    });

    dc.addType('bs-accordion-button', {
        isComponent: (element) => {
            if (element?.classList?.contains('accordion-button')) {
                return { type: 'bs-accordion-button' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Accordion button',
                draggable: '[data-gjs-type="bs-accordion-header"]',
                droppable: false,
                editable: true,
                copyable: true,
            }
        }
    });

    dc.addType('bs-accordion-collapse', {
        isComponent: (element) => {
            if (element?.classList?.contains('accordion-collapse')) {
                return { type: 'bs-accordion-collapse' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Accordion collapse',
                draggable: '[data-gjs-type="bs-accordion-item"]',
                droppable: allowOnlyTypes(['bs-accordion-body']),
            }
        }
    });

    dc.addType('bs-accordion-body', {
        isComponent: (element) => {
            if (element?.classList?.contains('accordion-body')) {
                return { type: 'bs-accordion-body' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Accordion body',
                draggable: '[data-gjs-type="bs-accordion-collapse"]',
                droppable: allowCompactContent,
                editable: true,
                copyable: true,
            }
        }
    });

    dc.addType('bs-tabs', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.tabs', 'Tabs'),
                droppable: false,
            }
        }
    });

    dc.addType('bs-tab-pane', {
        isComponent: (element) => {
            if (element?.classList?.contains('tab-pane')) {
                return { type: 'bs-tab-pane' };
            }

            return false;
        },
        model: {
            defaults: {
                name: t('theme::pagebuilder.tab_content_1', 'Tab content'),
                draggable: '[data-gjs-type="bs-tabs"]',
                droppable: allowCompactContent,
            }
        }
    });

    const componentHasClass = (component, className) => {
        const classes = sanitizeClassList(component?.getClasses?.() || []);
        return classes.includes(className);
    };

    const getCarouselChildByClass = (carouselModel, className) => {
        return carouselModel.components().models.find((child) => componentHasClass(child, className)) || null;
    };

    const getCarouselItems = (carouselInnerModel) => {
        return carouselInnerModel.components().models.filter((child) => componentHasClass(child, 'carousel-item'));
    };

    const setActiveClass = (component, isActive) => {
        const classes = sanitizeClassList(component.getClasses());
        const withoutActive = classes.filter((className) => className !== 'active');
        if (isActive) {
            withoutActive.push('active');
        }
        component.setClass([...new Set(withoutActive)]);
    };

    const getCarouselImageForIndex = (index) => {
        if (azuriomImages.length > 0) {
            return azuriomImages[index % azuriomImages.length]?.url || fallbackImage;
        }

        return fallbackImage;
    };

    dc.addType('bs-carousel', {
        model: {
            defaults: {
                name: t('theme::pagebuilder.carousel', 'Carousel'),
                droppable: false,
                traits: [
                    {
                        type: 'number',
                        label: t('theme::pagebuilder.slides_count', 'Slides count'),
                        name: 'slides-count',
                        changeProp: 1,
                        min: 1,
                        max: 8,
                        step: 1,
                    },
                ],
            },
            init() {
                this.on('change:slides-count', this.syncSlidesStructure);
                this.syncSlidesCountFromStructure();
                this.syncSlidesStructure();
            },
            onLoad() {
                this.syncSlidesCountFromStructure();
                this.syncSlidesStructure();
            },
            syncSlidesCountFromStructure() {
                const inner = getCarouselChildByClass(this, 'carousel-inner');
                const count = inner ? getCarouselItems(inner).length : 0;
                this.set('slides-count', Math.max(1, count || 3), { silent: true });
            },
            ensureCarouselId() {
                const attributes = { ...(this.getAttributes?.() || {}) };
                let id = attributes.id;
                if (!id || typeof id !== 'string') {
                    id = `carousel-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
                    attributes.id = id;
                    this.setAttributes(attributes);
                }

                return id;
            },
            ensureChildComponents() {
                let indicators = getCarouselChildByClass(this, 'carousel-indicators');
                let inner = getCarouselChildByClass(this, 'carousel-inner');

                if (!indicators) {
                    this.components().add({
                        type: 'bs-carousel-indicators',
                        classes: ['carousel-indicators'],
                    }, { at: 0 });
                    indicators = getCarouselChildByClass(this, 'carousel-indicators');
                }

                if (!inner) {
                    this.components().add({
                        type: 'bs-carousel-inner',
                        classes: ['carousel-inner'],
                    });
                    inner = getCarouselChildByClass(this, 'carousel-inner');
                }

                return { indicators, inner };
            },
            syncControlsTarget(carouselId) {
                this.components().models
                    .filter((child) => componentHasClass(child, 'carousel-control-prev') || componentHasClass(child, 'carousel-control-next'))
                    .forEach((control) => {
                        const attributes = { ...(control.getAttributes?.() || {}) };
                        attributes['data-bs-target'] = `#${carouselId}`;
                        control.setAttributes(attributes);
                    });
            },
            syncSlidesStructure() {
                const slideCount = Math.max(1, Math.min(8, parseInt(this.get('slides-count'), 10) || 3));
                this.set('slides-count', slideCount, { silent: true });

                const carouselId = this.ensureCarouselId();
                const { indicators, inner } = this.ensureChildComponents();
                if (!indicators || !inner) {
                    return;
                }

                const innerComponents = inner.components();
                let items = getCarouselItems(inner);

                while (items.length < slideCount) {
                    const nextIndex = items.length;
                    innerComponents.add({
                        type: 'bs-carousel-item',
                        classes: ['carousel-item', ...(nextIndex === 0 ? ['active'] : [])],
                        components: [
                            {
                                type: 'pb-image',
                                classes: ['d-block', 'w-100'],
                                attributes: {
                                    src: getCarouselImageForIndex(nextIndex),
                                    alt: `Slide ${nextIndex + 1}`,
                                },
                            }
                        ],
                    });
                    items = getCarouselItems(inner);
                }

                while (items.length > slideCount) {
                    innerComponents.remove(items[items.length - 1]);
                    items = getCarouselItems(inner);
                }

                items.forEach((item, index) => setActiveClass(item, index === 0));

                const indicatorModels = Array.from({ length: slideCount }, (_, index) => ({
                    type: 'bs-carousel-indicator',
                    tagName: 'button',
                    classes: index === 0 ? ['active'] : [],
                    attributes: {
                        type: 'button',
                        'data-bs-target': `#${carouselId}`,
                        'data-bs-slide-to': String(index),
                        ...(index === 0 ? { 'aria-current': 'true' } : {}),
                        'aria-label': `Slide ${index + 1}`,
                    },
                }));

                indicators.components().reset(indicatorModels);
                this.syncControlsTarget(carouselId);
            }
        }
    });

    dc.addType('bs-carousel-inner', {
        isComponent: (element) => {
            if (element?.classList?.contains('carousel-inner')) {
                return { type: 'bs-carousel-inner' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Carousel inner',
                draggable: '[data-gjs-type="bs-carousel"]',
                droppable: allowOnlyTypes(['bs-carousel-item']),
            }
        }
    });

    dc.addType('bs-carousel-item', {
        isComponent: (element) => {
            if (element?.classList?.contains('carousel-item')) {
                return { type: 'bs-carousel-item' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Carousel item',
                draggable: '[data-gjs-type="bs-carousel-inner"]',
                droppable: allowOnlyTypes(['pb-image', 'image']),
            }
        }
    });

    dc.addType('bs-carousel-indicators', {
        isComponent: (element) => {
            if (element?.classList?.contains('carousel-indicators')) {
                return { type: 'bs-carousel-indicators' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Carousel indicators',
                draggable: '[data-gjs-type="bs-carousel"]',
                droppable: false,
                removable: false,
                copyable: false,
                selectable: false,
                hoverable: false,
            }
        }
    });

    dc.addType('bs-carousel-indicator', {
        isComponent: (element) => {
            if (element?.tagName === 'BUTTON' && element?.closest?.('.carousel-indicators')) {
                return { type: 'bs-carousel-indicator' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Carousel indicator',
                droppable: false,
                draggable: false,
                removable: false,
                copyable: false,
                selectable: false,
                hoverable: false,
            }
        }
    });

    dc.addType('bs-carousel-control', {
        isComponent: (element) => {
            if (element?.classList?.contains('carousel-control-prev') || element?.classList?.contains('carousel-control-next')) {
                return { type: 'bs-carousel-control' };
            }

            return false;
        },
        model: {
            defaults: {
                name: 'Carousel control',
                droppable: false,
                draggable: false,
                removable: false,
                copyable: false,
                selectable: false,
                hoverable: false,
            }
        }
    });

    const registerPageComponent = (type, name) => {
        dc.addType(type, {
            isComponent: (element) => {
                if (element?.getAttribute?.('data-gjs-type') === type) {
                    return { type };
                }

                return false;
            },
            model: {
                defaults: {
                    name,
                    droppable: false,
                    editable: false,
                    copyable: true,
                }
            }
        });
    };

    const wrapDynamicPreview = (innerHtml) => `
        <div class="border rounded overflow-hidden">
            <div class="small text-bg-warning px-2 py-1 d-flex align-items-center gap-1">
                <i class="bi bi-info-circle"></i>
                Contenu dynamique: non modifiable ici
            </div>
            <div class="p-2">
                ${innerHtml}
            </div>
        </div>
    `;

    const siteComponentPreviews = {
        'site-navigation': () => wrapDynamicPreview(`
            <nav class="navbar navbar-expand-md navbar-dark bg-dark py-3">
                <div class="container">
                    <span class="navbar-brand">${escapeHtml(siteName)}</span>
                    <button class="navbar-toggler" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse show">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><span class="nav-link active">Home</span></li>
                            <li class="nav-item"><span class="nav-link">Boutique</span></li>
                            <li class="nav-item"><span class="nav-link">Vote</span></li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><span class="nav-link"><i class="bi bi-sun"></i></span></li>
                            <li class="nav-item"><span class="nav-link">Utilisateur</span></li>
                        </ul>
                    </div>
                </div>
            </nav>
        `),
        'site-user-navigation': () => wrapDynamicPreview(`
            <ul class="navbar-nav flex-column flex-xl-row justify-content-center list-unstyled mt-2 gap-3 align-items-center p-2 border rounded">
                <li class="nav-item dropdown d-flex flex-column flex-xl-row">
                    <span class="d-flex align-items-center gap-2 fw-bold text-uppercase dropdown-toggle">
                        <i class="bi bi-person-fill fs-5"></i> Mon compte
                    </span>
                </li>
            </ul>
        `),
        'site-logo': () => wrapDynamicPreview(`
            <a class="d-inline-block" href="#">
                <img src="${escapeHtml(siteLogoUrl)}" alt="Logo ${escapeHtml(siteName)}" class="w-100 object-fit-contain" style="max-width: 240px; max-height: 100px;" draggable="false">
            </a>
        `),
        'site-theme-toggle': () => wrapDynamicPreview(`
            <div class="d-inline-flex align-items-center justify-content-center p-2 border rounded">
                <i class="bi bi-cloud-sun-fill fs-4" title="Theme toggle"></i>
            </div>
        `),
        'site-social-links': () => {
            const defaults = [
                { icon: 'bi bi-discord', color: '#5865F2', title: 'Discord' },
                { icon: 'bi bi-youtube', color: '#FF0000', title: 'YouTube' },
                { icon: 'bi bi-twitter-x', color: '#1F1F1F', title: 'X' },
            ];
            const links = (siteSocialLinks.length > 0 ? siteSocialLinks : defaults).slice(0, 6);
            const items = links.map((link) => {
                const icon = typeof link.icon === 'string' && link.icon.trim() !== '' ? link.icon : 'bi bi-link-45deg';
                const color = typeof link.color === 'string' && link.color.trim() !== '' ? link.color : '#0d6efd';
                const title = typeof link.title === 'string' && link.title.trim() !== '' ? link.title : 'Social';

                return `
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                          title="${escapeHtml(title)}"
                          style="width: 40px; height: 40px; background: ${escapeHtml(color)};">
                        <i class="${escapeHtml(icon)} text-white"></i>
                    </span>
                `;
            }).join('');

            return wrapDynamicPreview(`<div class="d-flex flex-wrap justify-content-center gap-2 py-2">${items}</div>`);
        },
        'site-copyright': () => wrapDynamicPreview(`
            <p class="mb-0">${escapeHtml(siteCopyright)} | ${escapeHtml(t('messages.copyright', 'All rights reserved'))}</p>
        `),
    };

    const registerSiteComponent = (type, name) => {
        const buildPreview = siteComponentPreviews[type]
            || (() => `<div class="small text-body-secondary">${escapeHtml(name)}</div>`);

        dc.addType(type, {
            isComponent: (element) => {
                if (element?.getAttribute?.('data-gjs-type') === type) {
                    return { type };
                }

                return false;
            },
            model: {
                defaults: {
                    name,
                    droppable: false,
                    editable: false,
                    copyable: true,
                    stylable: true,
                    components: buildPreview(),
                },
                init() {
                    this.syncPreview();
                },
                onLoad() {
                    this.syncPreview();
                },
                syncPreview() {
                    this.components(buildPreview());
                    lockChildrenTree(this);
                },
            }
        });
    };

    registerSiteComponent('site-navigation', t('theme::pagebuilder.site_navigation', 'Site navigation'));
    registerSiteComponent('site-user-navigation', t('theme::pagebuilder.user_navigation', 'User navigation'));
    registerSiteComponent('site-logo', t('theme::pagebuilder.site_logo', 'Site logo'));
    registerSiteComponent('site-theme-toggle', t('theme::pagebuilder.theme_toggle', 'Theme toggle'));
    registerSiteComponent('site-social-links', t('theme::pagebuilder.social_links', 'Social links'));
    registerSiteComponent('site-copyright', t('theme::pagebuilder.copyright', 'Copyright'));

    registerPageComponent('page-vote-card', t('theme::pagebuilder.page_vote_card', 'Vote - Vote card'));
    registerPageComponent('page-vote-top', t('theme::pagebuilder.page_vote_top', 'Vote - Top voters'));
    registerPageComponent('page-vote-rewards', t('theme::pagebuilder.page_vote_rewards', 'Vote - Rewards'));
    registerPageComponent('page-shop-sidebar', t('theme::pagebuilder.page_shop_sidebar', 'Shop - Sidebar'));
    registerPageComponent('page-shop-home', t('theme::pagebuilder.page_shop_home_welcome', 'Shop - Home welcome'));
    registerPageComponent('page-shop-category-description', t('theme::pagebuilder.page_shop_category_description', 'Shop - Category description'));
    registerPageComponent('page-shop-category-packages', t('theme::pagebuilder.page_shop_category_packages', 'Shop - Package grid'));
}
