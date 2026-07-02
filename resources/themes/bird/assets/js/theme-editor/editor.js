class ThemeEditorBootstrap {
    constructor(coreFactory = null) {
        this.coreFactory = typeof coreFactory === 'function'
            ? coreFactory
            : () => new window.ThemeEditorCore();
    }

    run() {
        if (!window.ThemeEditorCore) {
            console.error('[theme-editor] ThemeEditorCore is not loaded.');
            return;
        }

        const core = this.coreFactory();
        if (!core || typeof core.mount !== 'function') {
            console.error('[theme-editor] Invalid ThemeEditorCore instance.');
            return;
        }

        core.mount();
    }
}

(() => {
    const boot = () => {
        const bootstrap = new ThemeEditorBootstrap();
        bootstrap.run();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
        return;
    }

    boot();
})();
