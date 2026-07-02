(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'pb-image',
        category: 'components',
        register({ bm, t, categories, getImageSource }) {
            bm.add('pb-image', {
                label: t('theme::pagebuilder.image', 'Image'),
                category: categories.components,
                content: {
                    type: 'pb-image',
                    tagName: 'img',
                    attributes: {
                        src: getImageSource(0, t('theme::pagebuilder.image', 'Image')),
                        alt: t('theme::pagebuilder.image_alt', 'Image'),
                    },
                },
                attributes: { class: 'fa fa-picture-o' }
            });
        },
    });
})();
