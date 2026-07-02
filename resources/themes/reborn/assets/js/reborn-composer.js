(function () {
    const boot = window.rebornComposerBoot;
    if (!boot || !boot.context || !boot.routes) {
        return;
    }

    const t = (key, fallback = null) => {
        const fullKey = `theme::reborn.${key}`;
        return boot.translations?.[fullKey] ?? fallback ?? fullKey;
    };

    const parseMaybeJson = (value) => {
        if (!value) {
            return {};
        }

        if (typeof value === 'string') {
            try {
                return JSON.parse(value);
            } catch (error) {
                return {};
            }
        }

        if (typeof value === 'object' && !Array.isArray(value)) {
            return value;
        }

        return {};
    };

    const clone = (value) => JSON.parse(JSON.stringify(value));
    const uid = (prefix = 'rb') => `${prefix}-${Date.now()}-${Math.floor(Math.random() * 100000)}`;
    const clamp = (value, min, max, fallback = min) => {
        const parsed = Number(value);
        if (!Number.isFinite(parsed)) {
            return fallback;
        }
        return Math.min(Math.max(parsed, min), max);
    };

    const defaultTheme = () => ({
        mode: 'light',
        header: {
            position: 'top',
            width: 280,
        },
        footer: {
            position: 'default',
        },
        colorsLight: {
            primary: '#0d6efd',
            secondary: '#6c757d',
            success: '#198754',
            info: '#0dcaf0',
            warning: '#ffc107',
            danger: '#dc3545',
            light: '#f8f9fa',
            dark: '#212529',
            body: '#ffffff',
            text: '#212529',
        },
        colorsDark: {
            primary: '#6ea8fe',
            secondary: '#adb5bd',
            success: '#75b798',
            info: '#6edff6',
            warning: '#ffda6a',
            danger: '#ea868f',
            light: '#f8f9fa',
            dark: '#dee2e6',
            body: '#111827',
            text: '#f1f5f9',
        },
        bootstrap: {
            buttonRadius: 6,
            cardPaddingY: 16,
            cardPaddingX: 16,
            buttonPaddingY: 6,
            buttonPaddingX: 12,
            buttonWeight: 500,
            formRadius: 6,
            navPaddingY: 0.5,
            navPaddingX: 0.85,
            cardShadowLevel: 1,
            buttonShadowLevel: 0,
            linkColor: '#0d6efd',
            linkHoverColor: '#0a58ca',
        },
    });

    const defaultComposer = () => ({
        schema_version: 1,
        theme: defaultTheme(),
        global: {
            blocks: [
                { id: 'global-custom-css', type: 'custom-css', enabled: true, settings: { css: '' } },
            ],
            sidebar_blocks: [],
        },
        pages: {},
    });

    const flattenRegistry = (categories) => {
        const flat = {};
        const list = [];

        (Array.isArray(categories) ? categories : []).forEach((category) => {
            const categoryId = category?.id ?? '';
            const categoryLabel = category?.label ?? categoryId;
            (Array.isArray(category?.blocks) ? category.blocks : []).forEach((block) => {
                if (!block || typeof block.type !== 'string') {
                    return;
                }
                flat[block.type] = block;
                list.push({
                    ...block,
                    categoryId,
                    categoryLabel,
                });
            });
        });

        return { flat, list };
    };

    const registry = flattenRegistry(boot.registry);

    const ensureBlockShape = (block, defaults = {}) => {
        const next = typeof block === 'object' && block && !Array.isArray(block) ? block : {};
        return {
            id: typeof next.id === 'string' && next.id !== '' ? next.id : uid('block'),
            type: typeof next.type === 'string' ? next.type : '',
            enabled: Object.prototype.hasOwnProperty.call(next, 'enabled') ? !!next.enabled : true,
            settings: {
                ...clone(defaults),
                ...(typeof next.settings === 'object' && next.settings && !Array.isArray(next.settings) ? next.settings : {}),
            },
        };
    };

    const ensureCustomCssBlock = (blocks, idPrefix) => {
        const hasCssBlock = blocks.some((block) => block.type === 'custom-css');
        if (!hasCssBlock) {
            blocks.push({
                id: `${idPrefix}-custom-css`,
                type: 'custom-css',
                enabled: true,
                settings: { css: '' },
            });
        }
    };

    const ensurePageEntry = (state, pageKey) => {
        if (!state.pages[pageKey] || typeof state.pages[pageKey] !== 'object' || Array.isArray(state.pages[pageKey])) {
            state.pages[pageKey] = { blocks: [] };
        }

        if (!Array.isArray(state.pages[pageKey].blocks)) {
            state.pages[pageKey].blocks = [];
        }

        state.pages[pageKey].blocks = state.pages[pageKey].blocks
            .map((block) => {
                const def = registry.flat[block?.type] ?? null;
                return ensureBlockShape(block, def?.defaults ?? {});
            })
            .filter((block) => !!registry.flat[block.type]);

        ensureCustomCssBlock(state.pages[pageKey].blocks, `${pageKey.replace(/[^a-z0-9]/gi, '-')}`);
    };

    const ensureConfig = (raw) => {
        const defaults = defaultComposer();
        const source = typeof raw === 'object' && raw && !Array.isArray(raw) ? raw : {};

        const next = {
            schema_version: 1,
            theme: {
                ...defaults.theme,
                ...(typeof source.theme === 'object' && source.theme && !Array.isArray(source.theme) ? source.theme : {}),
                header: {
                    ...defaults.theme.header,
                    ...(typeof source?.theme?.header === 'object' && source.theme.header && !Array.isArray(source.theme.header) ? source.theme.header : {}),
                },
                footer: {
                    ...defaults.theme.footer,
                    ...(typeof source?.theme?.footer === 'object' && source.theme.footer && !Array.isArray(source.theme.footer) ? source.theme.footer : {}),
                },
                colorsLight: {
                    ...defaults.theme.colorsLight,
                    ...(typeof source?.theme?.colorsLight === 'object' && source.theme.colorsLight && !Array.isArray(source.theme.colorsLight) ? source.theme.colorsLight : {}),
                },
                colorsDark: {
                    ...defaults.theme.colorsDark,
                    ...(typeof source?.theme?.colorsDark === 'object' && source.theme.colorsDark && !Array.isArray(source.theme.colorsDark) ? source.theme.colorsDark : {}),
                },
                bootstrap: {
                    ...defaults.theme.bootstrap,
                    ...(typeof source?.theme?.bootstrap === 'object' && source.theme.bootstrap && !Array.isArray(source.theme.bootstrap) ? source.theme.bootstrap : {}),
                },
            },
            global: {
                blocks: [],
                sidebar_blocks: [],
            },
            pages: typeof source.pages === 'object' && source.pages && !Array.isArray(source.pages) ? source.pages : {},
        };

        const sourceGlobalBlocks = Array.isArray(source?.global?.blocks) ? source.global.blocks : defaults.global.blocks;
        const sourceSidebarBlocks = Array.isArray(source?.global?.sidebar_blocks) ? source.global.sidebar_blocks : defaults.global.sidebar_blocks;

        next.global.blocks = sourceGlobalBlocks
            .map((block) => {
                const def = registry.flat[block?.type] ?? null;
                return ensureBlockShape(block, def?.defaults ?? {});
            })
            .filter((block) => !!registry.flat[block.type]);

        next.global.sidebar_blocks = sourceSidebarBlocks
            .map((block) => {
                const def = registry.flat[block?.type] ?? null;
                return ensureBlockShape(block, def?.defaults ?? {});
            })
            .filter((block) => !!registry.flat[block.type]);

        ensureCustomCssBlock(next.global.blocks, 'global');
        ensurePageEntry(next, boot.context.pageKey);

        return next;
    };

    const isBlockAllowedForSection = (definition, section) => {
        if (!definition) {
            return false;
        }

        const placements = Array.isArray(definition.placements) ? definition.placements : ['body'];
        const scopes = Array.isArray(definition.scopes) ? definition.scopes : ['global', 'page'];
        const requiredFeatures = Array.isArray(definition.requires) ? definition.requires : [];

        const hasFeatures = requiredFeatures.every((feature) => !!boot.features?.[feature]);
        if (!hasFeatures) {
            return false;
        }

        if (section === 'global' || section === 'sidebar') {
            return placements.includes('body') && scopes.includes('global');
        }

        return placements.includes('body') && scopes.includes('page');
    };

    const sectionLabel = (section) => {
        if (section === 'global') return t('global_blocks', 'Global blocks');
        if (section === 'sidebar') return t('global_sidebar_blocks', 'Global sidebar blocks');
        return t('page_blocks', 'Current page blocks');
    };

    const pageKey = boot.context.pageKey;
    let state = ensureConfig(parseMaybeJson(boot.initialComposer));
    let selected = null;
    let currentAddSection = 'global';

    const openBtn = document.getElementById('rebornBuilderOpenBtn');
    const saveBtn = document.getElementById('rebornComposerSaveBtn');
    const offcanvasEl = document.getElementById('rebornComposerOffcanvas');
    const modalEl = document.getElementById('rebornAddBlockModal');
    const modalBody = document.getElementById('rebornAddBlockModalBody');

    if (!openBtn || !saveBtn || !offcanvasEl || !modalEl || !modalBody) {
        return;
    }

    const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
    const addModal = new bootstrap.Modal(modalEl);

    const sectionContainers = {
        global: document.getElementById('rebornGlobalBlocks'),
        sidebar: document.getElementById('rebornSidebarBlocks'),
        page: document.getElementById('rebornPageBlocks'),
    };
    const blockEditor = document.getElementById('rebornBlockEditor');
    const themeEditor = document.getElementById('rebornThemeEditor');

    const getSectionBlocks = (section) => {
        if (section === 'global') return state.global.blocks;
        if (section === 'sidebar') return state.global.sidebar_blocks;
        ensurePageEntry(state, pageKey);
        return state.pages[pageKey].blocks;
    };

    const setSectionBlocks = (section, blocks) => {
        if (section === 'global') {
            state.global.blocks = blocks;
            ensureCustomCssBlock(state.global.blocks, 'global');
            return;
        }

        if (section === 'sidebar') {
            state.global.sidebar_blocks = blocks;
            return;
        }

        ensurePageEntry(state, pageKey);
        state.pages[pageKey].blocks = blocks;
        ensureCustomCssBlock(state.pages[pageKey].blocks, `${pageKey.replace(/[^a-z0-9]/gi, '-')}`);
    };

    const escapeHtml = (value) => String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    const getSelectedBlock = () => {
        if (!selected) {
            return null;
        }

        const blocks = getSectionBlocks(selected.section);
        const block = blocks[selected.index] ?? null;
        if (!block) {
            return null;
        }

        return block;
    };

    const selectBlock = (section, index) => {
        selected = { section, index };
        renderSections();
        renderBlockEditor();
    };

    const mutateSelectedBlock = (mutator) => {
        const block = getSelectedBlock();
        if (!block) {
            return;
        }

        mutator(block);
        renderSections();
        renderBlockEditor();
    };

    const removeSelected = () => {
        if (!selected) {
            return;
        }

        const blocks = [...getSectionBlocks(selected.section)];
        blocks.splice(selected.index, 1);
        setSectionBlocks(selected.section, blocks);
        selected = null;
        renderSections();
        renderBlockEditor();
    };

    const moveSelected = (direction) => {
        if (!selected) {
            return;
        }

        const blocks = [...getSectionBlocks(selected.section)];
        const targetIndex = selected.index + direction;
        if (!blocks[targetIndex]) {
            return;
        }

        const temp = blocks[selected.index];
        blocks[selected.index] = blocks[targetIndex];
        blocks[targetIndex] = temp;
        setSectionBlocks(selected.section, blocks);
        selected.index = targetIndex;
        renderSections();
    };

    const duplicateSelected = () => {
        const block = getSelectedBlock();
        if (!block || !selected) {
            return;
        }

        const duplicated = clone(block);
        duplicated.id = uid('dup');
        const blocks = [...getSectionBlocks(selected.section)];
        blocks.splice(selected.index + 1, 0, duplicated);
        setSectionBlocks(selected.section, blocks);
        selected.index += 1;
        renderSections();
        renderBlockEditor();
    };

    const renderSections = () => {
        ['global', 'sidebar', 'page'].forEach((section) => {
            const container = sectionContainers[section];
            if (!container) {
                return;
            }

            const blocks = getSectionBlocks(section);
            if (!blocks.length) {
                container.innerHTML = `<p class="text-muted mb-0 small">${escapeHtml(t('no_blocks', 'No blocks in this section.'))}</p>`;
                return;
            }

            const html = blocks.map((block, index) => {
                const def = registry.flat[block.type];
                const isSelected = selected && selected.section === section && selected.index === index;
                const enabled = Object.prototype.hasOwnProperty.call(block, 'enabled') ? !!block.enabled : true;
                const enabledLabel = enabled ? t('enabled', 'Enabled') : t('disabled', 'Disabled');
                return `
                    <article class="reborn-block-item ${isSelected ? 'is-selected' : ''}">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <button type="button" class="btn btn-link p-0 text-start text-decoration-none flex-grow-1"
                                    data-action="select" data-section="${section}" data-index="${index}">
                                <span class="fw-semibold d-block">${escapeHtml(def?.label ?? block.type)}</span>
                                <span class="small text-muted">${escapeHtml(def?.description ?? '')}</span>
                            </button>
                            <span class="badge ${enabled ? 'text-bg-success' : 'text-bg-secondary'}">${escapeHtml(enabledLabel)}</span>
                        </div>
                        <div class="btn-group btn-group-sm mt-2" role="group">
                            <button type="button" class="btn btn-outline-secondary" data-action="up" data-section="${section}" data-index="${index}" title="${escapeHtml(t('move_up', 'Move up'))}">
                                <i class="bi bi-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-action="down" data-section="${section}" data-index="${index}" title="${escapeHtml(t('move_down', 'Move down'))}">
                                <i class="bi bi-arrow-down"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-action="toggle" data-section="${section}" data-index="${index}">
                                <i class="bi ${enabled ? 'bi-toggle-on' : 'bi-toggle-off'}"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-action="duplicate" data-section="${section}" data-index="${index}" title="${escapeHtml(t('duplicate_block', 'Duplicate'))}">
                                <i class="bi bi-copy"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-action="remove" data-section="${section}" data-index="${index}" title="${escapeHtml(t('remove_block', 'Remove'))}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </article>
                `;
            }).join('');

            container.innerHTML = html;
        });

        Object.values(sectionContainers).forEach((container) => {
            if (!container) return;
            container.querySelectorAll('[data-action]').forEach((button) => {
                button.addEventListener('click', () => {
                    const action = button.getAttribute('data-action');
                    const section = button.getAttribute('data-section');
                    const index = Number(button.getAttribute('data-index'));
                    if (!section || Number.isNaN(index)) {
                        return;
                    }

                    if (action === 'select') {
                        selectBlock(section, index);
                        return;
                    }

                    const blocks = [...getSectionBlocks(section)];
                    const block = blocks[index];
                    if (!block) {
                        return;
                    }

                    if (action === 'toggle') {
                        block.enabled = !(Object.prototype.hasOwnProperty.call(block, 'enabled') ? !!block.enabled : true);
                        blocks[index] = block;
                        setSectionBlocks(section, blocks);
                        renderSections();
                        renderBlockEditor();
                        return;
                    }

                    if (action === 'remove') {
                        blocks.splice(index, 1);
                        setSectionBlocks(section, blocks);
                        if (selected && selected.section === section && selected.index === index) {
                            selected = null;
                        } else if (selected && selected.section === section && selected.index > index) {
                            selected.index -= 1;
                        }
                        renderSections();
                        renderBlockEditor();
                        return;
                    }

                    if (action === 'duplicate') {
                        const duplicate = clone(block);
                        duplicate.id = uid('dup');
                        blocks.splice(index + 1, 0, duplicate);
                        setSectionBlocks(section, blocks);
                        selected = { section, index: index + 1 };
                        renderSections();
                        renderBlockEditor();
                        return;
                    }

                    if (action === 'up' && index > 0) {
                        const tmp = blocks[index - 1];
                        blocks[index - 1] = blocks[index];
                        blocks[index] = tmp;
                        setSectionBlocks(section, blocks);
                        if (selected && selected.section === section && selected.index === index) {
                            selected.index -= 1;
                        }
                        renderSections();
                        return;
                    }

                    if (action === 'down' && index < blocks.length - 1) {
                        const tmp = blocks[index + 1];
                        blocks[index + 1] = blocks[index];
                        blocks[index] = tmp;
                        setSectionBlocks(section, blocks);
                        if (selected && selected.section === section && selected.index === index) {
                            selected.index += 1;
                        }
                        renderSections();
                    }
                });
            });
        });
    };

    const getFieldDefault = (field) => {
        if (Object.prototype.hasOwnProperty.call(field, 'default')) {
            return clone(field.default);
        }
        if (field.type === 'switch') return false;
        if (field.type === 'number') return field.min ?? 0;
        if (field.type === 'collection') return [];
        return '';
    };

    const createCollectionItem = (field) => {
        const item = {};
        (Array.isArray(field.fields) ? field.fields : []).forEach((subField) => {
            item[subField.key] = getFieldDefault(subField);
        });
        return item;
    };

    const renderSimpleField = (field, value) => {
        const key = escapeHtml(field.key);
        const label = escapeHtml(field.label ?? field.key);
        const placeholder = escapeHtml(field.placeholder ?? '');

        if (field.type === 'textarea' || field.type === 'code') {
            const classes = field.type === 'code' ? 'form-control font-monospace' : 'form-control';
            const rows = field.type === 'code' ? 10 : 3;
            return `
                <div>
                    <label class="form-label">${label}</label>
                    <textarea class="${classes}" rows="${rows}" data-field-key="${key}">${escapeHtml(value ?? '')}</textarea>
                </div>
            `;
        }

        if (field.type === 'switch') {
            return `
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" data-field-key="${key}" ${value ? 'checked' : ''}>
                    <label class="form-check-label">${label}</label>
                </div>
            `;
        }

        if (field.type === 'select') {
            const options = (Array.isArray(field.options) ? field.options : [])
                .map((option) => {
                    const optionValue = String(option.value ?? '');
                    const selectedAttr = String(value ?? '') === optionValue ? 'selected' : '';
                    return `<option value="${escapeHtml(optionValue)}" ${selectedAttr}>${escapeHtml(option.label ?? optionValue)}</option>`;
                })
                .join('');

            return `
                <div>
                    <label class="form-label">${label}</label>
                    <select class="form-select" data-field-key="${key}">
                        ${options}
                    </select>
                </div>
            `;
        }

        const inputType = field.type === 'number' ? 'number' : (field.type === 'color' ? 'color' : 'text');
        const minAttr = field.type === 'number' && field.min !== undefined ? `min="${escapeHtml(field.min)}"` : '';
        const maxAttr = field.type === 'number' && field.max !== undefined ? `max="${escapeHtml(field.max)}"` : '';
        const stepAttr = field.type === 'number' && field.step !== undefined ? `step="${escapeHtml(field.step)}"` : '';

        return `
            <div>
                <label class="form-label">${label}</label>
                <input type="${inputType}" class="form-control" data-field-key="${key}" value="${escapeHtml(value ?? '')}" placeholder="${placeholder}" ${minAttr} ${maxAttr} ${stepAttr}>
            </div>
        `;
    };

    const renderCollectionField = (field, value) => {
        const items = Array.isArray(value) ? value : [];
        const label = escapeHtml(field.label ?? field.key);
        const min = field.min ?? 0;
        const max = field.max ?? 20;
        const key = escapeHtml(field.key);

        const itemsHtml = items.map((item, itemIndex) => {
            const itemFields = (Array.isArray(field.fields) ? field.fields : []).map((subField) => {
                const subKey = escapeHtml(subField.key);
                const subLabel = escapeHtml(subField.label ?? subField.key);
                const subValue = item?.[subField.key];

                if (subField.type === 'textarea' || subField.type === 'code') {
                    return `
                        <div class="mb-2">
                            <label class="form-label small">${subLabel}</label>
                            <textarea class="form-control form-control-sm ${subField.type === 'code' ? 'font-monospace' : ''}" rows="${subField.type === 'code' ? 6 : 2}"
                                      data-collection-key="${key}" data-item-index="${itemIndex}" data-sub-key="${subKey}">${escapeHtml(subValue ?? '')}</textarea>
                        </div>
                    `;
                }

                if (subField.type === 'select') {
                    const options = (Array.isArray(subField.options) ? subField.options : [])
                        .map((option) => {
                            const optionValue = String(option.value ?? '');
                            const selectedAttr = String(subValue ?? '') === optionValue ? 'selected' : '';
                            return `<option value="${escapeHtml(optionValue)}" ${selectedAttr}>${escapeHtml(option.label ?? optionValue)}</option>`;
                        })
                        .join('');

                    return `
                        <div class="mb-2">
                            <label class="form-label small">${subLabel}</label>
                            <select class="form-select form-select-sm"
                                    data-collection-key="${key}" data-item-index="${itemIndex}" data-sub-key="${subKey}">
                                ${options}
                            </select>
                        </div>
                    `;
                }

                const inputType = subField.type === 'number' ? 'number' : 'text';
                const minAttr = subField.type === 'number' && subField.min !== undefined ? `min="${escapeHtml(subField.min)}"` : '';
                const maxAttr = subField.type === 'number' && subField.max !== undefined ? `max="${escapeHtml(subField.max)}"` : '';
                const stepAttr = subField.type === 'number' && subField.step !== undefined ? `step="${escapeHtml(subField.step)}"` : '';

                return `
                    <div class="mb-2">
                        <label class="form-label small">${subLabel}</label>
                        <input type="${inputType}" class="form-control form-control-sm"
                               data-collection-key="${key}" data-item-index="${itemIndex}" data-sub-key="${subKey}"
                               value="${escapeHtml(subValue ?? '')}" ${minAttr} ${maxAttr} ${stepAttr}>
                    </div>
                `;
            }).join('');

            return `
                <article class="reborn-builder-field-group">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                        <strong class="small">Item ${itemIndex + 1}</strong>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-secondary" data-collection-move="-1" data-collection-key="${key}" data-item-index="${itemIndex}">
                                <i class="bi bi-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-collection-move="1" data-collection-key="${key}" data-item-index="${itemIndex}">
                                <i class="bi bi-arrow-down"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-collection-remove="1" data-collection-key="${key}" data-item-index="${itemIndex}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    ${itemFields}
                </article>
            `;
        }).join('');

        return `
            <div class="reborn-builder-field-group">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                    <label class="form-label mb-0">${label}</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" class="form-control form-control-sm" style="width:90px"
                               data-collection-count="${key}" value="${items.length}" min="${min}" max="${max}">
                        <button type="button" class="btn btn-outline-primary btn-sm" data-collection-add="${key}">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="reborn-builder-collection">
                    ${itemsHtml}
                </div>
            </div>
        `;
    };

    const renderBlockEditor = () => {
        if (!blockEditor) {
            return;
        }

        const block = getSelectedBlock();
        if (!block) {
            blockEditor.innerHTML = `<p class="text-muted mb-0">${escapeHtml(t('select_block', 'Select a block to edit its settings.'))}</p>`;
            return;
        }

        const definition = registry.flat[block.type];
        if (!definition) {
            blockEditor.innerHTML = `<p class="text-danger mb-0">Unknown block type: ${escapeHtml(block.type)}</p>`;
            return;
        }

        const fields = Array.isArray(definition.fields) ? definition.fields : [];
        if (!fields.length) {
            blockEditor.innerHTML = `<p class="text-muted mb-0">No settings for this block.</p>`;
            return;
        }

        const html = fields.map((field) => {
            const value = block.settings?.[field.key];
            if (field.type === 'collection') {
                return renderCollectionField(field, value);
            }
            return renderSimpleField(field, value);
        }).join('');

        blockEditor.innerHTML = `<div class="reborn-builder-fields">${html}</div>`;

        blockEditor.querySelectorAll('[data-field-key]').forEach((input) => {
            const key = input.getAttribute('data-field-key');
            if (!key) {
                return;
            }

            input.addEventListener('input', () => {
                const current = getSelectedBlock();
                const definitionField = fields.find((field) => field.key === key);
                if (!current || !definitionField) {
                    return;
                }

                if (definitionField.type === 'switch') {
                    current.settings[key] = !!input.checked;
                    return;
                }

                if (definitionField.type === 'number') {
                    current.settings[key] = input.value === '' ? '' : Number(input.value);
                    return;
                }

                current.settings[key] = input.value;
            });

            if (input.tagName === 'SELECT' || input.type === 'checkbox') {
                input.addEventListener('change', () => input.dispatchEvent(new Event('input', { bubbles: true })));
            }
        });

        blockEditor.querySelectorAll('[data-collection-count]').forEach((input) => {
            input.addEventListener('input', () => {
                const key = input.getAttribute('data-collection-count');
                const field = fields.find((item) => item.key === key);
                if (!key || !field) {
                    return;
                }

                const min = field.min ?? 0;
                const max = field.max ?? 20;
                const count = clamp(input.value, min, max, min);

                mutateSelectedBlock((current) => {
                    const currentItems = Array.isArray(current.settings[key]) ? [...current.settings[key]] : [];
                    while (currentItems.length < count) {
                        currentItems.push(createCollectionItem(field));
                    }
                    while (currentItems.length > count) {
                        currentItems.pop();
                    }
                    current.settings[key] = currentItems;
                });
            });
        });

        blockEditor.querySelectorAll('[data-collection-add]').forEach((button) => {
            button.addEventListener('click', () => {
                const key = button.getAttribute('data-collection-add');
                const field = fields.find((item) => item.key === key);
                if (!key || !field) {
                    return;
                }

                mutateSelectedBlock((current) => {
                    const items = Array.isArray(current.settings[key]) ? [...current.settings[key]] : [];
                    const max = field.max ?? 20;
                    if (items.length >= max) {
                        return;
                    }
                    items.push(createCollectionItem(field));
                    current.settings[key] = items;
                });
            });
        });

        blockEditor.querySelectorAll('[data-collection-remove]').forEach((button) => {
            button.addEventListener('click', () => {
                const key = button.getAttribute('data-collection-key');
                const index = Number(button.getAttribute('data-item-index'));
                const field = fields.find((item) => item.key === key);
                if (!key || Number.isNaN(index) || !field) {
                    return;
                }

                mutateSelectedBlock((current) => {
                    const items = Array.isArray(current.settings[key]) ? [...current.settings[key]] : [];
                    const min = field.min ?? 0;
                    if (items.length <= min) {
                        return;
                    }
                    items.splice(index, 1);
                    current.settings[key] = items;
                });
            });
        });

        blockEditor.querySelectorAll('[data-collection-move]').forEach((button) => {
            button.addEventListener('click', () => {
                const key = button.getAttribute('data-collection-key');
                const index = Number(button.getAttribute('data-item-index'));
                const delta = Number(button.getAttribute('data-collection-move'));
                if (!key || Number.isNaN(index) || Number.isNaN(delta)) {
                    return;
                }

                mutateSelectedBlock((current) => {
                    const items = Array.isArray(current.settings[key]) ? [...current.settings[key]] : [];
                    const target = index + delta;
                    if (!items[target]) {
                        return;
                    }
                    const temp = items[index];
                    items[index] = items[target];
                    items[target] = temp;
                    current.settings[key] = items;
                });
            });
        });

        blockEditor.querySelectorAll('[data-collection-key][data-sub-key]').forEach((input) => {
            input.addEventListener('input', () => {
                const key = input.getAttribute('data-collection-key');
                const subKey = input.getAttribute('data-sub-key');
                const itemIndex = Number(input.getAttribute('data-item-index'));
                const field = fields.find((item) => item.key === key);
                if (!key || !subKey || Number.isNaN(itemIndex) || !field) {
                    return;
                }

                const subField = (Array.isArray(field.fields) ? field.fields : []).find((item) => item.key === subKey);
                if (!subField) {
                    return;
                }

                const current = getSelectedBlock();
                if (!current) {
                    return;
                }

                const items = Array.isArray(current.settings[key]) ? current.settings[key] : [];
                if (!items[itemIndex]) {
                    items[itemIndex] = createCollectionItem(field);
                }

                const next = { ...(items[itemIndex] ?? {}) };
                next[subKey] = subField.type === 'number' ? Number(input.value || 0) : input.value;
                items[itemIndex] = next;
                current.settings[key] = items;
            });

            if (input.tagName === 'SELECT') {
                input.addEventListener('change', () => input.dispatchEvent(new Event('input', { bubbles: true })));
            }
        });
    };

    const colorKeys = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark', 'body', 'text'];

    const renderPalette = (scheme, values) => {
        return `
            <div class="reborn-builder-field-group">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">${scheme === 'light' ? t('light', 'Light') : t('dark', 'Dark')}</h6>
                </div>
                <div class="row g-2">
                    ${colorKeys.map((key) => `
                        <div class="col-6 col-xl-4">
                            <label class="form-label small mb-1">${escapeHtml(key)}</label>
                            <input type="color" class="form-control form-control-color w-100"
                                   data-theme-palette="${scheme}" data-theme-color="${escapeHtml(key)}"
                                   value="${escapeHtml(values?.[key] ?? '#000000')}">
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    };

    const renderThemeEditor = () => {
        if (!themeEditor) {
            return;
        }

        const theme = state.theme ?? defaultTheme();
        const header = theme.header ?? {};
        const footer = theme.footer ?? {};
        const bs = theme.bootstrap ?? {};

        themeEditor.innerHTML = `
            <div class="reborn-builder-fields">
                <div class="reborn-builder-field-group">
                    <h6>${escapeHtml(t('theme_mode', 'Theme mode'))}</h6>
                    <select class="form-select" data-theme-path="mode">
                        <option value="light" ${theme.mode === 'light' ? 'selected' : ''}>${escapeHtml(t('light', 'Light'))}</option>
                        <option value="dark" ${theme.mode === 'dark' ? 'selected' : ''}>${escapeHtml(t('dark', 'Dark'))}</option>
                    </select>
                </div>

                <div class="reborn-builder-field-group">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">${escapeHtml(t('header_position', 'Header position'))}</label>
                            <select class="form-select" data-theme-path="header.position">
                                <option value="top" ${header.position === 'top' ? 'selected' : ''}>${escapeHtml(t('header_top', 'Top'))}</option>
                                <option value="left" ${header.position === 'left' ? 'selected' : ''}>${escapeHtml(t('header_left', 'Left'))}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">${escapeHtml(t('footer_position', 'Footer position'))}</label>
                            <select class="form-select" data-theme-path="footer.position">
                                <option value="default" ${footer.position === 'default' ? 'selected' : ''}>${escapeHtml(t('footer_default', 'Default'))}</option>
                                <option value="fixed" ${footer.position === 'fixed' ? 'selected' : ''}>${escapeHtml(t('footer_fixed', 'Fixed bottom'))}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Header width (left)</label>
                            <input type="number" class="form-control" data-theme-path="header.width" min="220" max="420" step="1" value="${escapeHtml(header.width ?? 280)}">
                        </div>
                    </div>
                </div>

                ${renderPalette('light', theme.colorsLight)}
                ${renderPalette('dark', theme.colorsDark)}

                <div class="reborn-builder-field-group">
                    <h6>Bootstrap overrides</h6>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label small">Button radius</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.buttonRadius" value="${escapeHtml(bs.buttonRadius ?? 6)}" min="0" max="64">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Button padding Y</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.buttonPaddingY" value="${escapeHtml(bs.buttonPaddingY ?? 6)}" min="0" max="32" step="0.5">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Button padding X</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.buttonPaddingX" value="${escapeHtml(bs.buttonPaddingX ?? 12)}" min="0" max="48" step="0.5">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Button weight</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.buttonWeight" value="${escapeHtml(bs.buttonWeight ?? 500)}" min="100" max="900" step="100">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Card padding Y</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.cardPaddingY" value="${escapeHtml(bs.cardPaddingY ?? 16)}" min="0" max="64">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Card padding X</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.cardPaddingX" value="${escapeHtml(bs.cardPaddingX ?? 16)}" min="0" max="64">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Form radius</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.formRadius" value="${escapeHtml(bs.formRadius ?? 6)}" min="0" max="64">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Nav padding Y</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.navPaddingY" value="${escapeHtml(bs.navPaddingY ?? 0.5)}" min="0" max="2" step="0.05">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Nav padding X</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.navPaddingX" value="${escapeHtml(bs.navPaddingX ?? 0.85)}" min="0" max="3" step="0.05">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Card shadow level</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.cardShadowLevel" value="${escapeHtml(bs.cardShadowLevel ?? 1)}" min="0" max="3" step="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Button shadow level</label>
                            <input type="number" class="form-control form-control-sm" data-theme-path="bootstrap.buttonShadowLevel" value="${escapeHtml(bs.buttonShadowLevel ?? 0)}" min="0" max="3" step="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Link color</label>
                            <input type="color" class="form-control form-control-color w-100" data-theme-path="bootstrap.linkColor" value="${escapeHtml(bs.linkColor ?? '#0d6efd')}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Link hover color</label>
                            <input type="color" class="form-control form-control-color w-100" data-theme-path="bootstrap.linkHoverColor" value="${escapeHtml(bs.linkHoverColor ?? '#0a58ca')}">
                        </div>
                    </div>
                </div>
            </div>
        `;

        themeEditor.querySelectorAll('[data-theme-path]').forEach((input) => {
            input.addEventListener('input', () => {
                const path = input.getAttribute('data-theme-path');
                if (!path) {
                    return;
                }

                const segments = path.split('.');
                let cursor = state.theme;
                for (let i = 0; i < segments.length - 1; i += 1) {
                    const segment = segments[i];
                    if (!cursor[segment] || typeof cursor[segment] !== 'object') {
                        cursor[segment] = {};
                    }
                    cursor = cursor[segment];
                }

                const finalKey = segments[segments.length - 1];
                const type = input.getAttribute('type');
                if (type === 'number') {
                    cursor[finalKey] = input.value === '' ? '' : Number(input.value);
                } else {
                    cursor[finalKey] = input.value;
                }

                applyThemePreview();
            });

            if (input.tagName === 'SELECT') {
                input.addEventListener('change', () => input.dispatchEvent(new Event('input', { bubbles: true })));
            }
        });

        themeEditor.querySelectorAll('[data-theme-palette]').forEach((input) => {
            input.addEventListener('input', () => {
                const scheme = input.getAttribute('data-theme-palette');
                const key = input.getAttribute('data-theme-color');
                if (!scheme || !key) {
                    return;
                }

                const paletteKey = scheme === 'dark' ? 'colorsDark' : 'colorsLight';
                if (!state.theme[paletteKey] || typeof state.theme[paletteKey] !== 'object') {
                    state.theme[paletteKey] = {};
                }
                state.theme[paletteKey][key] = input.value;
                applyThemePreview();
            });
        });
    };

    const hexToRgb = (hex) => {
        const normalized = String(hex || '').replace('#', '').trim();
        if (/^[0-9a-fA-F]{3}$/.test(normalized)) {
            const r = parseInt(normalized[0] + normalized[0], 16);
            const g = parseInt(normalized[1] + normalized[1], 16);
            const b = parseInt(normalized[2] + normalized[2], 16);
            return `${r}, ${g}, ${b}`;
        }
        if (/^[0-9a-fA-F]{6}$/.test(normalized)) {
            const r = parseInt(normalized.slice(0, 2), 16);
            const g = parseInt(normalized.slice(2, 4), 16);
            const b = parseInt(normalized.slice(4, 6), 16);
            return `${r}, ${g}, ${b}`;
        }
        return '13, 110, 253';
    };

    const buildCssVars = (palette) => {
        const variants = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'];
        const vars = [];
        variants.forEach((variant) => {
            const value = palette[variant];
            vars.push(`--bs-${variant}: ${value}`);
            vars.push(`--bs-${variant}-rgb: ${hexToRgb(value)}`);
        });
        vars.push(`--bs-body-bg: ${palette.body}`);
        vars.push(`--bs-body-color: ${palette.text}`);
        vars.push(`--bs-link-color: ${state.theme.bootstrap.linkColor}`);
        vars.push(`--bs-link-hover-color: ${state.theme.bootstrap.linkHoverColor}`);
        vars.push(`--bs-btn-radius: ${state.theme.bootstrap.buttonRadius}px`);
        vars.push(`--rb-card-padding-y: ${state.theme.bootstrap.cardPaddingY}px`);
        vars.push(`--rb-card-padding-x: ${state.theme.bootstrap.cardPaddingX}px`);
        vars.push(`--rb-btn-padding-y: ${state.theme.bootstrap.buttonPaddingY}px`);
        vars.push(`--rb-btn-padding-x: ${state.theme.bootstrap.buttonPaddingX}px`);
        vars.push(`--rb-btn-weight: ${state.theme.bootstrap.buttonWeight}`);
        vars.push(`--rb-form-radius: ${state.theme.bootstrap.formRadius}px`);
        vars.push(`--rb-nav-padding-y: ${state.theme.bootstrap.navPaddingY}rem`);
        vars.push(`--rb-nav-padding-x: ${state.theme.bootstrap.navPaddingX}rem`);
        return vars.join(';');
    };

    const applyThemePreview = () => {
        const theme = state.theme ?? defaultTheme();
        const lightVars = buildCssVars(theme.colorsLight ?? defaultTheme().colorsLight);
        const darkVars = buildCssVars(theme.colorsDark ?? defaultTheme().colorsDark);
        const css = `:root,[data-bs-theme="light"]{${lightVars}}[data-bs-theme="dark"]{${darkVars}}`;

        let style = document.getElementById('reborn-live-theme');
        if (!style) {
            style = document.createElement('style');
            style.id = 'reborn-live-theme';
            document.head.appendChild(style);
        }
        style.textContent = css;

        const mode = theme.mode === 'dark' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-bs-theme', mode);
        if (document.body) {
            document.body.setAttribute('data-bs-theme', mode);
            document.body.classList.remove('reborn-header-top', 'reborn-header-left');
            document.body.classList.add(`reborn-header-${theme.header.position === 'left' ? 'left' : 'top'}`);
            document.body.classList.remove('reborn-footer-position-default', 'reborn-footer-position-fixed');
            document.body.classList.add(`reborn-footer-position-${theme.footer?.position === 'fixed' ? 'fixed' : 'default'}`);
            document.body.style.setProperty('--reborn-header-width', `${clamp(theme.header.width, 220, 420, 280)}px`);
        }
    };

    const openAddModal = (section) => {
        const normalizedSection = ['global', 'sidebar', 'page'].includes(section) ? section : 'global';
        currentAddSection = normalizedSection;
        const modalTitle = document.getElementById('rebornAddBlockModalLabel');
        if (modalTitle) {
            modalTitle.textContent = `${t('add_block', 'Add block')} · ${sectionLabel(normalizedSection)}`;
        }
        const blocks = registry.list.filter((definition) => isBlockAllowedForSection(definition, normalizedSection));

        const grouped = {};
        blocks.forEach((definition) => {
            if (!grouped[definition.categoryId]) {
                grouped[definition.categoryId] = {
                    label: definition.categoryLabel || definition.categoryId,
                    items: [],
                };
            }
            grouped[definition.categoryId].items.push(definition);
        });

        const html = Object.values(grouped).map((group) => `
            <section class="mb-3">
                <h6 class="mb-2">${escapeHtml(group.label)}</h6>
                <div class="row g-2">
                    ${group.items.map((item) => `
                        <div class="col-md-6">
                            <article class="border rounded-3 p-3 h-100 d-flex flex-column">
                                <strong class="mb-1">${escapeHtml(item.label ?? item.type)}</strong>
                                <p class="small text-muted mb-3">${escapeHtml(item.description ?? '')}</p>
                                <button type="button" class="btn btn-primary btn-sm mt-auto" data-add-block-type="${escapeHtml(item.type)}">
                                    ${escapeHtml(t('add_block', 'Add block'))}
                                </button>
                            </article>
                        </div>
                    `).join('')}
                </div>
            </section>
        `).join('');

        modalBody.innerHTML = html || '<p class="text-muted mb-0">No available blocks.</p>';
        modalBody.querySelectorAll('[data-add-block-type]').forEach((button) => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-add-block-type');
                const definition = registry.flat[type];
                if (!definition) {
                    return;
                }

                const nextBlock = ensureBlockShape({
                    id: uid('block'),
                    type,
                    enabled: true,
                    settings: clone(definition.defaults ?? {}),
                }, definition.defaults ?? {});

                const blocksForSection = [...getSectionBlocks(currentAddSection), nextBlock];
                setSectionBlocks(currentAddSection, blocksForSection);
                selected = { section: currentAddSection, index: blocksForSection.length - 1 };
                addModal.hide();
                renderSections();
                renderBlockEditor();
            });
        });

        addModal.show();
    };

    const save = async () => {
        try {
            const payload = new FormData();
            payload.append('_token', boot.csrfToken);
            payload.append('composer', JSON.stringify(state));

            await axios.post(boot.routes.config, payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            alert(t('saved', 'Reborn configuration saved.'));
            window.location.reload();
        } catch (error) {
            console.error('Reborn save failed', error);
            alert(t('save_error', 'Unable to save the Reborn configuration.'));
        }
    };

    const openBuilderPanel = () => {
        ensurePageEntry(state, pageKey);
        renderSections();
        renderBlockEditor();
        renderThemeEditor();
        applyThemePreview();
        offcanvas.show();
    };

    openBtn.addEventListener('click', openBuilderPanel);

    saveBtn.addEventListener('click', save);

    offcanvasEl.addEventListener('shown.bs.offcanvas', () => {
        document.body?.classList.add('reborn-builder-active');
    });

    offcanvasEl.addEventListener('hidden.bs.offcanvas', () => {
        document.body?.classList.remove('reborn-builder-active');
    });

    document.querySelectorAll('[data-reborn-add]').forEach((button) => {
        button.addEventListener('click', () => {
            const section = button.getAttribute('data-reborn-add');
            if (!section) {
                return;
            }
            openAddModal(section);
        });
    });

    document.querySelectorAll('[data-reborn-quick-add]').forEach((button) => {
        button.addEventListener('click', () => {
            const section = button.getAttribute('data-reborn-quick-add');
            if (!section) {
                return;
            }

            const openModalForSection = () => openAddModal(section);
            if (offcanvasEl.classList.contains('show')) {
                openModalForSection();
                return;
            }

            offcanvasEl.addEventListener('shown.bs.offcanvas', openModalForSection, { once: true });
            openBuilderPanel();
        });
    });

    applyThemePreview();
})();
