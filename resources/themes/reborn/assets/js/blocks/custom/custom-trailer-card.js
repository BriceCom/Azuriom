(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'custom-trailer-card',
        category: 'custom',
        register({ bm, t, categories, assets, getImageSource }) {
            const fallbackImage = typeof assets.siteLogoUrl === 'string' && assets.siteLogoUrl.trim() !== ''
                ? assets.siteLogoUrl
                : getImageSource(1, 'Trailer');

            bm.add('custom-trailer-card', {
                label: t('theme::pagebuilder.custom_trailer_card_block', 'Trailer card'),
                category: categories.custom,
                content: {
                    type: 'custom-trailer-card',
                    attributes: {
                        'data-title': 'Trailer du serveur',
                        'data-text': 'Présente ton gameplay avec un visuel immersif.',
                        'data-video-url': 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'data-poster-url': fallbackImage,
                        'data-button-label': 'Voir la vidéo',
                    },
                },
                attributes: { class: 'fa fa-play-circle' }
            });
        },
    });
})();
