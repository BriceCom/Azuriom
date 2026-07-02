(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'page-vote-rewards',
        category: 'page',
        when: ({ flags }) => !!flags.isVoteHomePage,
        register({ bm, t, categories }) {
            bm.add('page-vote-rewards', {
                label: t('theme::pagebuilder.page_vote_rewards', 'Vote - Rewards'),
                category: categories.page,
                content: `<div data-gjs-type=\"page-vote-rewards\" class=\"alert alert-info mb-0\">${t('theme::pagebuilder.page_component_editor_hint', 'Dynamic page component rendered on site')}</div>`,
                attributes: { class: 'fa fa-gift' }
            });
        },
    });
})();
