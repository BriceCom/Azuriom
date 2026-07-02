(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-section',
        category: 'components',
        register({ bm, t, categories }) {
            bm.add('bs-section', {
                label: t('theme::pagebuilder.section', 'Section'),
                category: categories.components,
                content: `
      <section data-gjs-type=\"bs-section\" class=\"py-5\">
        <div class=\"container\">
          <h2 class=\"mb-3\">${t('theme::pagebuilder.section_title', 'Section title')}</h2>
          <p class=\"mb-0\">${t('theme::pagebuilder.section_text', 'Section content')}</p>
        </div>
      </section>
    `,
                attributes: { class: 'fa fa-window-maximize' }
            });
        },
    });
})();
