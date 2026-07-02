const OFFCANVAS_headings_id = "SEOLITE_headings"
const OFFCANVAS_headings_trigger = getElements(`#${OFFCANVAS_headings_id}--trigger`)
const OFFCANVAS_headings = getElements(`#${OFFCANVAS_headings_id}`)

// Function to get Text of spectific title element
function getTitleText(element) {
    return element.innerText;
}

// Function to get list of title elements, level and text
function getTitles() {
    return Array.from(getElements(TITLES)).map((element) => {
        return {
            level: parseInt(element.tagName.substring(1)),
            tag: element.tagName.toLowerCase(),
            text: getTitleText(element).trim(),
            children: [],
            elm: element
        };
    });
}

// Same to getTitles but if is parent do put on object alls children titles
function getTitlesTree() {
    return Array.from(getElements(TITLES)).map((element) => {
        return {
            parent: element.parentElement.parentNode
        };
    })
}

// Function to get grouped list of getTitles , ex all h3 on h3, h4 on h4
function getGroupedTitles() {
    return getTitles().reduce((acc, title) => {
        if (!acc[title.level]) {
            acc[title.level] = [];
        }
        acc[title.level].push(title);
        return acc;
    }, {});
}

// Fonction pour générer la hiérarchie imbriquée
function getTitlesHierarchy() {
    const titles = getTitles();
    const root = [];
    const stack = [];

    titles.forEach(title => {
        while (stack.length > 0 && stack[stack.length - 1].level >= title.level) {
            stack.pop();
        }

        if (stack.length === 0) {
            root.push(title);
        } else {
            stack[stack.length - 1].children.push(title);
        }

        stack.push(title);
    });

    return root;
}

function createLiForListOfHeadings() {
    const ID = setRandomId();
    const headings = getTitlesHierarchy();

    function setText(level, text){
        return text; // Remove HTML tag indicators, will be replaced with badges
    }

    function getHeadingBadgeColor(level, charCount) {
        if (level === 1) {
            // H1: 50-80 perfect, outside = warning (Medium impact)
            if (charCount >= 50 && charCount <= 80) return 'success';
            return 'warning'; // Too short or too long
        }
        // For other heading levels, use standard color coding
        if (charCount < 30) return 'danger';
        if (charCount >= 30 && charCount <= 60) return 'success';
        if (charCount > 60) return 'warning';
        return 'secondary';
    }

    // Helper function to create heading badges
    function createHeadingBadges(heading, additionalClasses = []) {
        const charCount = countCharacters(heading.text);
        const tagBadge = createTagBadge(heading.level);
        const charBadge = createCharCountBadge(heading.text, getHeadingBadgeColor(heading.level, charCount));
        return createBadgeContainer([tagBadge, charBadge], ['mt-1', ...additionalClasses]);
    }

    function createHeadingTree(heading) {
        if (!heading.children || heading.children.length === 0) {
            const container = document.createElement('div');
            container.classList.add('mb-2', 'p-2', 'border', 'rounded');

            const button = createStandardButton(setText(heading.level, heading.text), ['mb-2']);
            button.setAttribute(DATA_SEO_ATTR, ID);

            const badgesContainer = createHeadingBadges(heading);

            container.appendChild(button);
            container.appendChild(badgesContainer);

            // on click
            addHighlightClickHandler(button, heading.elm);

            return container;
        } else {
            const details = document.createElement('details');
            details.setAttribute(DATA_SEO_ATTR, ID);
            details.classList.add('mb-2', 'p-2');

            const summary = document.createElement('summary');
            summary.classList.add('w-100', 'text-start', 'mb-2', 'text-truncate');
            summary.style.userSelect = 'text';
            summary.style.background = 'unset';
            summary.style.border = 'unset';
            summary.style.outline = 'unset';
            summary.style.cursor = 'pointer';
            summary.innerText = setText(heading.level, heading.text);

            const badgesContainer = createHeadingBadges(heading, ['mb-2']);

            // on click
            addHighlightClickHandler(summary, heading.elm);

            details.appendChild(summary);
            details.appendChild(badgesContainer);

            const ul = document.createElement('ul');
            ul.classList.add('list-unstyled', 'ps-3', 'mt-2', 'border-start');

            heading.children.forEach((child) => {
                console.log(child)
                const li = document.createElement('li');
                li.classList.add('mb-1');
                li.appendChild(createHeadingTree(child));

                // on click
                addHighlightClickHandler(li, child.elm);

                ul.appendChild(li);
            });

            details.appendChild(ul);
            return details;
        }
    }

    headings.forEach((heading) => {
        const element = createHeadingTree(heading);
        OFFCANVAS_headings[0].appendChild(element);
    });
}



// Trigger listHeadings
createModuleTrigger(OFFCANVAS_headings_trigger, 'SEOLITE_headings_placeholder', () => {
    createLiForListOfHeadings();
});
