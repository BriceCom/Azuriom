// Consts
const imgElems = document.querySelectorAll('body:not(#seoliteOffcanvas) img:not(#seoliteOffcanvas img)');
const OFFCANVAS_listImgAlt_id = "SEOLITE_imgAlt"
const OFFCANVAS_listImgAlt_trigger = getElements(`#${OFFCANVAS_listImgAlt_id}--trigger`)
const OFFCANVAS_listImgAlt = getElements(`#${OFFCANVAS_listImgAlt_id}`)

// Put img alt on OFFCANVAS_imgAlt > li
function createListOfImgAlt(list, elms) {

    Array.from(elms).map((elm) => {
        const ID = setRandomId();

        const li = createStandardContainer(ID, ['mb-3']);

        const button = createStandardButton('', ['mb-2']);
        button.style.border = 'unset';

        if (elm.alt) {
            button.innerText = `${elm.alt}`;
            button.classList.add('btn-outline-success');
            //button.setAttribute('contenteditable', 'true');

            // Create character count badge
            const charBadge = createCharCountBadge(elm.alt);

            // Change alt to element
            button.addEventListener('input', (e) => {
                elm.setAttribute('alt', e.target.textContent)
            })

            const badgeContainer = createBadgeContainer([charBadge]);

            li.appendChild(button);
            li.appendChild(badgeContainer);
        } else {
            button.innerText = trans('seolite::messages.missing_alternative_text');
            button.classList.add('btn-outline-danger', 'text-danger');

            const warningIcon = document.createElement('i');
            warningIcon.classList.add('bi', 'bi-exclamation-triangle', 'me-2');
            button.prepend(warningIcon);

            li.appendChild(button);
        }

        list[0].appendChild(li);

        // on click
        addHighlightClickHandler(li, elm);
    })
}

// Trigger listImgAlt
createModuleTrigger(OFFCANVAS_listImgAlt_trigger, 'SEOLITE_imgAlt_placeholder', () => {
    createListOfImgAlt(OFFCANVAS_listImgAlt, imgElems);
});
