(function () {
    const registerCategory = window.pagebuilderRegisterBlockCategory;
    if (typeof registerCategory !== 'function') {
        return;
    }

    registerCategory('custom', ({ t }) => t('theme::pagebuilder.custom_components', 'Custom Components'));
})();
