(function () {
    const registerCategory = window.pagebuilderRegisterBlockCategory;
    if (typeof registerCategory !== 'function') {
        return;
    }

    registerCategory('components', ({ t }) => t('theme::pagebuilder.bootstrap_components', 'Bootstrap 5 - Components'));
})();
