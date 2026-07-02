(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-alert',
        category: 'components',
        register({ bm, t, categories }) {
            bm.add('bs-alert', {
                label: t('theme::pagebuilder.alert', 'Alert'),
                category: categories.components,
                content: `<div data-gjs-type=\"bs-alert\" class=\"alert alert-primary\" role=\"alert\">${t('theme::pagebuilder.alert_text', 'A simple alert component')}</div>`,
                attributes: { class: 'fa fa-exclamation-triangle' }
            });
        },
    });
})();
