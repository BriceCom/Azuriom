(() => {
    class ThemeEditorI18n {
        constructor(messages = {}) {
            this.messages = messages && typeof messages === 'object' ? messages : {};
        }

        get(key) {
            if (typeof key !== 'string' || key.length === 0) {
                return null;
            }

            return key.split('.').reduce((acc, part) => (acc && typeof acc === 'object' ? acc[part] : undefined), this.messages);
        }

        format(template, params = {}) {
            return String(template).replace(/\{([a-zA-Z0-9_]+)\}/g, (match, token) => {
                if (!Object.prototype.hasOwnProperty.call(params, token)) {
                    return match;
                }

                return String(params[token]);
            });
        }

        t(key, fallback = '', params = {}) {
            const value = this.get(key);
            const template = typeof value === 'string' && value.length > 0 ? value : fallback;
            return this.format(template, params);
        }
    }

    window.ThemeEditorI18n = ThemeEditorI18n;
})();
