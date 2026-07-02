(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-accordion',
        category: 'components',
        register({ bm, t, categories, uid }) {
            bm.add('bs-accordion', {
                label: t('theme::pagebuilder.accordion', 'Accordion'),
                category: categories.components,
                content: () => {
                    const accordionId = uid('accordion');
                    const heading1 = uid('heading');
                    const heading2 = uid('heading');
                    const collapse1 = uid('collapse');
                    const collapse2 = uid('collapse');

                    return `
          <div data-gjs-type=\"bs-accordion\" class=\"accordion\" id=\"${accordionId}\">
            <div data-gjs-type=\"bs-accordion-item\" class=\"accordion-item\">
              <h2 data-gjs-type=\"bs-accordion-header\" class=\"accordion-header\" id=\"${heading1}\">
                <button data-gjs-type=\"bs-accordion-button\" class=\"accordion-button\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#${collapse1}\" aria-expanded=\"true\" aria-controls=\"${collapse1}\">${t('theme::pagebuilder.accordion_item_1', 'Accordion item #1')}</button>
              </h2>
              <div data-gjs-type=\"bs-accordion-collapse\" id=\"${collapse1}\" class=\"accordion-collapse collapse show\" aria-labelledby=\"${heading1}\" data-bs-parent=\"#${accordionId}\">
                <div data-gjs-type=\"bs-accordion-body\" class=\"accordion-body\">${t('theme::pagebuilder.accordion_content', 'Accordion content')}</div>
              </div>
            </div>
            <div data-gjs-type=\"bs-accordion-item\" class=\"accordion-item\">
              <h2 data-gjs-type=\"bs-accordion-header\" class=\"accordion-header\" id=\"${heading2}\">
                <button data-gjs-type=\"bs-accordion-button\" class=\"accordion-button\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#${collapse2}\" aria-expanded=\"true\" aria-controls=\"${collapse2}\">${t('theme::pagebuilder.accordion_item_2', 'Accordion item #2')}</button>
              </h2>
              <div data-gjs-type=\"bs-accordion-collapse\" id=\"${collapse2}\" class=\"accordion-collapse collapse show\" aria-labelledby=\"${heading2}\" data-bs-parent=\"#${accordionId}\">
                <div data-gjs-type=\"bs-accordion-body\" class=\"accordion-body\">${t('theme::pagebuilder.accordion_content', 'Accordion content')}</div>
              </div>
            </div>
          </div>
        `;
                },
                attributes: { class: 'fa fa-tasks' }
            });
        },
    });
})();
