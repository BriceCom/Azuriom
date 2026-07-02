// Consts
const OFFCANVAS_keywords_id = "SEOLITE_keywords"
const OFFCANVAS_keywords_trigger = getElements(`#${OFFCANVAS_keywords_id}--trigger`)
const OFFCANVAS_keywords = getElements(`#${OFFCANVAS_keywords_id}`)


function calculateKeywordDensity(keyword, text) {
    if (!keyword || !text) {
        return {
            density: 0,
            keywordCount: 0,
            totalWords: 0,
            percentage: 0
        };
    }

    const cleanText = text.replace(/[^\p{L}\p{N}\s]/gu, ' ').replace(/\s+/g, ' ').trim();
    const cleanKeyword = keyword.trim();

    const words = cleanText.toLowerCase().split(' ').filter(word => word.length > 0);
    const totalWords = words.length;

    // Create case-insensitive search with plural variations
    const escapedKeyword = cleanKeyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

    // Create multiple search patterns for better matching
    const searchPatterns = [
        escapedKeyword, // Exact match
        escapedKeyword + 's', // Plural with 's'
        escapedKeyword + 'es', // Plural with 'es'
    ];

    // If keyword ends with 's', also search without 's' (singular form)
    if (cleanKeyword.toLowerCase().endsWith('s') && cleanKeyword.length > 1) {
        const singularForm = cleanKeyword.slice(0, -1);
        const escapedSingular = singularForm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        searchPatterns.push(escapedSingular);
    }

    // If keyword ends with 'es', also search without 'es' (singular form)
    if (cleanKeyword.toLowerCase().endsWith('es') && cleanKeyword.length > 2) {
        const singularForm = cleanKeyword.slice(0, -2);
        const escapedSingular = singularForm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        searchPatterns.push(escapedSingular);
    }

    // Count matches for all patterns (case-insensitive)
    let keywordCount = 0;
    const foundMatches = new Set(); // To avoid counting the same word position multiple times

    searchPatterns.forEach(pattern => {
        const keywordRegex = new RegExp(`\\b${pattern}\\b`, 'gui'); // 'i' flag for case-insensitive
        const matches = cleanText.match(keywordRegex) || [];

        // Add unique matches to avoid double counting
        let match;
        const regex = new RegExp(`\\b${pattern}\\b`, 'gui');
        while ((match = regex.exec(cleanText)) !== null) {
            const matchKey = `${match.index}-${match[0].length}`;
            if (!foundMatches.has(matchKey)) {
                foundMatches.add(matchKey);
                keywordCount++;
            }
        }
    });

    const percentage = totalWords > 0 ? (keywordCount / totalWords) * 100 : 0;

    return {
        density: percentage,
        keywordCount: keywordCount,
        totalWords: totalWords,
        percentage: Math.round(percentage * 100) / 100
    };
}

function getKeywordDensityDiagnostic(percentage) {
    let level, message, icon, progressClass;

    if (percentage < 0.5) {
        level = LEVEL.DANGER;
        message = trans('seolite::messages.keyword_under_optimized');
        icon = "❌";
        progressClass = "bg-danger";
    } else if (percentage >= 0.5 && percentage <= 2) {
        level = LEVEL.VERY_GOOD;
        message = trans('seolite::messages.keyword_optimal');
        icon = "✅";
        progressClass = "bg-success";
    } else if (percentage > 2 && percentage <= 3) {
        level = LEVEL.WARNING;
        message = trans('seolite::messages.keyword_slight_over_optimization');
        icon = "⚠️";
        progressClass = "bg-warning";
    } else {
        level = LEVEL.DANGER;
        message = trans('seolite::messages.keyword_over_optimized');
        icon = "🚨";
        progressClass = "bg-danger";
    }

    return {
        level: level,
        message: message,
        icon: icon,
        progressClass: progressClass
    };
}

// Update keyword analysis display
function updateKeywordAnalysisDisplay(keyword, analysis, contentLength = 0) {
    const resultsDiv = document.getElementById('SEOLITE_keyword_results');
    const placeholderDiv = document.getElementById('SEOLITE_keyword_placeholder');
    const densitySpan = document.getElementById('SEOLITE_keyword_density');
    const progressBar = document.getElementById('SEOLITE_keyword_progress');
    const diagnosticDiv = document.getElementById('SEOLITE_keyword_diagnostic');
    const keywordCountSpan = document.getElementById('SEOLITE_keyword_count');
    const totalWordsSpan = document.getElementById('SEOLITE_total_words');

    // Check if elements exist to prevent "Cannot read properties of null" error
    if (!resultsDiv) {
        console.error('SEOLITE_keyword_results element not found');
        return;
    }

    // If no analysis or empty analysis, hide results
    if (!analysis || analysis.totalWords === 0) {
        resultsDiv.classList.add('d-none');
        // Only try to modify placeholder if it exists
        if (placeholderDiv) {
            placeholderDiv.classList.remove('d-none');
        }
        return;
    }

    // Show results
    resultsDiv.classList.remove('d-none');

    // Hide placeholder if it exists
    if (placeholderDiv) {
        placeholderDiv.classList.add('d-none');
    }

    // Get diagnostic info
    const diagnostic = getKeywordDensityDiagnostic(analysis.percentage);

    // Update density display if element exists
    if (densitySpan) {
        densitySpan.textContent = `${analysis.percentage}%`;
        densitySpan.className = `badge fs-6 text-bg-${diagnostic.level}`;
    }

    // Update progress bar if element exists
    if (progressBar) {
        const progressWidth = Math.min(analysis.percentage * 10, 100); // Scale for visual representation
        progressBar.style.width = `${progressWidth}%`;
        progressBar.className = `progress-bar ${diagnostic.progressClass}`;
    }

    // Update diagnostic message if element exists
    if (diagnosticDiv) {
        diagnosticDiv.innerHTML = `
                    <div class="d-flex align-items-start gap-2">
                        <span class="fs-5">${diagnostic.icon}</span>
                        <div>
                            <div class="fw-semibold text-${diagnostic.level}">${diagnostic.message}</div>
                            <small class="text-muted">${trans('seolite::messages.keyword_analyzed')}: "${keyword}"</small>
                        </div>
                    </div>
                `;
    }

    // Update statistics if elements exist
    if (keywordCountSpan) {
        keywordCountSpan.textContent = analysis.keywordCount;
    }

    if (totalWordsSpan) {
        totalWordsSpan.textContent = analysis.totalWords;
    }
}


// Analyze keyword function
function analyzeKeyword() {
    const keywordInput = document.getElementById('SEOLITE_keyword_input');
    const keyword = keywordInput.value.trim();

    if (!keyword) {
        alert(trans('seolite::messages.please_enter_keyword'));
        return;
    }

    // Get page text content
    const pageText = getPageTextContent();

    if (!pageText) {
        alert(trans('seolite::messages.unable_to_analyze_content'));
        return;
    }

    // Calculate keyword density
    const analysis = calculateKeywordDensity(keyword, pageText);

    // Update display
    updateKeywordAnalysisDisplay(keyword, analysis, pageText.length);

    console.log(`${PREFIX} - Keyword Analysis:`, {
        keyword: keyword,
        analysis: analysis,
        pageTextLength: pageText.length
    });
}

// Initialize keyword analysis functionality
function initializeKeywordAnalysis() {
    const keywordInput = document.getElementById('SEOLITE_keyword_input');
    const analyzeButton = document.getElementById('SEOLITE_keyword_analyze');

    if (keywordInput && analyzeButton) {
        // Add event listeners
        analyzeButton.addEventListener('click', analyzeKeyword);

        // Allow Enter key to trigger analysis
        keywordInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                analyzeKeyword();
            }
        });

        // Real-time analysis on input (debounced)
        let debounceTimer;
        keywordInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const keyword = keywordInput.value.trim();
                if (keyword.length >= 2) {
                    analyzeKeyword();
                } else {
                    // Reset display if keyword is too short
                    updateKeywordAnalysisDisplay('', null);
                }
            }, 500);
        });

        console.log(`${PREFIX} - Keyword analysis initialized`);
    }
}

// Initialize keyword analysis when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Small delay to ensure all elements are rendered
    setTimeout(initializeKeywordAnalysis, 100);
});

// Trigger
triggerButtonPerElems({
        elm: OFFCANVAS_keywords_trigger,
        functions: () => {
            setTimeout(initializeKeywordAnalysis, 100);
        }
    }
)
