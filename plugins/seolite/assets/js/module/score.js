function getScoreBadgeColor(score, maxScore) {
    const percentage = (score / maxScore) * 100;
    if (percentage > 70) return 'success';
    if (percentage >= 50) return 'warning';
    return 'danger';
}

function updateScoreDisplay(sectionId, score) {
    const scoreSpan = document.getElementById(`${sectionId}--score`);
    const scoreMaxSpan = document.getElementById(`${sectionId}--score-max`);
    const badgeElement = document.getElementById(`${sectionId}--score-badge`);

    if (scoreSpan && scoreMaxSpan && badgeElement) {
        scoreSpan.innerText = score.total;
        scoreMaxSpan.innerText = score.max;

        // Update badge with color based on score percentage
        const badgeColor = getScoreBadgeColor(score.total, score.max);
        badgeElement.className = `d-flex gap-1 badge text-bg-${badgeColor} ms-auto`;
    }
}

function calculateAltScore() {
    const images = document.querySelectorAll('img');
    const total = images.length;
    let withAlt = 0;

    let score = {
        total: 0,
        max: 20,
        h1: 0,
        h2: 0
    };

    images.forEach(img => {
        if (img.hasAttribute('alt')) {
            if(img.alt.length > 0) {
                withAlt++
            }
        }
    });

    // Handle case when there are no images
    score.total = total === 0 ? 0 : Math.round((withAlt / total) * 20);

    // Use utility function to update score display
    updateScoreDisplay(OFFCANVAS_listImgAlt_id, score);

    return score;
}

function calculateHeadingsScore() {

    const h1s = getElements('h1');
    const h2s = getElements('h2');

    let score = {
        total: 0,
        max: 10,
        h1: 0,
        h2: 0
    };

    if (h1s.length === 1) {
        score.h1 = 5
        score.total += score.h1
    }
    if (h2s.length > 0) {
        score.h2 = 5
        score.total += score.h2
    }

    // Use utility function to update score display
    updateScoreDisplay(OFFCANVAS_headings_id, score);

    return score;
}

function calculateMetaScore() {
    const title = metaTitle[0];
    const meta = metaDescription[0];

    // Score
    let score = {
        total: 0,
        max: 30,
        title: 0,
        description: 0
    };

    // Title Score (15 points max)
    let titleScoreMax = 15;
    if(title) {
        let titleCharacters = countCharacters(title.textContent);

        // Title: ideal 50-60 chars, <30 too short, >60 too long
        if(titleCharacters >= 50 && titleCharacters <= 60) {
            score.title = titleScoreMax; // Perfect score
        } else if(titleCharacters >= 30 && titleCharacters < 50) {
            score.title = Math.round(titleScoreMax * 0.7); // Good but not ideal
        } else if(titleCharacters > 60 && titleCharacters <= 80) {
            score.title = Math.round(titleScoreMax * 0.5); // Too long but acceptable
        } else {
            score.title = 0; // Too short (<30) or way too long (>80)
        }
        score.total += score.title;
    }

    // Description Score (15 points max)
    let metaScoreMax = 15;
    if(meta) {
        let metaCharacters = countCharacters(meta.content);

        // Description: ideal 120-160 chars, <100 too vague, >160 truncated
        if(metaCharacters >= 120 && metaCharacters <= 160) {
            score.description = metaScoreMax; // Perfect score
        } else if(metaCharacters >= 100 && metaCharacters < 120) {
            score.description = Math.round(metaScoreMax * 0.7); // Good but not ideal
        } else if(metaCharacters > 160 && metaCharacters <= 200) {
            score.description = Math.round(metaScoreMax * 0.5); // Too long but acceptable
        } else {
            score.description = 0; // Too short (<100) or way too long (>200)
        }
        score.total += score.description;
    }

    // Use utility function to update score display
    updateScoreDisplay(OFFCANVAS_metas_id, score);

    return score;
}


function calculateSEOTotalScore() {
    const metaScore = calculateMetaScore().total || 0;
    const headingsScore = calculateHeadingsScore().total || 0;
    const altScore = calculateAltScore().total || 0;
    const readabilityScore = calculateReadabilityScore().total || 0;

    // Get image optimization score and update display
    const imageOptimizationScore = (() => {
        try {
            // Build combined list in the same way as img-opti.js (img tags + CSS background images)
            const imgTagEntries = typeof imgElems !== 'undefined' ? Array.from(imgElems).map(img => img) : Array.from(document.querySelectorAll('body:not(#seoliteOffcanvas) img')).map(img => img);
            const bgEntries = (typeof getBackgroundImageEntries === 'function') ? getBackgroundImageEntries() : [];

            // Merge, avoiding duplicates by src
            const bySrc = new Map();
            imgTagEntries.forEach(it => { if (it && it.src) bySrc.set(it.src, it); });
            bgEntries.forEach(be => { if (be && be.src && !bySrc.has(be.src)) bySrc.set(be.src, be); });

            const combined = Array.from(bySrc.values());
            if (combined.length === 0) {
                updateScoreDisplay(OFFCANVAS_imageOptimization_id, { total: 0, max: 20 });
                return 0;
            }

            // Reuse cached analysis if available to keep consistency with the accordion result
            let analysis = (typeof cachedImageAnalysis !== 'undefined' && cachedImageAnalysis) ? cachedImageAnalysis : null;
            if (!analysis) {
                analysis = analyzeImageOptimization(combined);
                // Populate cache so the accordion uses the same dataset/result
                if (typeof cachedImageAnalysis !== 'undefined') {
                    cachedImageAnalysis = analysis;
                }
            }

            // Use the shared score updater for consistency
            const score = calculateImageOptimizationScore(analysis);
            return score.total;
        } catch (error) {
            console.warn('Error calculating image optimization score:', error);
            updateScoreDisplay(OFFCANVAS_imageOptimization_id, { total: 0, max: 20 });
            return 0;
        }
    })();

    // Ensure all scores are valid numbers
    const validMetaScore = isNaN(metaScore) ? 0 : metaScore;
    const validHeadingsScore = isNaN(headingsScore) ? 0 : headingsScore;
    const validAltScore = isNaN(altScore) ? 0 : altScore;
    const validReadabilityScore = isNaN(readabilityScore) ? 0 : readabilityScore;
    const validImageOptimizationScore = isNaN(imageOptimizationScore) ? 0 : imageOptimizationScore;

    console.log('Meta score: ', validMetaScore);
    console.log('Headings score: ', validHeadingsScore);
    console.log('Alt score: ', validAltScore);
    console.log('Readability score: ', validReadabilityScore);
    console.log('Image optimization score: ', validImageOptimizationScore);

    const totalScore = validMetaScore + validHeadingsScore + validAltScore + validReadabilityScore + validImageOptimizationScore;
    const finalScore = isNaN(totalScore) ? 0 : Math.round(totalScore);

    console.log('Total SEO score: ', finalScore, '/ 100');
    document.getElementById('SEOLITE-score').textContent = finalScore;
}

document.addEventListener('DOMContentLoaded', calculateSEOTotalScore);
