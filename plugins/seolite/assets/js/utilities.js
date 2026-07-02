
/*
* MISC
*/

let CURRENT_ELM_VIEWING = null;

function setRandomId() {
    return Math.random().toString(36).slice(7);
}

function scrollToElement(elm) {
    elm.scrollIntoView({
        behavior: 'smooth',
        block: 'center',
        inline: 'nearest'
    });
}

function getElements(elm) {
    return document.querySelectorAll(elm);
}

const LEVEL = {
    VERY_GOOD: 'very-good',
    GOOD: 'good',
    MEDIUM: 'medium',
    WARNING: 'warning',
    DANGER: 'danger'
}

function triggerButtonPerElems({elm, functions}) {
    let alreadyExist = false;

    elm[0].addEventListener('click', () => {
        if (!alreadyExist) {
            console.log('TRIGGER', elm)

            functions();
            alreadyExist = true;
        }
    })
}


function createBadge(icon, text, attributes) {
    const span = document.createElement('span');
    const i = document.createElement('i');
    i.classList.add('bi', icon, 'me-1');

    // Use color-coded styling for Flesch badges to match headings section
    if (attributes && attributes.score) {
        span.classList.add('badge', `bg-${attributes.score}`, 'small');
    } else {
        span.classList.add('badge', 'rounded-pill', `text-bg-secondary`, 'px-2', 'py-1');
    }

    span.setAttribute('data-bs-toggle', 'tooltip');
    span.setAttribute('data-bs-placement', 'top');
    span.setAttribute('title', text);

    // Add custom attributes
    if (attributes) {
        Object.keys(attributes).forEach(key => {
            span.setAttribute(key, attributes[key]);
        });
    }

    span.textContent = text;
    span.prepend(i)
    return span;
}

function createCharCountBadge(text, colorClass = 'info') {
    const charCount = countCharacters(text);
    const badge = document.createElement('span');
    badge.classList.add('badge', `bg-${colorClass}`, 'small');
    badge.innerHTML = `<i class="bi bi-type me-1"></i>${charCount} ${trans('seolite::messages.chars')}`;
    return badge;
}

// Create Flesch Readability Badge
function createFleschBadge(text) {
    const fleschScore = scoreFlesch(text);
    const badge = document.createElement('span');
    badge.classList.add('badge', `bg-${getFleshAttrScore(fleschScore.score)}`, 'small');
    badge.innerHTML = `<i class="bi bi-book me-1"></i>${fleschScore.level}`;
    badge.setAttribute('title', fleschScore.message);
    return badge;
}

// Create Tag Badge (for headings)
function createTagBadge(level) {
    const badge = document.createElement('span');
    badge.classList.add('badge', 'bg-info', 'small');
    badge.innerHTML = `<i class="bi bi-tag me-1"></i>H${level}`;
    return badge;
}

// Create Badge Container
function createBadgeContainer(badges, additionalClasses = []) {
    const container = document.createElement('div');
    container.classList.add('d-flex', 'gap-2', 'align-items-center', ...additionalClasses);
    badges.forEach(badge => container.appendChild(badge));
    return container;
}

// Create Standard Button
function createStandardButton(text, additionalClasses = []) {
    const button = document.createElement('button');
    button.classList.add('w-100', 'text-start', 'text-truncate', ...additionalClasses);
    button.style.userSelect = 'text';
    button.style.background = 'unset';
    button.style.border = 'unset';
    button.style.outline = 'unset';
    button.innerText = text;
    return button;
}

// Create Standard Container
function createStandardContainer(id, additionalClasses = []) {
    const container = document.createElement('div');
    container.setAttribute(DATA_SEO_ATTR, id);
    container.classList.add('mb-2', 'p-2', 'border', 'rounded', ...additionalClasses);
    return container;
}

// Add Click Handler with Element Highlighting
function addHighlightClickHandler(element, targetElement) {
    element.addEventListener('click', () => {
        highlighElementViewing(targetElement);
    });
}

// Hide Placeholder Helper
function hidePlaceholder(placeholderId) {
    const placeholder = document.getElementById(placeholderId);
    if (placeholder) placeholder.style.display = 'none';
}

// Create Standard Module Trigger
function createModuleTrigger(triggerElement, placeholderId, callback) {
    triggerButtonPerElems({
        elm: triggerElement,
        functions: () => {
            hidePlaceholder(placeholderId);
            callback();
        }
    });
}

/*
* ELM
*/
function highlighElementViewing(elm) {
    if (CURRENT_ELM_VIEWING) {
        // get CURRENT_ELM_VIEWING and reset style
        CURRENT_ELM_VIEWING.style.outline = 'unset';
        CURRENT_ELM_VIEWING.style.outlineOffset = 'unset';
        CURRENT_ELM_VIEWING.style.boxShadow = 'unset';
        CURRENT_ELM_VIEWING.style.border = 'unset';
        CURRENT_ELM_VIEWING.style.position = CURRENT_ELM_VIEWING.dataset.originalPosition || 'unset';
        CURRENT_ELM_VIEWING.style.zIndex = CURRENT_ELM_VIEWING.dataset.originalZIndex || 'unset';
    }

    CURRENT_ELM_VIEWING = elm;

    // Store original styles
    elm.dataset.originalPosition = elm.style.position || getComputedStyle(elm).position;
    elm.dataset.originalZIndex = elm.style.zIndex || getComputedStyle(elm).zIndex;

    // Apply improved highlighting that works better for images in large containers
    elm.style.outline = '3px solid red';
    elm.style.outlineOffset = '3px';
    elm.style.boxShadow = '0 0 0 3px red, 0 0 10px rgba(255, 0, 0, 0.5)';
    elm.style.position = 'relative';
    elm.style.zIndex = '25';

    // Go to element
    scrollToElement(CURRENT_ELM_VIEWING)

    // Send debug message
    console.debug(`${PREFIX} - Current element viewing :`, elm)
}

/*
* TEXTS
* */
const TITLES = 'h1, h2, h3, h4, h5, h6';

function countWords(str) {
    return str.split(' ').length;
}

function countCharacters(str) {
    return str.replace(/\s/g, '').length;
}

function getPageTextContent() {
    let textContent = '';

    const mainContent = document.querySelector('body');

    if (mainContent) {
        textContent = mainContent.innerText || mainContent.textContent || '';
    } else {
        const body = document.body.cloneNode(true);

        const unwantedSelectors = ['script', 'style', '.offcanvas', '#seoliteOffcanvas', '[id*="SEOLITE"]', '.seolite', '.breadcrumb'];
        unwantedSelectors.forEach(sel => {
            body.querySelectorAll(sel).forEach(el => el.remove());
        });

        return body.innerText.trim();
    }

    return textContent.trim();
}

/*
* FLESCH
*/

// Function for Flesch readability index with language detection
function scoreFlesch(text) {

    if (!text || text.trim() === '') {
        return {
            total: 0,
            score: 0,
            level: trans('seolite::messages.empty_text'),
            message: trans('seolite::messages.the_text_is_empty'),
        };
    }

    function detectLanguage() {
        const langCode = document.documentElement.lang?.substring(0,2).toLowerCase() || 'en';

        const langMap = {
            fr: 'french',
            de: 'german',
            es: 'spanish',
            it: 'italian',
            pt: 'portuguese',
            ru: 'russian',
            ja: 'japanese',
            zh: 'chinese',
            ko: 'korean',
            ar: 'arabic',
            he: 'hebrew',
            en: 'english',
            uk: 'ukrainian',
        };

        return langMap[langCode] || 'english';
    }

    const language = detectLanguage(text);

    const words = text.trim().split(/\s+/);
    const nbWords = words.length;

    const phrases = text.split(/[.!?]+/).filter(phrase => phrase.trim().length > 0);
    const nbPhrases = Math.max(1, phrases.length); // Avoid division by zero

    let nbSyllabes = 0;

    words.forEach(word => {
        word = word.toLowerCase().replace(/[^\p{L}\p{N}]/gu, '');

        if (word.length === 0) return;

        let syllabes = 0;

        // Count vowel groups (works for most languages including Cyrillic, Latin scripts)
        // This pattern includes common vowels from multiple languages
        const vowelPattern = /[aeiouàáâãäåæèéêëìíîïòóôõöøùúûüýÿāēīōūăĕĭŏŭąęįųćńśźłđšžčřťďňĺľŕґєіїўыэюяёаеиоуэюяыъьѐѝѓќѕјљњћџѣѥѧѩѫѭѯѱѳѵѷѹѻѽѿҁҋҍҏґғҕҗҙқҝҟҡңҥҧҩҫҭүұҳҵҷҹһҽҿӀӂӄӆӈӊӌӎӑӓӕӗәӛӝӟӡӣӥӧөӫӭӯӱӳӵӷӹӻӽӿԁԃԅԇԉԋԍԏԑԓԕԗԙԛԝԟԡԣԥԧԩԫԭԯ]/gi;
        const vowelMatches = word.match(vowelPattern);

        if (vowelMatches) {
            const vowelGroups = word.replace(vowelPattern, 'V').match(/V+/g);
            syllabes = vowelGroups ? vowelGroups.length : 1;
        } else {
            syllabes = 1;
        }

        if (syllabes === 0) syllabes = 1;

        nbSyllabes += syllabes;
    });

    let score;

    switch (language) {
        case 'french':
            score = Math.max(0, Math.min(100,
                207 -
                (1.015 * (nbWords / nbPhrases)) -
                (73.6 * (nbSyllabes / nbWords))
            )).toFixed(1);
            break;

        case 'german':
            score = Math.max(0, Math.min(100,
                180 -
                (1 * (nbWords / nbPhrases)) -
                (58.5 * (nbSyllabes / nbWords))
            )).toFixed(1);
            break;

        case 'spanish':
        case 'italian':
        case 'portuguese':
            score = Math.max(0, Math.min(100,
                206.835 -
                (1.02 * (nbWords / nbPhrases)) -
                (60 * (nbSyllabes / nbWords))
            )).toFixed(1);
            break;

        case 'russian':
        case 'ukrainian':
            score = Math.max(0, Math.min(100,
                206.835 -
                (1.3 * (nbWords / nbPhrases)) -
                (60.1 * (nbSyllabes / nbWords))
            )).toFixed(1);
            break;

        default:
            score = Math.max(0, Math.min(100,
                206.835 -
                (1.015 * (nbWords / nbPhrases)) -
                (84.6 * (nbSyllabes / nbWords))
            )).toFixed(1);
    }

    let niveau, message;
    let prefix = trans('seolite::messages.readability_score_prefix');
    if (score >= 80) {
        niveau = trans('seolite::messages.very_easy');
        message = `${prefix} ${trans('seolite::messages.very_easy_to_read')}`;
    } else if (score >= 60) {
        niveau = trans('seolite::messages.easy');
        message = `${prefix} ${trans('seolite::messages.easy_to_read')}`;
    } else if (score >= 40) {
        niveau = trans('seolite::messages.standard');
        message = `${prefix} ${trans('seolite::messages.standard_difficulty')}`;
    } else if (score >= 20) {
        niveau = trans('seolite::messages.difficult');
        message = `${prefix} ${trans('seolite::messages.difficult_to_read')}`;
    } else {
        niveau = trans('seolite::messages.very_difficult');
        message = `${prefix} ${trans('seolite::messages.very_difficult_to_read')}`;
    }

    return {
        score: parseFloat(score),
        level: niveau,
        message: message,
        language: language,
        details: {
            mots: nbWords,
            syllabes: nbSyllabes,
            phrases: nbPhrases,
            syllabesParMot: (nbSyllabes / nbWords).toFixed(2),
            motsParPhrase: (nbWords / nbPhrases).toFixed(2)
        }
    };
}

function getFleshAttrScore(score) {
    if (score >= 80) {
        return 'success';
    } else if (score >= 60) {
        return 'primary';
    } else if (score >= 40) {
        return 'info';
    } else if (score >= 20) {
        return 'warning';
    } else {
        return 'danger';
    }
}

function getReadabilityLevel(score) {
    if (score >= 80) {
        return {
            level: trans('seolite::messages.very_easy'),
            color: 'success',
            message: trans('seolite::messages.very_easy_text')
        };
    } else if (score >= 60) {
        return {
            level: trans('seolite::messages.easy'),
            color: 'primary',
            message: trans('seolite::messages.easy_text')
        };
    } else if (score >= 40) {
        return {
            level: trans('seolite::messages.standard'),
            color: 'info',
            message: trans('seolite::messages.standard_text')
        };
    } else if (score >= 20) {
        return {
            level: trans('seolite::messages.difficult'),
            color: 'warning',
            message: trans('seolite::messages.difficult_text')
        };
    } else {
        return {
            level: trans('seolite::messages.very_difficult'),
            color: 'danger',
            message: trans('seolite::messages.very_difficult_text')
        };
    }
}

// Create Tooltip Button
function createTooltipButton(tooltipTitle, additionalClasses = []) {
    const tooltipBtn = document.createElement('button');
    tooltipBtn.classList.add('btn', 'btn-sm', 'text-info', 'p-1', ...additionalClasses);
    tooltipBtn.innerHTML = '<i class="bi bi-question-circle"></i>';
    tooltipBtn.setAttribute('data-bs-toggle', 'tooltip');
    tooltipBtn.setAttribute('data-bs-placement', 'top');
    tooltipBtn.setAttribute('data-bs-trigger', 'click');
    tooltipBtn.setAttribute('title', tooltipTitle);
    return tooltipBtn;
}

// Create Progress Bar with Validation
function createValidationProgressBar(length, validation) {
    const progressContainer = document.createElement('div');
    progressContainer.classList.add('mb-2');

    const progressLabel = document.createElement('div');
    progressLabel.classList.add('d-flex', 'justify-content-between', 'small', 'mb-1');
    progressLabel.innerHTML = `
        <span class="text-muted">${trans('seolite::messages.length')}: ${length} ${trans('seolite::messages.chars')}</span>
        <span class="text-${validation.color}">${validation.status}</span>
    `;

    const progressBar = document.createElement('div');
    progressBar.classList.add('progress');
    progressBar.style.height = '6px';

    const progressFill = document.createElement('div');
    progressFill.classList.add('progress-bar', `bg-${validation.color}`);
    progressFill.style.width = `${validation.percentage}%`;
    progressFill.setAttribute('role', 'progressbar');

    progressBar.appendChild(progressFill);
    progressContainer.appendChild(progressLabel);
    progressContainer.appendChild(progressBar);

    return progressContainer;
}
