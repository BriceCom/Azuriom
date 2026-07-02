(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-tabs',
        category: 'components',
        register({ bm, t, categories, uid }) {
            bm.add('bs-tabs', {
                label: t('theme::pagebuilder.tabs', 'Tabs'),
                category: categories.components,
                content: () => {
                    const tabsId = uid('tabs');
                    const nav1 = `${tabsId}-nav-1`;
                    const nav2 = `${tabsId}-nav-2`;
                    const pane1 = `${tabsId}-pane-1`;
                    const pane2 = `${tabsId}-pane-2`;

                    return `
          <div data-gjs-type=\"bs-tabs\">
            <ul class=\"nav nav-tabs\" role=\"tablist\">
              <li class=\"nav-item\" role=\"presentation\">
                <button class=\"nav-link active\" data-bs-toggle=\"tab\" data-bs-target=\"#${pane1}\" type=\"button\" role=\"tab\" aria-controls=\"${pane1}\" aria-selected=\"true\" id=\"${nav1}\">${t('theme::pagebuilder.tab_1', 'Tab 1')}</button>
              </li>
              <li class=\"nav-item\" role=\"presentation\">
                <button class=\"nav-link\" data-bs-toggle=\"tab\" data-bs-target=\"#${pane2}\" type=\"button\" role=\"tab\" aria-controls=\"${pane2}\" aria-selected=\"false\" id=\"${nav2}\">${t('theme::pagebuilder.tab_2', 'Tab 2')}</button>
              </li>
            </ul>
            <div class=\"tab-content border border-top-0 p-3\">
              <div data-gjs-type=\"bs-tab-pane\" class=\"tab-pane fade show active\" id=\"${pane1}\" role=\"tabpanel\" aria-labelledby=\"${nav1}\">${t('theme::pagebuilder.tab_content_1', 'Tab content 1')}</div>
              <div data-gjs-type=\"bs-tab-pane\" class=\"tab-pane fade\" id=\"${pane2}\" role=\"tabpanel\" aria-labelledby=\"${nav2}\">${t('theme::pagebuilder.tab_content_2', 'Tab content 2')}</div>
            </div>
          </div>
        `;
                },
                attributes: { class: 'fa fa-folder-open-o' }
            });
        },
    });
})();
