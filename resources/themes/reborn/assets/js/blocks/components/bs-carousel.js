(function () {
    const registerBlock = window.pagebuilderRegisterBlock;
    if (typeof registerBlock !== 'function') {
        return;
    }

    registerBlock({
        id: 'bs-carousel',
        category: 'components',
        register({ bm, t, categories, uid, getImageSource }) {
            bm.add('bs-carousel', {
                label: t('theme::pagebuilder.carousel', 'Carousel'),
                category: categories.components,
                content: () => {
                    const carouselId = uid('carousel');

                    return `
          <div data-gjs-type=\"bs-carousel\" id=\"${carouselId}\" class=\"carousel slide\" data-bs-ride=\"carousel\">
            <div data-gjs-type=\"bs-carousel-indicators\" class=\"carousel-indicators\">
              <button data-gjs-type=\"bs-carousel-indicator\" type=\"button\" data-bs-target=\"#${carouselId}\" data-bs-slide-to=\"0\" class=\"active\" aria-current=\"true\" aria-label=\"Slide 1\"></button>
              <button data-gjs-type=\"bs-carousel-indicator\" type=\"button\" data-bs-target=\"#${carouselId}\" data-bs-slide-to=\"1\" aria-label=\"Slide 2\"></button>
              <button data-gjs-type=\"bs-carousel-indicator\" type=\"button\" data-bs-target=\"#${carouselId}\" data-bs-slide-to=\"2\" aria-label=\"Slide 3\"></button>
            </div>
            <div data-gjs-type=\"bs-carousel-inner\" class=\"carousel-inner\">
              <div data-gjs-type=\"bs-carousel-item\" class=\"carousel-item active\">
                <img data-gjs-type=\"pb-image\" src=\"${getImageSource(0, 'Slide 1')}\" class=\"d-block w-100\" alt=\"Slide 1\" />
              </div>
              <div data-gjs-type=\"bs-carousel-item\" class=\"carousel-item\">
                <img data-gjs-type=\"pb-image\" src=\"${getImageSource(1, 'Slide 2')}\" class=\"d-block w-100\" alt=\"Slide 2\" />
              </div>
              <div data-gjs-type=\"bs-carousel-item\" class=\"carousel-item\">
                <img data-gjs-type=\"pb-image\" src=\"${getImageSource(2, 'Slide 3')}\" class=\"d-block w-100\" alt=\"Slide 3\" />
              </div>
            </div>
            <button data-gjs-type=\"bs-carousel-control\" class=\"carousel-control-prev\" type=\"button\" data-bs-target=\"#${carouselId}\" data-bs-slide=\"prev\">
              <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
              <span class=\"visually-hidden\">Previous</span>
            </button>
            <button data-gjs-type=\"bs-carousel-control\" class=\"carousel-control-next\" type=\"button\" data-bs-target=\"#${carouselId}\" data-bs-slide=\"next\">
              <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>
              <span class=\"visually-hidden\">Next</span>
            </button>
          </div>
        `;
                },
                attributes: { class: 'fa fa-film' }
            });
        },
    });
})();
