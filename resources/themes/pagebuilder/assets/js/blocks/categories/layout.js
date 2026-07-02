(function () {
    const registerCategory = window.pagebuilderRegisterBlockCategory;
    if (typeof registerCategory !== 'function') {
        return;
    }

    registerCategory('layout', ({ t }) => t('theme::pagebuilder.bootstrap_layout', 'Bootstrap 5 - Layout'));
})();
