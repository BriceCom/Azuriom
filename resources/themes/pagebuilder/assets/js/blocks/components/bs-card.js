(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-card',
        category: 'components',
        register({ bm, t, categories }) {
            bm.add('bs-card', {
                label: t('theme::pagebuilder.card', 'Card'),
                category: categories.components,
                content: `
      <div data-gjs-type=\"bs-card\" class=\"card shadow-sm\">
        <div data-gjs-type=\"bs-card-body\" class=\"card-body\">
          <h5 class=\"card-title\">${t('theme::pagebuilder.card_title', 'Card title')}</h5>
          <p class=\"card-text\">${t('theme::pagebuilder.card_text', 'Card content')}</p>
          <a href=\"#\" class=\"btn btn-primary\" data-gjs-type=\"bs-button\">${t('theme::pagebuilder.button', 'Button')}</a>
        </div>
      </div>
    `,
                attributes: { class: 'fa fa-id-card-o' }
            });
        },
    });
})();
