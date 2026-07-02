window.ThemeEditorCoreVariables = function createThemeEditorCoreVariables(context) {
    const {
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
        refreshImagePreviews,
        applyLivePreview,
    } = context;

    const parseInputValue = (input) => {
        if (input.type === 'checkbox') {
            return Boolean(input.checked);
        }

        if (input.type === 'number') {
            const parsed = Number(input.value);
            return Number.isFinite(parsed) ? parsed : 0;
        }

        return input.value;
    };

    const toBoolean = (value, fallback = false) => {
        if (typeof value === 'boolean') {
            return value;
        }
        if (typeof value === 'string') {
            const normalized = value.trim().toLowerCase();
            if (['1', 'true', 'yes', 'on'].includes(normalized)) {
                return true;
            }
            if (['0', 'false', 'no', 'off', ''].includes(normalized)) {
                return false;
            }
        }
        if (typeof value === 'number') {
            return value !== 0;
        }

        return fallback;
    };

    const getSystemVariables = () => normalizeSystemVariables(state.variables?.system || []);

    const normalizeEditableCustomVariables = (variables) => {
        if (!Array.isArray(variables)) {
            return [];
        }

        return variables
            .filter((item) => item && typeof item === 'object')
            .map((item) => ({
                key: normalizeVariableKey(item.key),
                value: item.value == null ? '' : String(item.value),
            }));
    };

    const getCustomVariablesEditable = () => normalizeEditableCustomVariables(state.variables?.custom || []);
    const getCustomVariablesForTemplate = () => {
        const reservedKeys = new Set(getSystemVariables().map((item) => item.key));
        return normalizeCustomVariables(getCustomVariablesEditable())
            .filter((item) => !reservedKeys.has(item.key));
    };

    const getSystemVariableValue = (key, fallback = '') => {
        const normalizedKey = normalizeVariableKey(key);
        if (!normalizedKey) {
            return String(fallback);
        }

        if (normalizedKey === 'discord_online_count') {
            const online = Number(window.THEME?.discord_online);
            if (Number.isFinite(online)) {
                return String(Math.max(0, Math.floor(online)));
            }
        }

        const serverCountFromTheme = Number(window.THEME?.servers_online_count);
        if (normalizedKey === 'servers_online_count' && Number.isFinite(serverCountFromTheme)) {
            return String(Math.max(0, Math.floor(serverCountFromTheme)));
        }

        const found = getSystemVariables().find((item) => item.key === normalizedKey);
        return found ? String(found.value) : String(fallback);
    };

    const getTemplateVariablesMap = () => {
        const map = {};

        getSystemVariables().forEach((item) => {
            map[item.key] = getSystemVariableValue(item.key, item.value);
        });

        getCustomVariablesForTemplate().forEach((item) => {
            if (!item.key) {
                return;
            }
            map[item.key] = String(item.value || '');
        });

        return map;
    };

    const resolveTemplateVariables = (value) => {
        if (typeof value !== 'string' || value.length === 0) {
            return value;
        }

        const variables = getTemplateVariablesMap();
        return value.replace(/\{([A-Za-z0-9_]+)\}/g, (match, key) => {
            const normalizedKey = normalizeVariableKey(key);
            if (!normalizedKey || !Object.prototype.hasOwnProperty.call(variables, normalizedKey)) {
                return match;
            }
            return String(variables[normalizedKey]);
        });
    };

    const refreshSystemVariablesUiValues = () => {
        if (!ui.systemVariablesList) {
            return;
        }

        Array.from(ui.systemVariablesList.querySelectorAll('[data-te-system-variable-item]')).forEach((itemNode) => {
            const key = normalizeVariableKey(itemNode.getAttribute('data-te-system-variable-item'));
            if (!key) {
                return;
            }

            const valueInput = itemNode.querySelector('[data-te-system-variable-value]');
            if (valueInput instanceof HTMLInputElement) {
                valueInput.value = getSystemVariableValue(key);
            }
        });
    };

    const renderVariablesEditor = () => {
        if (!ui.systemVariablesList || !ui.customVariablesList) {
            return;
        }

        const systemVariables = getSystemVariables();
        const customVariables = getCustomVariablesEditable();
        state.variables = state.variables || {};
        state.variables.system = systemVariables;
        state.variables.custom = customVariables;

        ui.systemVariablesList.innerHTML = '';
        ui.customVariablesList.innerHTML = '';

        systemVariables.forEach((variable) => {
            const item = ui.systemVariableTemplate instanceof HTMLTemplateElement
                ? ui.systemVariableTemplate.content.firstElementChild?.cloneNode(true)
                : null;
            if (!(item instanceof HTMLElement)) {
                return;
            }

            item.setAttribute('data-te-system-variable-item', variable.key);

            const title = item.querySelector('[data-te-system-variable-title]');
            if (title) {
                title.textContent = variable.label || variable.key;
            }

            const tokenInput = item.querySelector('[data-te-system-variable-token]');
            if (tokenInput instanceof HTMLInputElement) {
                tokenInput.value = `{${variable.key}}`;
            }

            const valueInput = item.querySelector('[data-te-system-variable-value]');
            if (valueInput instanceof HTMLInputElement) {
                valueInput.value = getSystemVariableValue(variable.key, variable.value);
            }

            ui.systemVariablesList.appendChild(item);
        });

        customVariables.forEach((variable, index) => {
            const item = ui.customVariableTemplate instanceof HTMLTemplateElement
                ? ui.customVariableTemplate.content.firstElementChild?.cloneNode(true)
                : null;
            if (!(item instanceof HTMLElement)) {
                return;
            }

            const keyInput = item.querySelector('[data-te-custom-variable-key]');
            const valueInput = item.querySelector('[data-te-custom-variable-value]');
            const deleteButton = item.querySelector('[data-te-custom-variable-delete]');

            if (keyInput instanceof HTMLInputElement) {
                keyInput.value = variable.key || '';
                keyInput.addEventListener('input', () => {
                    state.variables.custom[index].key = normalizeVariableKey(keyInput.value);
                    keyInput.value = state.variables.custom[index].key;
                    applyLivePreview({
                        markDirty: true,
                        message: t('status.preview_applied', 'Prévisualisation appliquée'),
                    });
                });
            }

            if (valueInput instanceof HTMLInputElement) {
                valueInput.value = String(variable.value || '');
                valueInput.addEventListener('input', () => {
                    state.variables.custom[index].value = valueInput.value;
                    applyLivePreview({
                        markDirty: true,
                        message: t('status.preview_applied', 'Prévisualisation appliquée'),
                    });
                });
            }

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                    const next = getCustomVariablesEditable().filter((_, currentIndex) => currentIndex !== index);
                    state.variables.custom = next;
                    renderVariablesEditor();
                    applyLivePreview({
                        markDirty: true,
                        message: t('status.preview_applied', 'Prévisualisation appliquée'),
                    });
                });
            }

            ui.customVariablesList.appendChild(item);
        });
    };

    const applyStateToInputs = (snapshot) => {
        ui.inputs.forEach((input) => {
            const key = input.dataset.key;
            const value = getByPath(snapshot, key);

            if (input.type === 'checkbox') {
                input.checked = Boolean(value);
                return;
            }

            input.value = value == null ? '' : value;
        });

        refreshImagePreviews();
        renderVariablesEditor();
    };

    const readInputsToState = () => {
        ui.inputs.forEach((input) => {
            setByPath(state, input.dataset.key, parseInputValue(input));
        });
        state.variables.custom = getCustomVariablesEditable();
    };

    const updateVisibility = () => {
        const advanced = Boolean(state.advanced?.advanced_mode);
        const launcher = Boolean(state.global?.server_launcher);

        root.querySelectorAll('[data-te-advanced-hint]').forEach((element) => {
            element.hidden = advanced;
        });

        root.querySelectorAll('.te-launcher-only').forEach((element) => {
            element.hidden = !launcher;
        });
    };

    const applyColorPreset = (presetKey) => {
        const preset = colorPresets[presetKey];
        if (!preset) {
            return;
        }

        state.styles = state.styles || {};
        state.styles.colors = state.styles.colors || {};
        state.styles.colors.light = {
            ...(state.styles.colors.light || {}),
            ...preset.light,
        };
        state.styles.colors.dark = {
            ...(state.styles.colors.dark || {}),
            ...preset.dark,
        };

        applyStateToInputs(state);
        applyLivePreview({
            markDirty: true,
            message: t('messages.preset_applied', 'Preset "{label}" appliqué', {
                label: preset.label,
            }),
        });
    };

    const isAdvancedModeActive = () => Boolean(state.advanced?.advanced_mode);

    return {
        parseInputValue,
        toBoolean,
        getSystemVariables,
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
    };
};
