(function () {
    const root = window;
    const state = root.pagebuilderBlocks && typeof root.pagebuilderBlocks === 'object'
        ? root.pagebuilderBlocks
        : {};

    if (!state.categories || typeof state.categories !== 'object' || Array.isArray(state.categories)) {
        state.categories = {};
    }

    if (!Array.isArray(state.items)) {
        state.items = [];
    }

    if (!(state.ids instanceof Set)) {
        state.ids = new Set(
            state.items
                .map((item) => item && item.id)
                .filter((id) => typeof id === 'string' && id.trim() !== '')
        );
    }

    root.pagebuilderBlocks = state;

    root.pagebuilderRegisterBlockCategory = function registerBlockCategory(key, resolver) {
        if (typeof key !== 'string' || key.trim() === '' || typeof resolver !== 'function') {
            return;
        }

        state.categories[key] = resolver;
    };

    root.pagebuilderRegisterBlock = function registerBlock(definition) {
        if (!definition || typeof definition !== 'object') {
            return;
        }

        const id = typeof definition.id === 'string' ? definition.id.trim() : '';
        if (id === '' || typeof definition.register !== 'function' || state.ids.has(id)) {
            return;
        }

        state.ids.add(id);
        state.items.push(definition);
    };
})();
