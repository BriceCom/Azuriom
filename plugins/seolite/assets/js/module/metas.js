// Consts
const metaElems = getElements(['meta:not([name="description"])']);
// Re-enable title element analysis for improved metadata section
const metaTitle = getElements('title');
const metaDescription = getElements('meta[name="description"]');

const OFFCANVAS_metas_id = "SEOLITE_metas"
const OFFCANVAS_metas_trigger = getElements(`#${OFFCANVAS_metas_id}--trigger`)
const OFFCANVAS_metas = getElements(`#${OFFCANVAS_metas_id}`)

// Function to validate meta tag lengths and provide visual feedback
function getMetaValidation(type, length) {
    let optimal, good, acceptable, status, color, percentage;

    if (type === 'Title') {
        // Title: 50-60 optimal, 30-49 good, 61-80 acceptable
        optimal = { min: 50, max: 60 };
        good = { min: 30, max: 49 };
        acceptable = { min: 61, max: 80 };

        if (length >= optimal.min && length <= optimal.max) {
            status = 'Optimal';
            color = 'success';
            percentage = 100;
        } else if (length >= good.min && length < optimal.min) {
            status = 'Good';
            color = 'info';
            percentage = 75;
        } else if (length > optimal.max && length <= acceptable.max) {
            status = 'Acceptable';
            color = 'warning';
            percentage = 60;
        } else if (length < good.min) {
            status = 'Too Short';
            color = 'danger';
            percentage = Math.max(20, (length / good.min) * 50);
        } else {
            status = 'Too Long';
            color = 'danger';
            percentage = 40;
        }
    } else if (type === 'Description') {
        // Description: 120-160 optimal, 100-119 good, 161-200 acceptable
        optimal = { min: 120, max: 160 };
        good = { min: 100, max: 119 };
        acceptable = { min: 161, max: 200 };

        if (length >= optimal.min && length <= optimal.max) {
            status = 'Optimal';
            color = 'success';
            percentage = 100;
        } else if (length >= good.min && length < optimal.min) {
            status = 'Good';
            color = 'info';
            percentage = 75;
        } else if (length > optimal.max && length <= acceptable.max) {
            status = 'Acceptable';
            color = 'warning';
            percentage = 60;
        } else if (length < good.min) {
            status = 'Too Short';
            color = 'danger';
            percentage = Math.max(20, (length / good.min) * 50);
        } else {
            status = 'Too Long';
            color = 'danger';
            percentage = 40;
        }
    }

    return { status, color, percentage, optimal, good, acceptable };
}

function createLiForListOfMetas(checkVar, list, title) {
    const ID = setRandomId();

    const li = document.createElement('li');
    li.setAttribute(DATA_SEO_ATTR, ID);
    li.classList.add('mb-3', 'p-3', 'border', 'rounded', 'shadow-sm');

    // Create header with title and tooltip
    const headerDiv = document.createElement('div');
    headerDiv.classList.add('d-flex', 'align-items-center', 'justify-content-between', 'mb-2');

    const titleSpan = document.createElement('span');
    titleSpan.classList.add('fw-semibold', 'text-muted', 'small');
    titleSpan.innerText = `${title}:`;

    // Add tooltip button using utility function
    const tooltipTitle = title === 'Title' ?
        trans('seolite::messages.modify_in_theme_files') :
        trans('seolite::messages.modify_in_admin_panel');
    const tooltipBtn = createTooltipButton(tooltipTitle);

    headerDiv.appendChild(titleSpan);
    headerDiv.appendChild(tooltipBtn);

    const text =  document.createElement('p');
    text.style.borderRadius = '0.375rem';
    text.style.padding = '0.5rem';

    // Check if the element exists
    if (checkVar.length === 0) {
        // No element found
        text.innerText = trans('seolite::messages.missing_meta', { title: title });
        text.classList.remove('btn-outline-secondary');
        text.classList.add('btn-outline-danger', 'text-danger');

        // Add warning icon
        const warningIcon = document.createElement('i');
        warningIcon.classList.add('bi', 'bi-exclamation-triangle', 'me-2');
        text.prepend(warningIcon);

        li.appendChild(headerDiv);
        li.appendChild(text);
    } else if (checkVar.length === 1) {
        // One element found (correct)
        const content = title === "Description" ?
            (checkVar[0].content || checkVar[0].getAttribute('content') || '') :
            (checkVar[0].textContent || '');
        text.innerText = content;
        text.classList.remove('btn-outline-secondary');
        text.classList.add('btn-outline-success');

        // Create character count and validation
        const charCount = countCharacters(content);
        const validation = getMetaValidation(title, charCount);

        // Create progress bar for length validation using utility function
        const progressContainer = createValidationProgressBar(charCount, validation);

        // Create badges using utility functions
        const charBadge = createCharCountBadge(content, validation.color);
        const fleschBadge = createFleschBadge(content);
        const badgeContainer = createBadgeContainer([charBadge, fleschBadge], ['mt-2']);

        li.appendChild(headerDiv);
        li.appendChild(text);
        li.appendChild(progressContainer);
        li.appendChild(badgeContainer);
    } else {
        // Multiple elements found (error)
        text.innerText = trans('seolite::messages.duplicate_meta', { title: title });
        text.classList.remove('btn-outline-secondary');
        text.classList.add('btn-outline-danger', 'text-danger');

        li.appendChild(headerDiv);
        li.appendChild(text);
    }

    list[0].appendChild(li);
}

// Put metas on OFFCANVAS_metas > li
function createListOfMetas(list) {
    createLiForListOfMetas(metaTitle, list, "Title");
    createLiForListOfMetas(metaDescription, list, "Description");
}

// Trigger listMetas
createModuleTrigger(OFFCANVAS_metas_trigger, 'SEOLITE_metas_placeholder', () => {
    createListOfMetas(OFFCANVAS_metas, metaElems);
});
