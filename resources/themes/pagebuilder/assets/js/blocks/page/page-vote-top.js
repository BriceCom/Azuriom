(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'page-vote-top',
        category: 'page',
        when: ({ flags }) => !!flags.isVoteHomePage,
        register({ bm, t, categories }) {
            bm.add('page-vote-top', {
                label: t('theme::pagebuilder.page_vote_top', 'Vote - Top voters'),
                category: categories.page,
                content: `<div data-gjs-type=\"page-vote-top\" class=\"alert alert-info mb-0\">${t('theme::pagebuilder.page_component_editor_hint', 'Dynamic page component rendered on site')}</div>`,
                attributes: { class: 'fa fa-trophy' }
            });
        },
    });
})();
