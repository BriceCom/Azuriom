const OFFCANVAS_readability_id = "SEOLITE_readability"
const OFFCANVAS_readability_trigger = document.getElementById(`${OFFCANVAS_readability_id}--trigger`)

// Cache for readability data to prevent recalculations when opening other accordions
let cachedReadabilityData = null;
let cachedPageText = null;

function calculateReadabilityScore() {
    const pageText = getPageTextContent();

    // Return cached result if page text hasn't changed
    if (cachedPageText === pageText && cachedReadabilityData !== null) {
        return cachedReadabilityData;
    }

    if (!pageText || pageText.trim() === '') {
        const emptyResult = {
            total: 0,
            score: 0,
            level: trans('seolite::messages.empty_text'),
            message: trans('seolite::messages.no_content'),
            words: 0,
            sentences: 0,
            syllables: 0,
            color: 'secondary'
        };

        // Cache the result
        cachedPageText = pageText;
        cachedReadabilityData = emptyResult;
        return emptyResult;
    }

    const fleschData = scoreFlesch(pageText);
    const readabilityLevel = getReadabilityLevel(fleschData.score);

    let total;
    if (fleschData.score >= 80) {
        total = 20;
    } else if (fleschData.score >= 60) {
        total = 18;
    } else if (fleschData.score >= 40) {
        total = 15;
    } else if (fleschData.score >= 20) {
        total = 10;
    } else {
        total = 5;
    }

    const result = {
        total: total,
        score: fleschData.score,
        level: readabilityLevel.level,
        message: readabilityLevel.message,
        words: fleschData.details.mots,
        sentences: fleschData.details.phrases,
        syllables: fleschData.details.syllabes,
        color: readabilityLevel.color
    };

    // Cache the result
    cachedPageText = pageText;
    cachedReadabilityData = result;

    return result;
}

function updateReadabilityDisplay() {
    const readabilityData = calculateReadabilityScore();

    // Update score display
    const scoreSpan = document.getElementById('SEOLITE_readability_score');
    const progressBar = document.getElementById('SEOLITE_readability_progress');
    const levelText = document.getElementById('SEOLITE_readability_level_text');
    const messageDiv = document.getElementById('SEOLITE_readability_message');

    // Update statistics
    const wordsSpan = document.getElementById('SEOLITE_readability_words');
    const sentencesSpan = document.getElementById('SEOLITE_readability_sentences');
    const syllablesSpan = document.getElementById('SEOLITE_readability_syllables');

    if (scoreSpan && progressBar && levelText && messageDiv && wordsSpan && sentencesSpan && syllablesSpan) {
        // Update score and progress
        scoreSpan.textContent = Math.round(readabilityData.score);
        scoreSpan.className = `badge fs-6 bg-${readabilityData.color}`;

        progressBar.style.width = `${readabilityData.score}%`;
        progressBar.className = `progress-bar bg-${readabilityData.color}`;

        // Update level and message
        levelText.textContent = readabilityData.level;
        levelText.className = `text-${readabilityData.color} fw-semibold`;
        messageDiv.textContent = readabilityData.message;

        // Update statistics
        wordsSpan.textContent = readabilityData.words;
        sentencesSpan.textContent = readabilityData.sentences;
        syllablesSpan.textContent = readabilityData.syllables;
    }

    // Update accordion header score
    updateReadabilityScore(readabilityData.score);
}

// Update readability score in accordion header
function updateReadabilityScore(fleschScore) {
    let scoreValue = 0;
    const maxScore = 20;

    // Calculate score based on Flesch readability thresholds (max 20 points)
    if (fleschScore >= 80) {
        scoreValue = 20; // Very easy - perfect score
    } else if (fleschScore >= 60) {
        scoreValue = 18; // Easy - excellent score
    } else if (fleschScore >= 40) {
        scoreValue = 15; // Standard - good score
    } else if (fleschScore >= 20) {
        scoreValue = 10; // Difficult - moderate score
    } else if (fleschScore > 0) {
        scoreValue = 5; // Very difficult - low score
    } else {
        scoreValue = 0; // No content
    }

    // Create score object and use utility function
    const score = { total: scoreValue, max: maxScore };
    updateScoreDisplay('SEOLITE_readability', score);
}

// Initialize readability analysis when accordion is opened
if (OFFCANVAS_readability_trigger) {
    OFFCANVAS_readability_trigger.addEventListener('click', function() {
        setTimeout(updateReadabilityDisplay, 100);
    });
}


// Auto-calculate readability on page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(updateReadabilityDisplay, 200);

    // Add event listener for readability test button
    const testButton = document.getElementById('SEOLITE_readability_test_button');
    const testTextarea = document.getElementById('SEOLITE_readability_test_text');
    const testResults = document.getElementById('SEOLITE_readability_test_results');
    const testScore = document.getElementById('SEOLITE_readability_test_score');
    const testProgress = document.getElementById('SEOLITE_readability_test_progress');
    const testLevel = document.getElementById('SEOLITE_readability_test_level');

    if (testButton && testTextarea && testResults && testScore && testProgress && testLevel) {
        testButton.addEventListener('click', function() {
            const text = testTextarea.value.trim();
            if (text) {
                const fleschData = scoreFlesch(text);
                const readabilityLevel = getReadabilityLevel(fleschData.score);

                testScore.textContent = Math.round(fleschData.score);
                testScore.className = `badge bg-${readabilityLevel.color}`;
                testProgress.style.width = `${fleschData.score}%`;
                testProgress.className = `progress-bar bg-${readabilityLevel.color}`;
                testLevel.textContent = readabilityLevel.level;
                testLevel.className = `fw-semibold text-${readabilityLevel.color}`;

                testResults.classList.remove('d-none');
            }
        });
    }
});
