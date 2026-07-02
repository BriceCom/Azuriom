(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-button',
        category: 'components',
        register({ bm, t, categories }) {
            bm.add('bs-button', {
                label: t('theme::pagebuilder.button', 'Button'),
                category: categories.components,
                content: () => {
                    let variant = 'primary';
                    let outline = false;
                    let size = 'default';

                    try {
                        const saved = JSON.parse(localStorage.getItem('pagebuilder-bs-theme') || '{}');
                        if (saved && saved.buttons) {
                            variant = saved.buttons.defaultVariant || variant;
                            outline = !!saved.buttons.defaultOutline;
                            size = saved.buttons.defaultSize || size;
                        }
                    } catch (error) {
                        // Ignore malformed localStorage
                    }

                    const classes = ['btn'];
                    classes.push(outline ? `btn-outline-${variant}` : `btn-${variant}`);
                    if (size === 'sm') classes.push('btn-sm');
                    if (size === 'lg') classes.push('btn-lg');

                    return `<a class=\"${classes.join(' ')}\" data-gjs-type=\"bs-button\" href=\"#\">${t('theme::pagebuilder.button', 'Button')}</a>`;
                },
                attributes: { class: 'fa fa-hand-pointer-o' }
            });
        },
    });
})();
