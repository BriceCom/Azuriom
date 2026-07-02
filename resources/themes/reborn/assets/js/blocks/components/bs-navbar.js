(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-navbar',
        category: 'components',
        register({ bm, t, categories }) {
            bm.add('bs-navbar', {
                label: t('theme::pagebuilder.navbar', 'Navbar'),
                category: categories.components,
                content: `
      <nav data-gjs-type=\"bs-navbar\" class=\"navbar navbar-expand-lg navbar-light bg-light\">
        <div class=\"container-fluid\">
          <a class=\"navbar-brand\" href=\"#\">Brand</a>
          <div class=\"navbar-nav\">
            <a class=\"nav-link active\" href=\"#\">Home</a>
            <a class=\"nav-link\" href=\"#\">Features</a>
            <a class=\"nav-link\" href=\"#\">Pricing</a>
          </div>
        </div>
      </nav>
    `,
                attributes: { class: 'fa fa-bars' }
            });
        },
    });
})();
