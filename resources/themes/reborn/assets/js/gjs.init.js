const pagebuilderContext = window.pagebuilderContext || {};
const pagebuilderInitial = window.pagebuilderInitial || {};
const pagebuilderState = window.pagebuilderState || (window.pagebuilderState = { rawConfig: null });
const pagebuilderAssets = window.pagebuilderAssets || {};
const pagebuilderEditorScope = window.pagebuilderEditorScope || (window.pagebuilderEditorScope = {
    type: 'page',
    sectionType: null,
    templateId: null,
});

const pagebuilderHeaders = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
};

let serverThemeConfigPromise = null;

function setEditorOpenState(isOpen) {
    const gjsContainer = document.getElementById('gjs');
    const actions = document.getElementById('gpsActions');

    if (gjsContainer) {
        gjsContainer.style.display = isOpen ? 'block' : 'none';
    }

    if (actions) {
        actions.style.display = isOpen ? 'flex' : 'none';
        actions.classList.toggle('is-open', !!isOpen);
    }

    document.body.classList.toggle('pagebuilder-editor-open', !!isOpen);
}

function parsePagebuilderConfig(rawConfig) {
    if (!rawConfig) {
        return {};
    }

    if (typeof rawConfig === 'string') {
        try {
            return JSON.parse(rawConfig);
        } catch (error) {
            console.warn('Error parsing pagebuilder config:', error);
            return {};
        }
    }

    if (typeof rawConfig === 'object' && !Array.isArray(rawConfig)) {
        return rawConfig;
    }

    return {};
}

function isComponentMap(candidate) {
    if (!candidate || typeof candidate !== 'object' || Array.isArray(candidate)) {
        return false;
    }

    const entries = Object.entries(candidate);
    if (entries.length === 0) {
        return true;
    }

    return entries.every(([, component]) => {
        if (!component || typeof component !== 'object' || Array.isArray(component)) {
            return false;
        }

        return Boolean(
            component.type ||
            component.tagName ||
            component.components ||
            component.content
        );
    });
}

function normalizeThemeTokens(value) {
    if (value && typeof value === 'object' && !Array.isArray(value)) {
        return value;
    }

    return {};
}

function normalizeEditorScope(scope) {
    const candidate = scope && typeof scope === 'object' ? scope : {};
    const sectionType = candidate.sectionType === 'header' || candidate.sectionType === 'footer'
        ? candidate.sectionType
        : null;
    const templateId = typeof candidate.templateId === 'string' && candidate.templateId.trim() !== ''
        ? candidate.templateId.trim()
        : null;

    if (candidate.type === 'global' && sectionType && templateId) {
        return {
            type: 'global',
            sectionType,
            templateId,
        };
    }

    return {
        type: 'page',
        sectionType: null,
        templateId: null,
    };
}

function getDefaultGlobalBucket() {
    return {
        active_id: null,
        templates: {},
    };
}

function getDefaultGlobalSections() {
    return {
        headers: getDefaultGlobalBucket(),
        footers: getDefaultGlobalBucket(),
    };
}

function getDefaultGlobalTemplateName(sectionType, templateId = '') {
    const suffix = templateId ? ` ${templateId.slice(-4)}` : '';
    return `${sectionType === 'header' ? 'Header' : 'Footer'}${suffix}`;
}

function normalizeGlobalTemplateEntry(entry, sectionType, templateId) {
    const normalized = normalizePageEntry(entry);
    if (!normalized) {
        return null;
    }

    const name = typeof entry?.name === 'string' && entry.name.trim() !== ''
        ? entry.name.trim()
        : getDefaultGlobalTemplateName(sectionType, templateId);

    return {
        name,
        components: normalized.components,
        css: normalized.css || '',
        metadata: normalized.metadata,
        lastSnapshot: normalized.lastSnapshot,
    };
}

function normalizeGlobalSections(globalSections) {
    const raw = globalSections && typeof globalSections === 'object' && !Array.isArray(globalSections)
        ? globalSections
        : {};

    const normalizeBucket = (bucket, sectionType) => {
        const source = bucket && typeof bucket === 'object' && !Array.isArray(bucket)
            ? bucket
            : {};
        const templates = {};
        const rawTemplates = source.templates && typeof source.templates === 'object' && !Array.isArray(source.templates)
            ? source.templates
            : {};

        Object.entries(rawTemplates).forEach(([templateId, template]) => {
            if (typeof templateId !== 'string' || templateId.trim() === '') {
                return;
            }

            const normalizedTemplate = normalizeGlobalTemplateEntry(template, sectionType, templateId);
            if (!normalizedTemplate) {
                return;
            }

            templates[templateId] = normalizedTemplate;
        });

        let activeId = typeof source.active_id === 'string' ? source.active_id : null;
        if (activeId && !templates[activeId]) {
            activeId = null;
        }

        if (!activeId && Object.keys(templates).length > 0) {
            activeId = Object.keys(templates)[0];
        }

        return {
            active_id: activeId,
            templates,
        };
    };

    return {
        headers: normalizeBucket(raw.headers, 'header'),
        footers: normalizeBucket(raw.footers, 'footer'),
    };
}

function serializeGlobalTemplateEntry(template) {
    const metadata = template?.metadata && typeof template.metadata === 'object' && !Array.isArray(template.metadata)
        ? template.metadata
        : {};
    const stored = {
        name: template?.name || '',
        components: template?.components || {},
        css: template?.css || '',
        metadata,
    };

    if (template?.lastSnapshot && template.lastSnapshot.components) {
        stored.last_snapshot = {
            components: template.lastSnapshot.components,
            css: template.lastSnapshot.css || '',
            theme_tokens: template.lastSnapshot.themeTokens || {},
            metadata: template.lastSnapshot.metadata || {},
        };
    }

    return stored;
}

function serializeGlobalSections(globalSections) {
    const normalized = normalizeGlobalSections(globalSections);
    const serializeBucket = (bucket) => {
        const templates = {};
        Object.entries(bucket.templates || {}).forEach(([templateId, template]) => {
            templates[templateId] = serializeGlobalTemplateEntry(template);
        });

        return {
            active_id: bucket.active_id || null,
            templates,
        };
    };

    return {
        headers: serializeBucket(normalized.headers),
        footers: serializeBucket(normalized.footers),
    };
}

function normalizePageEntry(entry) {
    if (isComponentMap(entry)) {
        return {
            components: entry,
            css: '',
            themeTokens: {},
            metadata: {},
            lastSnapshot: null,
        };
    }

    if (!entry || typeof entry !== 'object' || Array.isArray(entry)) {
        return null;
    }

    const currentComponents = entry.components;
    const snapshot = entry.last_snapshot;

    if (isComponentMap(currentComponents)) {
        let normalizedSnapshot = null;
        if (snapshot && typeof snapshot === 'object' && !Array.isArray(snapshot) && isComponentMap(snapshot.components)) {
            normalizedSnapshot = {
                components: snapshot.components,
                css: typeof snapshot.css === 'string' ? snapshot.css : '',
                themeTokens: normalizeThemeTokens(snapshot.theme_tokens),
                metadata: snapshot.metadata && typeof snapshot.metadata === 'object' && !Array.isArray(snapshot.metadata)
                    ? snapshot.metadata
                    : {},
            };
        }

        return {
            components: currentComponents,
            css: typeof entry.css === 'string' ? entry.css : '',
            themeTokens: normalizeThemeTokens(entry.theme_tokens),
            metadata: entry.metadata && typeof entry.metadata === 'object' && !Array.isArray(entry.metadata)
                ? entry.metadata
                : {},
            lastSnapshot: normalizedSnapshot,
        };
    }

    if (snapshot && typeof snapshot === 'object' && !Array.isArray(snapshot) && isComponentMap(snapshot.components)) {
        return {
            components: snapshot.components,
            css: typeof snapshot.css === 'string' ? snapshot.css : '',
            themeTokens: normalizeThemeTokens(snapshot.theme_tokens),
            metadata: snapshot.metadata && typeof snapshot.metadata === 'object' && !Array.isArray(snapshot.metadata)
                ? snapshot.metadata
                : {},
            lastSnapshot: null,
        };
    }

    return null;
}

function getPageEntryFromConfig(config) {
    const pageKey = pagebuilderContext.pageKey || 'default';

    if (config && typeof config === 'object' && !Array.isArray(config) && config.pages && typeof config.pages === 'object') {
        const scopedEntry = normalizePageEntry(config.pages[pageKey]);
        if (scopedEntry) {
            return scopedEntry;
        }
    }

    return null;
}

function getGlobalTemplateEntryFromConfig(config, sectionType, templateId) {
    const globalSections = normalizeGlobalSections(config?.global_sections);
    const bucket = sectionType === 'header' ? globalSections.headers : globalSections.footers;
    if (!bucket?.templates) {
        return null;
    }

    const template = bucket.templates[templateId];
    if (!template) {
        return null;
    }

    return {
        components: template.components || {},
        css: template.css || '',
        themeTokens: {},
        metadata: template.metadata || {},
        lastSnapshot: template.lastSnapshot || null,
    };
}

function getEditorEntryFromConfig(config) {
    const scope = normalizeEditorScope(pagebuilderEditorScope);
    if (scope.type === 'global') {
        return getGlobalTemplateEntryFromConfig(config, scope.sectionType, scope.templateId);
    }

    return getPageEntryFromConfig(config);
}

function applyPageEntryToEditor(editorInstance, pageEntry) {
    if (typeof editorInstance.setStyle === 'function') {
        editorInstance.setStyle(pageEntry?.css || '');
    }

    editorInstance.getComponents().reset();

    if (!pageEntry || !isComponentMap(pageEntry.components)) {
        return;
    }

    const components = Object.values(pageEntry.components);
    if (components.length > 0) {
        editorInstance.getComponents().add(components);
    }
}

function applyEditorScopeToEditor(editorInstance, config) {
    const editorEntry = getEditorEntryFromConfig(config);
    applyPageEntryToEditor(editorInstance, editorEntry);
    return editorEntry;
}

function buildPageMetadata() {
    return {
        route_key: pagebuilderContext.pageKey || 'default',
        route_name: pagebuilderContext.routeName || null,
        uri: pagebuilderContext.uri || null,
        locale: pagebuilderContext.locale || null,
        updated_at: new Date().toISOString(),
        updated_by: pagebuilderContext.userId || null,
    };
}

function buildGlobalTemplateMetadata(sectionType, templateId) {
    return {
        scope: 'global',
        section_type: sectionType,
        template_id: templateId,
        updated_at: new Date().toISOString(),
        updated_by: pagebuilderContext.userId || null,
    };
}

function getAssetManagerEntries() {
    const images = Array.isArray(pagebuilderAssets.azuriomImages) ? pagebuilderAssets.azuriomImages : [];

    return images
        .filter((image) => image && typeof image.url === 'string' && image.url.trim() !== '')
        .map((image) => ({
            type: 'image',
            src: image.url,
            name: image.name || image.url,
        }));
}

function migrateConfigToSchema3(currentConfig) {
    const migrated = {
        schema_version: 3,
        theme_tokens: {},
        pages: {},
        global_sections: getDefaultGlobalSections(),
    };

    if (!currentConfig || typeof currentConfig !== 'object' || Array.isArray(currentConfig)) {
        return migrated;
    }

    migrated.theme_tokens = normalizeThemeTokens(currentConfig.theme_tokens);
    migrated.global_sections = serializeGlobalSections(currentConfig.global_sections);

    if (currentConfig.pages && typeof currentConfig.pages === 'object' && !Array.isArray(currentConfig.pages)) {
        Object.entries(currentConfig.pages).forEach(([key, value]) => {
            const normalizedEntry = normalizePageEntry(value);
            if (!normalizedEntry) {
                return;
            }

            const storedEntry = {
                components: normalizedEntry.components,
                css: normalizedEntry.css || '',
                theme_tokens: normalizedEntry.themeTokens,
                metadata: normalizedEntry.metadata,
            };

            if (normalizedEntry.lastSnapshot) {
                storedEntry.last_snapshot = {
                    components: normalizedEntry.lastSnapshot.components,
                    css: normalizedEntry.lastSnapshot.css || '',
                    theme_tokens: normalizedEntry.lastSnapshot.themeTokens,
                    metadata: normalizedEntry.lastSnapshot.metadata,
                };
            }

            migrated.pages[key] = storedEntry;
        });
    }

    return migrated;
}

function buildPagebuilderConfigForSave(currentPageComponents, themeTokens = {}, currentPageCss = '') {
    const pageKey = pagebuilderContext.pageKey || 'default';
    const currentConfig = parsePagebuilderConfig(pagebuilderState.rawConfig);
    const nextConfig = migrateConfigToSchema3(currentConfig);
    const normalizedThemeTokens = normalizeThemeTokens(themeTokens);
    const scope = normalizeEditorScope(pagebuilderEditorScope);

    nextConfig.theme_tokens = normalizedThemeTokens;

    if (scope.type === 'global') {
        const globalSections = normalizeGlobalSections(nextConfig.global_sections);
        const bucketKey = scope.sectionType === 'header' ? 'headers' : 'footers';
        const bucket = globalSections[bucketKey];
        const existingTemplate = bucket.templates[scope.templateId] || null;
        const previousEntry = existingTemplate
            ? {
                components: existingTemplate.components,
                css: existingTemplate.css || '',
                metadata: existingTemplate.metadata || {},
                lastSnapshot: existingTemplate.lastSnapshot || null,
            }
            : null;
        const nextTemplate = {
            name: existingTemplate?.name || getDefaultGlobalTemplateName(scope.sectionType, scope.templateId),
            components: currentPageComponents,
            css: typeof currentPageCss === 'string' ? currentPageCss : '',
            metadata: {
                ...(existingTemplate?.metadata || {}),
                ...buildGlobalTemplateMetadata(scope.sectionType, scope.templateId),
            },
            lastSnapshot: null,
        };

        if (previousEntry && isComponentMap(previousEntry.components) && Object.keys(previousEntry.components).length > 0) {
            nextTemplate.lastSnapshot = {
                components: previousEntry.components,
                css: previousEntry.css || '',
                themeTokens: {},
                metadata: {
                    ...previousEntry.metadata,
                    snapshot_at: new Date().toISOString(),
                },
            };
        }

        bucket.templates[scope.templateId] = nextTemplate;
        if (!bucket.active_id || !bucket.templates[bucket.active_id]) {
            bucket.active_id = scope.templateId;
        }

        nextConfig.global_sections = serializeGlobalSections(globalSections);
        pagebuilderState.rawConfig = nextConfig;
        return nextConfig;
    }

    const previousEntry = normalizePageEntry(nextConfig.pages[pageKey]);
    const nextEntry = {
        components: currentPageComponents,
        css: typeof currentPageCss === 'string' ? currentPageCss : '',
        theme_tokens: {},
        metadata: buildPageMetadata(),
    };

    if (previousEntry && isComponentMap(previousEntry.components) && Object.keys(previousEntry.components).length > 0) {
        nextEntry.last_snapshot = {
            components: previousEntry.components,
            css: previousEntry.css || '',
            theme_tokens: previousEntry.themeTokens,
            metadata: {
                ...previousEntry.metadata,
                snapshot_at: new Date().toISOString(),
            },
        };
    }

    nextConfig.pages[pageKey] = nextEntry;
    pagebuilderState.rawConfig = nextConfig;

    return nextConfig;
}

function fetchServerThemeConfig() {
    if (serverThemeConfigPromise) {
        return serverThemeConfigPromise;
    }

    serverThemeConfigPromise = axios.get(window.pagebuilderRoutes.themeEdit, { headers: pagebuilderHeaders })
        .then((response) => response.data || {})
        .catch((error) => {
            console.warn('Could not load pagebuilder data from server:', error);
            return {};
        });

    return serverThemeConfigPromise;
}

function loadPagebuilderFromServer(editorInstance) {
    return fetchServerThemeConfig().then((serverConfig) => {
        const parsedConfig = parsePagebuilderConfig(serverConfig.pagebuilder);
        pagebuilderState.rawConfig = parsedConfig;

        const editorEntry = applyEditorScopeToEditor(editorInstance, parsedConfig);
        const scope = normalizeEditorScope(pagebuilderEditorScope);

        const loadedCount = editorEntry && isComponentMap(editorEntry.components)
            ? Object.keys(editorEntry.components).length
            : 0;

        console.log('Pagebuilder components loaded for scope:', scope.type, scope.sectionType || pagebuilderContext.pageKey, loadedCount);
    });
}

function loadPagebuilderFromInitial(editorInstance) {
    const initialConfig = parsePagebuilderConfig(pagebuilderInitial.pagebuilder || pagebuilderState.rawConfig);
    if (!initialConfig || Object.keys(initialConfig).length === 0) {
        return false;
    }

    pagebuilderState.rawConfig = initialConfig;
    applyEditorScopeToEditor(editorInstance, initialConfig);

    return true;
}

function loadThemeFromServer(editorInstance) {
    return fetchServerThemeConfig().then((serverConfig) => {
        if (serverConfig && serverConfig.styles) {
            try {
                const serverTheme = typeof serverConfig.styles === 'string'
                    ? JSON.parse(serverConfig.styles)
                    : serverConfig.styles;

                applyGlobalBootstrapTheme(editorInstance, serverTheme);
                localStorage.setItem('pagebuilder-bs-theme', JSON.stringify(serverTheme));
                return;
            } catch (error) {
                console.warn('Error parsing theme from server:', error);
            }
        }

        loadThemeFromLocalStorage(editorInstance);
    });
}

function loadThemeFromInitial(editorInstance) {
    if (!pagebuilderInitial || !pagebuilderInitial.styles) {
        return false;
    }

    try {
        const initialTheme = typeof pagebuilderInitial.styles === 'string'
            ? JSON.parse(pagebuilderInitial.styles)
            : pagebuilderInitial.styles;

        if (initialTheme && typeof initialTheme === 'object' && !Array.isArray(initialTheme)) {
            applyGlobalBootstrapTheme(editorInstance, initialTheme);
            localStorage.setItem('pagebuilder-bs-theme', JSON.stringify(initialTheme));
            return true;
        }
    } catch (error) {
        console.warn('Error parsing initial theme:', error);
    }

    return false;
}

function loadThemeFromLocalStorage(editorInstance) {
    const savedTheme = localStorage.getItem('pagebuilder-bs-theme');
    if (savedTheme) {
        try {
            const theme = JSON.parse(savedTheme);
            applyGlobalBootstrapTheme(editorInstance, theme);
            return;
        } catch (error) {
            console.warn('Error parsing theme from localStorage:', error);
        }
    }
}

function getEditorScope() {
    return normalizeEditorScope(pagebuilderEditorScope);
}

function setEditorScope(nextScope, editorInstance = null) {
    const scope = normalizeEditorScope(nextScope);
    pagebuilderEditorScope.type = scope.type;
    pagebuilderEditorScope.sectionType = scope.sectionType;
    pagebuilderEditorScope.templateId = scope.templateId;

    if (editorInstance) {
        const config = parsePagebuilderConfig(pagebuilderState.rawConfig);
        applyEditorScopeToEditor(editorInstance, config);
    }

    return scope;
}

function getGlobalSectionsFromState() {
    const currentConfig = parsePagebuilderConfig(pagebuilderState.rawConfig);
    const nextConfig = migrateConfigToSchema3(currentConfig);
    pagebuilderState.rawConfig = nextConfig;

    return normalizeGlobalSections(nextConfig.global_sections);
}

function setGlobalSectionsInState(globalSections) {
    const currentConfig = parsePagebuilderConfig(pagebuilderState.rawConfig);
    const nextConfig = migrateConfigToSchema3(currentConfig);
    nextConfig.global_sections = serializeGlobalSections(globalSections);
    pagebuilderState.rawConfig = nextConfig;

    return normalizeGlobalSections(nextConfig.global_sections);
}

window.pagebuilderSetEditorOpenState = setEditorOpenState;
window.pagebuilderBuildConfigForSave = buildPagebuilderConfigForSave;
window.pagebuilderGetEditorScope = getEditorScope;
window.pagebuilderSetEditorScope = (scope) => setEditorScope(scope, editor);
window.pagebuilderGetGlobalSections = getGlobalSectionsFromState;
window.pagebuilderSetGlobalSections = setGlobalSectionsInState;
window.pagebuilderRequestSave = () => {
    document.getElementById('saveBtn')?.click();
};

document.getElementById('editPageBtn')?.addEventListener('click', () => {
    setEditorOpenState(true);

    if (!editor) {
        const plugins = [Traits, Component, Blocks, Commands, RTE];
        const canvasStyles = [
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        ];

        if (typeof CustomComponents === 'function') {
            plugins.push(CustomComponents);
        }

        if (typeof pagebuilderAssets.canvasEditorStylesUrl === 'string'
            && pagebuilderAssets.canvasEditorStylesUrl.trim() !== '') {
            canvasStyles.push(pagebuilderAssets.canvasEditorStylesUrl);
        }

        if (typeof GlobalSections === 'function') {
            plugins.push(GlobalSections);
        }

        editor = grapesjs.init({
            container: '#gjs',
            height: '100vh',
            fromElement: false,
            storageManager: { type: null },
            assetManager: {
                upload: false,
                assets: getAssetManagerEntries(),
            },
            canvas: {
                styles: canvasStyles,
            },
            plugins,
        });

        // Charger theme prioritairement depuis l'etat embarque, puis serveur, puis localStorage.
        if (!loadThemeFromInitial(editor)) {
            loadThemeFromServer(editor);
        }

        // Charger contenu pagebuilder prioritairement depuis l'etat embarque puis serveur.
        if (!loadPagebuilderFromInitial(editor)) {
            loadPagebuilderFromServer(editor);
        }

        // Add Global Theme panel and theme mode toggle
        addGlobalThemePanel(editor);
        try { addThemeModeToggle(editor); } catch (e) {}
        // Enhance Style Manager with Bootstrap theme palette
        try { StyleManagerEnhancements(editor); } catch (e) {}
    }
});
