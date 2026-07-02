window.ThemeEditorCore = class ThemeEditorCore {
    mount() {
    const parseJsonScript = (id) => {
        const node = document.getElementById(id);
        if (!node) {
            return null;
        }

        try {
            return JSON.parse(node.textContent || '{}');
        } catch (error) {
            console.error('[theme-editor] Invalid JSON in', id, error);
            return null;
        }
    };

    const runtimeDefaults = {
        root_id: 'theme-editor-root',
        panel_id: 'themeEditorPanel',
        script_ids: {
            runtime: 'theme-editor-runtime',
            initial: 'theme-editor-initial',
            defaults: 'theme-editor-defaults',
            catalog: 'theme-editor-catalog',
            images: 'theme-editor-images',
            lang: 'theme-editor-lang',
        },
        storage: {
            last_tab_key: 'theme_editor_last_tab',
        },
        runtime_ids: {
            live_style: 'theme-editor-live',
            font_link: 'theme-editor-font-link',
            announce_bar: 'theme-editor-announce-bar',
            scroll_progress: 'theme-editor-scroll-progress',
        },
        attrs: {
            container: 'data-te-block-container',
            block: 'data-te-block',
            template_block: 'data-te-template-block',
            param: 'data-te-param',
            param_href: 'data-te-param-href',
            param_image: 'data-te-param-image',
            param_list: 'data-te-param-list',
            param_class: 'data-te-param-class',
            node: 'data-te-node',
            empty_image: 'data-te-empty-image',
            footer_logo: 'data-te-footer-logo',
            footer_social: 'data-te-footer-social',
        },
    };

    const runtimeRaw = parseJsonScript(runtimeDefaults.script_ids.runtime);
    const runtime = {
        ...runtimeDefaults,
        ...(runtimeRaw && typeof runtimeRaw === 'object' ? runtimeRaw : {}),
        script_ids: {
            ...runtimeDefaults.script_ids,
            ...(runtimeRaw && typeof runtimeRaw === 'object' && runtimeRaw.script_ids && typeof runtimeRaw.script_ids === 'object'
                ? runtimeRaw.script_ids
                : {}),
        },
        storage: {
            ...runtimeDefaults.storage,
            ...(runtimeRaw && typeof runtimeRaw === 'object' && runtimeRaw.storage && typeof runtimeRaw.storage === 'object'
                ? runtimeRaw.storage
                : {}),
        },
        runtime_ids: {
            ...runtimeDefaults.runtime_ids,
            ...(runtimeRaw && typeof runtimeRaw === 'object' && runtimeRaw.runtime_ids && typeof runtimeRaw.runtime_ids === 'object'
                ? runtimeRaw.runtime_ids
                : {}),
        },
        attrs: {
            ...runtimeDefaults.attrs,
            ...(runtimeRaw && typeof runtimeRaw === 'object' && runtimeRaw.attrs && typeof runtimeRaw.attrs === 'object'
                ? runtimeRaw.attrs
                : {}),
        },
    };

    const root = document.getElementById(runtime.root_id)
        || document.querySelector('[data-theme-editor-root]');
    if (!root) {
        return;
    }

    const readAttr = (map, key) => {
        const candidate = map && typeof map[key] === 'string' ? map[key].trim() : '';
        return candidate || '';
    };

    const attr = (key) => readAttr(runtime.attrs, key);

    const attrSelector = (attrName) => (attrName ? `[${attrName}]` : '');

    const selectorForAttr = (key) => {
        return attrSelector(attr(key));
    };

    const selectorForAttrValue = (key, value) => {
        const safeValue = String(value).replace(/"/g, '\\"');
        const primary = attr(key);
        return primary ? `[${primary}="${safeValue}"]` : '';
    };

    const queryAllAttr = (scope, key) => {
        const selector = selectorForAttr(key);
        if (!selector) {
            return [];
        }
        return Array.from(scope.querySelectorAll(selector));
    };

    const queryAttrValue = (scope, key, value) => {
        const selector = selectorForAttrValue(key, value);
        return selector ? scope.querySelector(selector) : null;
    };

    const readAttrValue = (element, key) => {
        const primary = attr(key);

        if (primary && element.hasAttribute(primary)) {
            return element.getAttribute(primary);
        }
        return null;
    };

    const setAttrValue = (element, key, value) => {
        const primary = attr(key);
        if (primary) {
            element.setAttribute(primary, value);
        }
    };

    const deepClone = (value) => JSON.parse(JSON.stringify(value));

    const getByPath = (obj, path) => path.split('.').reduce((acc, key) => (acc == null ? undefined : acc[key]), obj);

    const setByPath = (obj, path, value) => {
        const keys = path.split('.');
        let target = obj;

        for (let i = 0; i < keys.length - 1; i++) {
            const key = keys[i];
            if (typeof target[key] !== 'object' || target[key] === null) {
                target[key] = {};
            }
            target = target[key];
        }

        target[keys[keys.length - 1]] = value;
    };

    const normalizeHex = (value, fallback = '#ffffff') => {
        if (typeof value !== 'string') {
            return fallback;
        }

        const cleaned = value.trim();
        if (/^#[0-9a-f]{6}$/i.test(cleaned)) {
            return cleaned;
        }

        return fallback;
    };

    const toRgb = (hex) => {
        const normalized = normalizeHex(hex, '#000000').slice(1);
        const r = parseInt(normalized.slice(0, 2), 16);
        const g = parseInt(normalized.slice(2, 4), 16);
        const b = parseInt(normalized.slice(4, 6), 16);
        return `${r}, ${g}, ${b}`;
    };

    const contrastColor = (hex) => {
        const normalized = normalizeHex(hex, '#000000').slice(1);
        const r = parseInt(normalized.slice(0, 2), 16);
        const g = parseInt(normalized.slice(2, 4), 16);
        const b = parseInt(normalized.slice(4, 6), 16);
        const yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;

        return yiq >= 128 ? '#000000' : '#ffffff';
    };

    const normalizeBlockId = (id) => {
        if (typeof id !== 'string') {
            return null;
        }

        const trimmed = id.trim();
        if (!trimmed) {
            return null;
        }

        return trimmed;
    };

    const normalizeBlocksList = (blocks) => {
        if (!Array.isArray(blocks)) {
            return [];
        }

        return blocks
            .filter((block) => block && typeof block === 'object' && normalizeBlockId(block.id))
            .map((block, index) => ({
                id: normalizeBlockId(block.id),
                order: Number.isFinite(Number(block.order)) ? Number(block.order) : index + 1,
                params: block.params && typeof block.params === 'object' ? block.params : {},
            }));
    };

    const normalizeBlocksMap = (blocks, currentRouteKey) => {
        if (Array.isArray(blocks)) {
            return {
                [currentRouteKey]: normalizeBlocksList(blocks),
            };
        }

        if (!blocks || typeof blocks !== 'object') {
            return {
                [currentRouteKey]: [],
            };
        }

        const normalized = {};
        Object.entries(blocks).forEach(([routeKey, routeBlocks]) => {
            normalized[routeKey] = normalizeBlocksList(routeBlocks);
        });

        if (!Object.prototype.hasOwnProperty.call(normalized, currentRouteKey)) {
            normalized[currentRouteKey] = [];
        }

        return normalized;
    };

    const normalizeVariableKey = (value) => String(value || '')
        .trim()
        .replace(/[{}]/g, '')
        .replace(/[^A-Za-z0-9_]/g, '_')
        .replace(/^_+|_+$/g, '');

    const normalizeSystemVariables = (variables) => {
        if (!Array.isArray(variables)) {
            return [];
        }

        const seen = new Set();
        return variables
            .filter((item) => item && typeof item === 'object')
            .map((item) => {
                const key = normalizeVariableKey(item.key);
                if (!key || seen.has(key)) {
                    return null;
                }
                seen.add(key);

                return {
                    key,
                    label: String(item.label || key),
                    value: item.value == null ? '' : String(item.value),
                    locked: true,
                };
            })
            .filter(Boolean);
    };

    const normalizeCustomVariables = (variables) => {
        if (!Array.isArray(variables)) {
            return [];
        }

        const seen = new Set();
        return variables
            .filter((item) => item && typeof item === 'object')
            .map((item) => {
                const key = normalizeVariableKey(item.key);
                if (!key || seen.has(key)) {
                    return null;
                }
                seen.add(key);

                return {
                    key,
                    value: item.value == null ? '' : String(item.value),
                };
            })
            .filter(Boolean);
    };

    const normalizeState = (raw) => {
        const draft = raw && typeof raw === 'object' ? deepClone(raw) : {};

        draft.styles = draft.styles || {};
        draft.styles.colors = draft.styles.colors || {};
        draft.styles.colors.light = draft.styles.colors.light || {};
        draft.styles.colors.dark = draft.styles.colors.dark || {};
        draft.global = draft.global || {};
        draft.advanced = draft.advanced || {};
        draft.modules = draft.modules || {};
        draft.modules.announce_bar = draft.modules.announce_bar || {};
        draft.modules.scroll_progress = draft.modules.scroll_progress || {};
        draft.variables = draft.variables || {};
        draft.variables.system = normalizeSystemVariables(draft.variables.system);
        draft.variables.custom = normalizeCustomVariables(draft.variables.custom);
        draft.page = draft.page || {};
        draft.page.current_route_key = typeof draft.page.current_route_key === 'string' && draft.page.current_route_key.length > 0
            ? draft.page.current_route_key
            : 'path:/';
        draft.page.current_route_label = typeof draft.page.current_route_label === 'string' && draft.page.current_route_label.length > 0
            ? draft.page.current_route_label
            : draft.page.current_route_key;
        draft.page.current_route_signature = typeof draft.page.current_route_signature === 'string' && draft.page.current_route_signature.length > 0
            ? draft.page.current_route_signature
            : draft.page.current_route_key;
        draft.page.blocks = normalizeBlocksMap(draft.page.blocks, draft.page.current_route_key);

        return draft;
    };

    const initialState = normalizeState(parseJsonScript(runtime.script_ids.initial));
    const defaultState = normalizeState(parseJsonScript(runtime.script_ids.defaults) || initialState);
    const blockCatalog = parseJsonScript(runtime.script_ids.catalog) || [];
    const imageLibrary = parseJsonScript(runtime.script_ids.images) || [];
    const imageUrlByFile = new Map(
        imageLibrary
            .filter((image) => image && typeof image.file === 'string')
            .map((image) => [String(image.file), String(image.url || image.file)])
    );

    let state = deepClone(initialState);
    let savedState = deepClone(initialState);
    let isDirty = false;
    let currentTab = 'styles';
    let saveInProgress = false;

    const ui = {
        toggle: document.getElementById('themeEditorToggle'),
        close: document.getElementById('themeEditorClose'),
        panel: document.getElementById(runtime.panel_id),
        backdrop: document.getElementById('themeEditorBackdrop'),
        stateBadge: document.getElementById('teStateBadge'),
        statusText: document.getElementById('teStatusText'),
        tabButtons: Array.from(root.querySelectorAll('[data-te-tab-target]')),
        tabPanels: Array.from(root.querySelectorAll('[data-te-tab]')),
        segmentButtons: Array.from(root.querySelectorAll('[data-te-segment-target]')),
        segmentPanels: Array.from(root.querySelectorAll('[data-te-segment]')),
        inputs: Array.from(root.querySelectorAll('[data-key]')),
        save: document.getElementById('teSave'),
        cancel: document.getElementById('teCancel'),
        saveLabel: root.querySelector('.te-save-label'),
        saveLoading: root.querySelector('.te-save-loading'),
        form: document.getElementById('themeEditorConfigForm'),
        hiddenInputs: Array.from(document.querySelectorAll('#themeEditorConfigForm [data-config-key]')),
        pageBlockFields: document.getElementById('themeEditorPageBlocksFields'),
        variablesFields: document.getElementById('themeEditorVariablesFields'),
        catalogContainer: document.getElementById('teBlockCatalog'),
        catalogModal: document.getElementById('teCatalogModal'),
        openCatalogModal: document.getElementById('teOpenCatalogModal'),
        resetAllButton: document.getElementById('teResetAll'),
        systemVariablesList: document.getElementById('teSystemVariablesList'),
        customVariablesList: document.getElementById('teCustomVariablesList'),
        addCustomVariable: document.getElementById('teAddCustomVariable'),
        systemVariableTemplate: document.getElementById('teSystemVariableTemplate'),
        customVariableTemplate: document.getElementById('teCustomVariableTemplate'),
        activeBlocksContainer: document.getElementById('teActiveBlocks'),
        activeBlockTemplate: document.getElementById('teActiveBlockTemplate'),
        modal: document.getElementById('teBlockModal'),
        modalBody: document.getElementById('teBlockModalBody'),
        modalSave: document.getElementById('teBlockModalSave'),
        modalTitle: document.getElementById('teBlockModalTitle'),
        blockForms: document.getElementById('themeEditorBlockForms'),
        currentRouteLabel: document.getElementById('teCurrentRouteLabel'),
        currentRouteKey: document.getElementById('teCurrentRouteKey'),
        pageUndo: document.getElementById('tePageUndo'),
        pageRedo: document.getElementById('tePageRedo'),
        presetJson: document.getElementById('tePresetJson'),
        presetExport: document.getElementById('tePresetExport'),
        presetCopy: document.getElementById('tePresetCopy'),
        presetDownload: document.getElementById('tePresetDownload'),
        presetImport: document.getElementById('tePresetImport'),
        presetFile: document.getElementById('tePresetFile'),
        openAdvancedButtons: Array.from(root.querySelectorAll('[data-te-open-advanced]')),
        presetButtons: Array.from(root.querySelectorAll('[data-te-color-preset]')),
    };

    if (!ui.panel || !ui.form) {
        return;
    }

    if (ui.catalogModal && ui.catalogModal.parentElement !== root) {
        root.appendChild(ui.catalogModal);
    }

    const langCatalog = parseJsonScript(runtime.script_ids.lang) || {};
    const i18n = typeof window.ThemeEditorI18n === 'function'
        ? new window.ThemeEditorI18n(langCatalog)
        : null;
    const t = (key, fallback, params = {}) => (i18n ? i18n.t(key, fallback, params) : String(fallback));

    const colorPresets = (window.ThemeEditorPresets && typeof window.ThemeEditorPresets.all === 'function')
        ? window.ThemeEditorPresets.all()
        : {};

    const setPhase = (phase, message = null) => {
        const labels = {
            idle: t('state.idle', 'Idle'),
            open: t('state.open', 'Open'),
            dirty: t('state.dirty', 'Dirty'),
            saving: t('state.saving', 'Saving'),
            saved: t('state.saved', 'Saved'),
            error: t('state.error', 'Error'),
        };

        ui.stateBadge.textContent = labels[phase] || phase;
        ui.stateBadge.classList.toggle('te-state-badge-error', phase === 'error');
        ui.statusText.classList.toggle('te-status-error', phase === 'error');

        if (message !== null) {
            ui.statusText.textContent = message;
        }
    };

    const setDirty = (value = true) => {
        isDirty = value;

        if (saveInProgress) {
            return;
        }

        if (value) {
            setPhase('dirty', t('status.unsaved_changes', 'Modifications non sauvegardées'));
        } else {
            setPhase('open', t('status.up_to_date', 'À jour'));
        }
    };

    const toggleSaveLoading = (saving) => {
        saveInProgress = saving;
        ui.save.disabled = saving;
        ui.cancel.disabled = saving;
        ui.saveLabel.hidden = saving;
        ui.saveLoading.hidden = !saving;
    };

    const isPanelOpen = () => ui.panel.classList.contains('is-open');

    const getCurrentRouteKey = () => state.page.current_route_key || 'path:/';
    const getCurrentRouteLabel = () => state.page.current_route_label || getCurrentRouteKey();
    const getCurrentRouteSignature = () => state.page.current_route_signature || getCurrentRouteKey();
    const lastTabStorageKey = runtime.storage.last_tab_key || 'theme_editor_last_tab';

    const findBlockContainer = () => {
        const candidates = queryAllAttr(document, 'container');
        if (candidates.length > 0) {
            return candidates[0];
        }

        return null;
    };

    const getRouteBlocks = (routeKey = getCurrentRouteKey()) => {
        if (!state.page.blocks || typeof state.page.blocks !== 'object') {
            state.page.blocks = {};
        }

        if (!Array.isArray(state.page.blocks[routeKey])) {
            state.page.blocks[routeKey] = [];
        }

        return state.page.blocks[routeKey];
    };

    const normalizeCurrentRouteBlocks = () => {
        const routeKey = getCurrentRouteKey();
        state.page.blocks[routeKey] = normalizeBlocksList(getRouteBlocks(routeKey));
    };

    const sortBlocksList = (blocks) => {
        blocks.sort((a, b) => (Number(a.order) || 0) - (Number(b.order) || 0));
        blocks.forEach((block, index) => {
            block.order = index + 1;
        });
    };

    const reindexBlocksList = (blocks) => {
        blocks.forEach((block, index) => {
            block.order = index + 1;
        });
    };

    const sortCurrentRouteBlocks = () => {
        normalizeCurrentRouteBlocks();
        sortBlocksList(getRouteBlocks());
        enforceRouteBlockConstraints(getCurrentRouteKey());
    };

    const sortAllRouteBlocks = () => {
        if (!state.page.blocks || typeof state.page.blocks !== 'object') {
            state.page.blocks = {};
        }

        Object.keys(state.page.blocks).forEach((routeKey) => {
            state.page.blocks[routeKey] = normalizeBlocksList(state.page.blocks[routeKey]);
            sortBlocksList(state.page.blocks[routeKey]);
            enforceRouteBlockConstraints(routeKey);
        });
    };

    const nextBlockOrder = () => {
        const blocks = getRouteBlocks();
        if (!blocks.length) {
            return 1;
        }

        return Math.max(...blocks.map((block) => Number(block.order) || 0)) + 1;
    };

    const renderRouteContext = () => {
        if (ui.currentRouteLabel) {
            ui.currentRouteLabel.textContent = getCurrentRouteLabel();
        }
        if (ui.currentRouteKey) {
            ui.currentRouteKey.textContent = getCurrentRouteSignature();
        }
    };

    const openPanel = () => {
        ui.panel.classList.add('is-open');
        ui.panel.setAttribute('aria-hidden', 'false');
        if (ui.backdrop) {
            ui.backdrop.hidden = false;
        }
        ui.toggle.setAttribute('aria-expanded', 'true');
        ui.toggle.hidden = true;

        const preferredTab = localStorage.getItem(lastTabStorageKey);
        if (preferredTab && ui.tabButtons.some((button) => button.dataset.teTabTarget === preferredTab)) {
            switchTab(preferredTab);
        }

        if (!isDirty) {
            setPhase('open', t('status.editor_opened', 'Éditeur ouvert'));
        }
    };

    const closePanel = () => {
        ui.panel.classList.remove('is-open');
        ui.panel.setAttribute('aria-hidden', 'true');
        if (ui.backdrop) {
            ui.backdrop.hidden = true;
        }
        ui.toggle.setAttribute('aria-expanded', 'false');
        ui.toggle.hidden = false;
        closeCatalogModal();

        if (!isDirty) {
            setPhase('idle', t('status.ready', 'Prêt'));
        }
    };

    const switchTab = (tab) => {
        currentTab = tab;

        ui.tabButtons.forEach((button) => {
            const active = button.dataset.teTabTarget === tab;
            button.classList.toggle('te-tab-active', active);
        });

        ui.tabPanels.forEach((panel) => {
            const active = panel.dataset.teTab === tab;
            panel.hidden = !active;
            panel.classList.toggle('te-tab-panel-active', active);
        });

        localStorage.setItem(lastTabStorageKey, tab);
    };

    const switchSegment = (segment) => {
        ui.segmentButtons.forEach((button) => {
            button.classList.toggle('te-segment-active', button.dataset.teSegmentTarget === segment);
        });

        ui.segmentPanels.forEach((panel) => {
            panel.hidden = panel.dataset.teSegment !== segment;
        });
    };

    let parseInputValue;
    let toBoolean;
    let getCustomVariablesEditable;
    let getCustomVariablesForTemplate;
    let resolveTemplateVariables;
    let refreshSystemVariablesUiValues;
    let renderVariablesEditor;
    let applyStateToInputs;
    let readInputsToState;
    let updateVisibility;
    let applyColorPreset;
    let isAdvancedModeActive;
    let getCatalogItem;
    let enforceRouteBlockConstraints;
    let fallbackBlockIdsForRoute;
    let seedCurrentRouteBlocks;
    let renderActiveBlocks;
    let openCatalogModal;
    let closeCatalogModal;
    let closeBlockModal;
    let saveBlockModal;
    let refreshImagePreviews;
    let updateImagePreviewForSelect;
    let updateBlockDomPreview;
    let applyLivePreview = () => {};

    if (typeof window.ThemeEditorCoreVariables !== 'function') {
        console.error('[theme-editor] ThemeEditorCoreVariables is not loaded.');
        return;
    }

    if (typeof window.ThemeEditorCoreLayout !== 'function') {
        console.error('[theme-editor] ThemeEditorCoreLayout is not loaded.');
        return;
    }

    const variablesModule = window.ThemeEditorCoreVariables({
        state,
        root,
        ui,
        getByPath,
        setByPath,
        normalizeVariableKey,
        normalizeSystemVariables,
        normalizeCustomVariables,
        colorPresets,
        t,
        refreshImagePreviews: () => refreshImagePreviews(),
        applyLivePreview: (...args) => applyLivePreview(...args),
    });

    ({
        parseInputValue,
        toBoolean,
        getCustomVariablesEditable,
        getCustomVariablesForTemplate,
        resolveTemplateVariables,
        refreshSystemVariablesUiValues,
        renderVariablesEditor,
        applyStateToInputs,
        readInputsToState,
        updateVisibility,
        applyColorPreset,
        isAdvancedModeActive,
    } = variablesModule);

    const layoutModule = window.ThemeEditorCoreLayout({
        runtime,
        root,
        state,
        defaultState,
        blockCatalog,
        imageUrlByFile,
        ui,
        t,
        attr,
        selectorForAttr,
        selectorForAttrValue,
        queryAllAttr,
        queryAttrValue,
        readAttrValue,
        setAttrValue,
        deepClone,
        normalizeHex,
        toRgb,
        contrastColor,
        normalizeBlockId,
        normalizeBlocksList,
        findBlockContainer,
        getCurrentRouteKey,
        getCurrentRouteLabel,
        getRouteBlocks,
        reindexBlocksList,
        nextBlockOrder,
        toBoolean,
        isAdvancedModeActive,
        resolveTemplateVariables,
        setDirty,
        setPhase,
        isPanelOpen,
        onPageHistoryMutated: () => recordPageHistory(),
        onRouteBlocksMutated: () => sortCurrentRouteBlocks(),
        onSystemVariablesRefresh: () => refreshSystemVariablesUiValues(),
    });

    ({
        getCatalogItem,
        enforceRouteBlockConstraints,
        fallbackBlockIdsForRoute,
        seedCurrentRouteBlocks,
        renderActiveBlocks,
        openCatalogModal,
        closeCatalogModal,
        closeBlockModal,
        saveBlockModal,
        refreshImagePreviews,
        updateImagePreviewForSelect,
        updateBlockDomPreview,
        applyLivePreview,
    } = layoutModule);

    const valueForHiddenField = (value) => {
        if (typeof value === 'boolean') {
            return value ? '1' : '0';
        }
        if (value == null) {
            return '';
        }
        return String(value);
    };

    const appendNestedFields = (container, prefix, value) => {
        if (Array.isArray(value)) {
            value.forEach((item, index) => appendNestedFields(container, `${prefix}[${index}]`, item));
            return;
        }

        if (value && typeof value === 'object') {
            Object.entries(value).forEach(([key, item]) => appendNestedFields(container, `${prefix}[${key}]`, item));
            return;
        }

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = prefix;
        input.value = valueForHiddenField(value);
        container.appendChild(input);
    };

    const syncHiddenFormWithState = () => {
        ui.hiddenInputs.forEach((input) => {
            const key = input.dataset.configKey;
            const value = getByPath(state, key);
            input.value = valueForHiddenField(value);
        });

        ui.pageBlockFields.innerHTML = '';
        appendNestedFields(ui.pageBlockFields, 'page[blocks]', state.page.blocks || {});

        if (ui.variablesFields) {
            ui.variablesFields.innerHTML = '';
            appendNestedFields(ui.variablesFields, 'variables[custom]', getCustomVariablesForTemplate());
        }
    };

    const saveConfig = async () => {
        if (saveInProgress) {
            return;
        }

        readInputsToState();
        sortAllRouteBlocks();
        syncHiddenFormWithState();

        setPhase('saving', t('status.saving_in_progress', 'Sauvegarde en cours...'));
        toggleSaveLoading(true);

        const formData = new FormData(ui.form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token');

        try {
            const response = await fetch(ui.form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken || '',
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'application/json',
                },
                body: formData,
            });

            if (!response.ok) {
                let errorText = `Erreur HTTP ${response.status}`;

                try {
                    const payload = await response.json();
                    if (payload?.message) {
                        errorText = payload.message;
                    }
                    if (payload?.errors && typeof payload.errors === 'object') {
                        const firstError = Object.values(payload.errors)[0];
                        if (Array.isArray(firstError) && firstError[0]) {
                            errorText = firstError[0];
                        }
                    }
                } catch (error) {
                    // Ignore JSON parsing issues for non-JSON responses.
                }

                throw new Error(errorText);
            }

            savedState = deepClone(state);
            renderPresetJson();
            setDirty(false);
            setPhase('saved', t('messages.config_saved_for_route', 'Configuration sauvegardée ({route})', {
                route: getCurrentRouteLabel(),
            }));

            window.setTimeout(() => {
                if (isPanelOpen() && !isDirty) {
                    setPhase('open', t('status.up_to_date', 'À jour'));
                } else if (!isPanelOpen() && !isDirty) {
                    setPhase('idle', t('status.ready', 'Prêt'));
                }
            }, 2000);
        } catch (error) {
            setPhase('error', error.message || t('status.save_failed', 'Échec de la sauvegarde'));
        } finally {
            toggleSaveLoading(false);
        }
    };

    let pageHistory = [];
    let pageHistoryIndex = -1;
    let restoringPageHistory = false;

    const getCurrentPageHistorySnapshot = () => deepClone(normalizeBlocksList(getRouteBlocks(getCurrentRouteKey())));

    const syncPageHistoryControls = () => {
        if (ui.pageUndo) {
            ui.pageUndo.disabled = pageHistoryIndex <= 0;
        }
        if (ui.pageRedo) {
            ui.pageRedo.disabled = pageHistoryIndex < 0 || pageHistoryIndex >= pageHistory.length - 1;
        }
    };

    const resetPageHistory = () => {
        pageHistory = [];
        pageHistoryIndex = -1;
        recordPageHistory();
    };

    const recordPageHistory = () => {
        if (restoringPageHistory) {
            return;
        }

        const snapshot = getCurrentPageHistorySnapshot();
        const signature = JSON.stringify(snapshot);
        const currentEntry = pageHistory[pageHistoryIndex] || null;
        if (currentEntry && currentEntry.signature === signature) {
            syncPageHistoryControls();
            return;
        }

        pageHistory = pageHistory.slice(0, pageHistoryIndex + 1);
        pageHistory.push({
            signature,
            snapshot,
        });

        if (pageHistory.length > 40) {
            pageHistory.shift();
        }

        pageHistoryIndex = pageHistory.length - 1;
        syncPageHistoryControls();
    };

    const restorePageHistory = (direction) => {
        const targetIndex = pageHistoryIndex + direction;
        if (targetIndex < 0 || targetIndex >= pageHistory.length) {
            return;
        }

        const entry = pageHistory[targetIndex];
        if (!entry) {
            return;
        }

        restoringPageHistory = true;
        try {
            const routeKey = getCurrentRouteKey();
            state.page.blocks[routeKey] = deepClone(entry.snapshot);
            enforceRouteBlockConstraints(routeKey);
            renderActiveBlocks();
            renderPresetJson();
            applyLivePreview({
                markDirty: false,
                message: t('status.preview_applied', 'Prévisualisation appliquée'),
            });

            const isSaved = JSON.stringify(normalizeState(state)) === JSON.stringify(normalizeState(savedState));
            setDirty(!isSaved);
            setPhase(
                isSaved ? (isPanelOpen() ? 'open' : 'idle') : 'dirty',
                isSaved ? t('status.up_to_date', 'À jour') : t('status.unsaved_changes', 'Modifications non sauvegardées'),
            );

            pageHistoryIndex = targetIndex;
            syncPageHistoryControls();
        } finally {
            restoringPageHistory = false;
        }
    };

    const buildPresetPayload = () => ({
        version: 1,
        generated_at: new Date().toISOString(),
        route: {
            key: getCurrentRouteKey(),
            label: getCurrentRouteLabel(),
        },
        state: {
            styles: deepClone(state.styles || {}),
            global: deepClone(state.global || {}),
            advanced: deepClone(state.advanced || {}),
            modules: deepClone(state.modules || {}),
            variables: {
                custom: deepClone(getCustomVariablesForTemplate()),
            },
            page: {
                blocks: deepClone(state.page?.blocks || {}),
            },
        },
    });

    const renderPresetJson = () => {
        if (!ui.presetJson) {
            return '';
        }

        const payload = buildPresetPayload();
        const json = JSON.stringify(payload, null, 2);
        ui.presetJson.value = json;
        return json;
    };

    const downloadPresetJson = (json) => {
        const payload = typeof json === 'string' && json.trim() !== ''
            ? json
            : renderPresetJson();
        const filename = `theme-editor-preset-${getCurrentRouteKey().replace(/[^a-z0-9_-]/gi, '_') || 'route'}.json`;
        const blob = new Blob([payload], { type: 'application/json;charset=utf-8' });
        const url = window.URL.createObjectURL(blob);
        const anchor = document.createElement('a');

        anchor.href = url;
        anchor.download = filename;
        anchor.rel = 'noopener';
        document.body.appendChild(anchor);
        anchor.click();
        anchor.remove();
        window.URL.revokeObjectURL(url);
    };

    const copyPresetJson = async (json) => {
        const payload = typeof json === 'string' && json.trim() !== ''
            ? json
            : renderPresetJson();

        try {
            if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
                await navigator.clipboard.writeText(payload);
                return true;
            }
        } catch (error) {
            // Fallback below.
        }

        if (!ui.presetJson) {
            return false;
        }

        ui.presetJson.focus();
        ui.presetJson.select();

        try {
            return document.execCommand('copy');
        } catch (error) {
            return false;
        }
    };

    const normalizePresetImportState = (sourceState) => {
        const merged = deepClone(state);

        ['styles', 'global', 'advanced', 'modules'].forEach((section) => {
            if (sourceState && typeof sourceState === 'object' && sourceState[section] && typeof sourceState[section] === 'object') {
                merged[section] = sourceState[section];
            }
        });

        if (sourceState && typeof sourceState === 'object') {
            const customVariables = sourceState.variables && typeof sourceState.variables === 'object' && Array.isArray(sourceState.variables.custom)
                ? sourceState.variables.custom
                : null;

            if (customVariables) {
                merged.variables = merged.variables || {};
                merged.variables.custom = customVariables;
            }

            if (sourceState.page && typeof sourceState.page === 'object' && Object.prototype.hasOwnProperty.call(sourceState.page, 'blocks')) {
                merged.page = merged.page || {};
                merged.page.blocks = sourceState.page.blocks;
            } else if (Object.prototype.hasOwnProperty.call(sourceState, 'page_blocks')) {
                merged.page = merged.page || {};
                merged.page.blocks = sourceState.page_blocks;
            } else if (Object.prototype.hasOwnProperty.call(sourceState, 'blocks')) {
                merged.page = merged.page || {};
                merged.page.blocks = sourceState.blocks;
            }
        }

        const normalized = normalizeState(merged);
        normalized.page.current_route_key = state.page.current_route_key;
        normalized.page.current_route_label = state.page.current_route_label;
        normalized.page.current_route_signature = state.page.current_route_signature;
        normalized.page.blocks = normalizeBlocksMap(normalized.page.blocks, normalized.page.current_route_key);

        return normalized;
    };

    const importPresetJson = (json) => {
        const raw = String(json || '').trim();
        if (!raw) {
            throw new Error(t('messages.preset_import_failed', 'Le fichier JSON est invalide'));
        }

        let payload;
        try {
            payload = JSON.parse(raw);
        } catch (error) {
            throw new Error(t('messages.preset_import_failed', 'Le fichier JSON est invalide'));
        }

        const sourceState = payload && typeof payload === 'object' && payload.state && typeof payload.state === 'object'
            ? payload.state
            : payload;
        if (!sourceState || typeof sourceState !== 'object' || Array.isArray(sourceState)) {
            throw new Error(t('messages.preset_import_failed', 'Le fichier JSON est invalide'));
        }

        const normalized = normalizePresetImportState(sourceState);
        Object.keys(state).forEach((key) => {
            delete state[key];
        });
        Object.assign(state, normalized);

        applyStateToInputs(state);
        renderVariablesEditor();
        refreshImagePreviews();
        renderRouteContext();
        sortCurrentRouteBlocks();
        renderActiveBlocks();
        updateVisibility();
        renderPresetJson();
        applyLivePreview({
            markDirty: true,
            message: t('messages.preset_imported', 'Preset JSON importé'),
        });
        setDirty(true);
    };

    const getPresetJsonFromUi = () => {
        if (!ui.presetJson) {
            return renderPresetJson();
        }

        const current = String(ui.presetJson.value || '').trim();
        return current.length > 0 ? current : renderPresetJson();
    };

    const cancelChanges = () => {
        const restored = normalizeState(savedState);
        Object.keys(state).forEach((key) => {
            delete state[key];
        });
        Object.assign(state, restored);
        applyStateToInputs(state);
        renderRouteContext();
        sortCurrentRouteBlocks();
        renderActiveBlocks();
        updateVisibility();
        resetPageHistory();
        renderPresetJson();
        applyLivePreview({ markDirty: false, message: t('status.last_config_restored', 'Dernière configuration restaurée') });
        setDirty(false);
    };

    const buildDefaultBlocksForRoute = (routeKey = getCurrentRouteKey()) => {
        const defaultBlocks = normalizeBlocksList(defaultState.page?.blocks?.[routeKey] || []);
        if (defaultBlocks.length > 0) {
            return defaultBlocks.map((block, index) => ({
                id: block.id,
                order: index + 1,
                params: deepClone(block.params && typeof block.params === 'object' ? block.params : {}),
            }));
        }

        return fallbackBlockIdsForRoute(routeKey)
            .filter((id) => Boolean(getCatalogItem(id)))
            .map((id, index) => ({
                id,
                order: index + 1,
                params: deepClone(getCatalogItem(id)?.default_params || {}),
            }));
    };

    const resetCurrentPageBlocks = () => {
        const confirmed = window.confirm(t('confirm.reset_page_blocks', 'Réinitialiser les blocs de cette page (sans toucher au style global) ?'));
        if (!confirmed) {
            return;
        }

        const routeKey = getCurrentRouteKey();
        const defaultsForRoute = buildDefaultBlocksForRoute(routeKey);
        state.page.blocks[routeKey] = defaultsForRoute;
        enforceRouteBlockConstraints(routeKey);
        renderActiveBlocks();
        renderPresetJson();
        applyLivePreview({
            markDirty: true,
            message: 'Blocs de la page réinitialisés (non sauvegardé)',
        });
    };

    ui.toggle.addEventListener('click', () => {
        if (isPanelOpen()) {
            closePanel();
        } else {
            openPanel();
        }
    });

    ui.close.addEventListener('click', closePanel);
    if (ui.backdrop) {
        ui.backdrop.addEventListener('click', closePanel);
    }
    if (ui.openCatalogModal) {
        ui.openCatalogModal.addEventListener('click', openCatalogModal);
    }
    if (ui.resetAllButton) {
        ui.resetAllButton.addEventListener('click', resetCurrentPageBlocks);
    }

    ui.tabButtons.forEach((button) => {
        button.addEventListener('click', () => switchTab(button.dataset.teTabTarget));
    });

    ui.segmentButtons.forEach((button) => {
        button.addEventListener('click', () => switchSegment(button.dataset.teSegmentTarget));
    });

    ui.openAdvancedButtons.forEach((button) => {
        button.addEventListener('click', () => {
            switchTab('advanced');
        });
    });

    ui.presetButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const presetKey = String(button.dataset.teColorPreset || '').trim();
            applyColorPreset(presetKey);
        });
    });

    if (ui.presetExport) {
        ui.presetExport.addEventListener('click', () => {
            const json = renderPresetJson();
            setPhase('open', t('messages.preset_exported', 'Preset JSON généré'));
            ui.presetJson?.focus();
            ui.presetJson?.select();
            return json;
        });
    }

    if (ui.presetCopy) {
        ui.presetCopy.addEventListener('click', async () => {
            const json = getPresetJsonFromUi();
            const copied = await copyPresetJson(json);

            if (copied) {
                setPhase('open', t('messages.preset_copied', 'Preset JSON copié'));
                return;
            }

            setPhase('error', t('messages.preset_copy_failed', 'Impossible de copier le preset JSON'));
        });
    }

    if (ui.presetDownload) {
        ui.presetDownload.addEventListener('click', () => {
            const json = getPresetJsonFromUi();
            downloadPresetJson(json);
            setPhase('open', t('messages.preset_downloaded', 'Preset JSON téléchargé'));
        });
    }

        if (ui.presetImport) {
        ui.presetImport.addEventListener('click', () => {
            const json = getPresetJsonFromUi();
            const confirmed = window.confirm(t('confirm.import_preset', 'Importer ce preset JSON va remplacer les valeurs actuelles du thème pour les sections incluses. Continuer ?'));
            if (!confirmed) {
                return;
            }

            try {
                importPresetJson(json);
            } catch (error) {
                setPhase('error', error.message || t('messages.preset_import_failed', 'Le fichier JSON est invalide'));
            }
        });
    }

    if (ui.presetFile) {
        ui.presetFile.addEventListener('change', async () => {
            const file = ui.presetFile.files && ui.presetFile.files[0] ? ui.presetFile.files[0] : null;
            if (!file) {
                return;
            }

            try {
                const text = await file.text();
                if (ui.presetJson) {
                    ui.presetJson.value = text;
                }
                setPhase('open', t('messages.preset_loaded', 'Preset JSON chargé'));
            } catch (error) {
                setPhase('error', t('messages.preset_import_failed', 'Le fichier JSON est invalide'));
            } finally {
                ui.presetFile.value = '';
            }
        });
    }

    if (ui.pageUndo) {
        ui.pageUndo.addEventListener('click', () => restorePageHistory(-1));
    }

    if (ui.pageRedo) {
        ui.pageRedo.addEventListener('click', () => restorePageHistory(1));
    }

    if (ui.addCustomVariable) {
        ui.addCustomVariable.addEventListener('click', () => {
            state.variables = state.variables || {};
            state.variables.custom = getCustomVariablesEditable();
            state.variables.custom.push({
                key: '',
                value: '',
            });
            renderVariablesEditor();
            applyLivePreview({
                markDirty: true,
                message: t('status.preview_applied', 'Prévisualisation appliquée'),
            });
        });
    }

    ui.inputs.forEach((input) => {
        const eventName = input.type === 'checkbox' || input.tagName === 'SELECT' ? 'change' : 'input';
        input.addEventListener(eventName, () => {
            setByPath(state, input.dataset.key, parseInputValue(input));
            if (input.matches('select[data-te-image-select]')) {
                updateImagePreviewForSelect(input);
            }
            updateVisibility();
            applyLivePreview({
                markDirty: true,
                message: t('status.preview_applied', 'Prévisualisation appliquée'),
            });
        });
    });

    ui.save.addEventListener('click', saveConfig);
    ui.cancel.addEventListener('click', cancelChanges);

    ui.modal.addEventListener('click', (event) => {
        if (event.target.matches('[data-te-close-modal]')) {
            closeBlockModal();
        }
    });
    if (ui.catalogModal) {
        ui.catalogModal.addEventListener('click', (event) => {
            if (event.target.matches('[data-te-close-catalog-modal]')) {
                closeCatalogModal();
            }
        });
    }

    ui.modalSave.addEventListener('click', saveBlockModal);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !ui.modal.hidden) {
            closeBlockModal();
            return;
        }

        if (event.key === 'Escape' && ui.catalogModal && !ui.catalogModal.hidden) {
            closeCatalogModal();
            return;
        }

        if (event.key === 'Escape' && isPanelOpen()) {
            closePanel();
        }
    });

    window.addEventListener('theme-editor:discord-online-updated', () => {
        refreshSystemVariablesUiValues();
        applyLivePreview({
            markDirty: false,
            message: t('status.preview_applied', 'Prévisualisation appliquée'),
        });
    });

    const normalizedState = normalizeState(state);
    Object.keys(state).forEach((key) => {
        delete state[key];
    });
    Object.assign(state, normalizedState);
    savedState = normalizeState(savedState);

    const seededRouteBlocks = seedCurrentRouteBlocks();
    if (seededRouteBlocks) {
        savedState = normalizeState(deepClone(state));
    }

    applyStateToInputs(state);
    renderRouteContext();
    updateVisibility();
    sortCurrentRouteBlocks();
    renderActiveBlocks();
    resetPageHistory();
    renderPresetJson();
    switchTab('styles');
    switchSegment('style');
    applyLivePreview({ markDirty: false, message: t('status.ready', 'Prêt') });
    setPhase('idle', t('status.ready', 'Prêt'));
    }
};
