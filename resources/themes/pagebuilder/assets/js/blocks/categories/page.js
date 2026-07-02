(function () {
    const registerCategory = window.pagebuilderRegisterBlockCategory;
    if (typeof registerCategory !== 'function') {
        return;
    }

    registerCategory('page', ({ t }) => t('theme::pagebuilder.page_components', 'Page components'));
})();
