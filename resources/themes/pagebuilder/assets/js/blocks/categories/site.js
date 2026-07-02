(function () {
    const registerCategory = window.pagebuilderRegisterBlockCategory;
    if (typeof registerCategory !== 'function') {
        return;
    }

    registerCategory('site', ({ t }) => t('theme::pagebuilder.base_components', 'Base Components'));
})();
