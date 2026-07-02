// Consts
const OFFCANVAS_recommendations_id = "SEOLITE_recommendations"
const OFFCANVAS_recommendations_trigger = getElements(`#${OFFCANVAS_recommendations_id}--trigger`)
const OFFCANVAS_recommendations = getElements(`#${OFFCANVAS_recommendations_id}`)

// Function to analyze and create recommendations
function createListOfRecommendations(list) {
    const recommendations = [];

    // 1. Analyze readability issues
    const readabilityIssues = analyzeReadabilityIssues();
    recommendations.push(...readabilityIssues);

    // 2. Analyze missing links
    const linkIssues = analyzeMissingLinks();
    recommendations.push(...linkIssues);

    // 3. Analyze defective heading structure
    const headingIssues = analyzeHeadingStructure();
    recommendations.push(...headingIssues);

    // 4. Analyze missing important meta tags
    const metaIssues = analyzeMissingMetaTags();
    recommendations.push(...metaIssues);

    // 5. Analyze information-type recommendations
    const infoIssues = analyzeInformationRecommendations();
    recommendations.push(...infoIssues);

    // Sort recommendations by severity: High > Medium > Low > Info
    const severityOrder = { 'high': 1, 'medium': 2, 'low': 3, 'info': 4 };
    recommendations.sort((a, b) => {
        return (severityOrder[a.severity] || 5) - (severityOrder[b.severity] || 5);
    });

    // Create recommendation items
    recommendations.forEach(recommendation => {
        const li = document.createElement('li');
        li.classList.add('mb-3', 'p-3', 'border', 'rounded', 'shadow-sm');
        li.classList.add(recommendation.severity === 'high' ? 'border-danger' :
            recommendation.severity === 'medium' ? 'border-warning' :
                recommendation.severity === 'low' ? 'border-info' : 'border-secondary');

        const header = document.createElement('div');
        header.classList.add('d-flex', 'align-items-center', 'justify-content-between', 'mb-2');

        const title = document.createElement('p');
        title.classList.add('mb-0', 'fw-semibold');
        title.innerText = recommendation.title;

        const badge = document.createElement('span');
        badge.classList.add('badge',
            recommendation.severity === 'high' ? 'text-bg-danger' :
                recommendation.severity === 'medium' ? 'text-bg-warning' :
                    recommendation.severity === 'low' ? 'text-bg-info' : 'text-bg-secondary');
        badge.innerText = recommendation.severity.toUpperCase();

        header.appendChild(title);
        header.appendChild(badge);

        const description = document.createElement('p');
        description.classList.add('mb-0', 'text-muted', 'small');
        description.innerHTML = recommendation.description;

        li.appendChild(header);
        li.appendChild(description);

        list[0].appendChild(li);
    });
}

// Analyze readability issues
function analyzeReadabilityIssues() {
    const issues = [];
    const pageText = getPageTextContent();
    const fleschScore = scoreFlesch(pageText);

    // Provide readability recommendations based on Flesch score with "Low" severity
    if (fleschScore.score < 20) {
        issues.push({
            title: trans('seolite::messages.very_difficult_to_read'),
            description: trans('seolite::messages.very_difficult_to_read_desc', { score: fleschScore.score.toFixed(1) }),
            severity: 'low'
        });
    } else if (fleschScore.score < 40) {
        issues.push({
            title: trans('seolite::messages.difficult_to_read'),
            description: trans('seolite::messages.difficult_to_read_desc', { score: fleschScore.score.toFixed(1) }),
            severity: 'low'
        });
    } else if (fleschScore.score < 60) {
        issues.push({
            title: trans('seolite::messages.standard_readability_improvements'),
            description: trans('seolite::messages.standard_readability_improvements_desc', { score: fleschScore.score.toFixed(1) }),
            severity: 'low'
        });
    }

    // Check for very long sentences
    const sentences = pageText.split(/[.!?]+/).filter(s => s.trim().length > 0);
    const longSentences = sentences.filter(s => s.split(' ').length > 25);
    if (longSentences.length > 0) {
        issues.push({
            title: trans('seolite::messages.long_sentences_detected'),
            description: trans('seolite::messages.long_sentences_detected_desc', { count: longSentences.length }),
            severity: 'low'
        });
    }

    // Check headings readability
    const headings = getTitles();
    const poorHeadings = headings.filter(h => scoreFlesch(h.text).score < 60);
    if (poorHeadings.length > 0) {
        issues.push({
            title: trans('seolite::messages.complex_headings_detected'),
            description: trans('seolite::messages.complex_headings_detected_desc', { count: poorHeadings.length }),
            severity: 'low'
        });
    }

    // Check paragraph length
    const paragraphs = pageText.split(/\n\s*\n/).filter(p => p.trim().length > 0);
    const longParagraphs = paragraphs.filter(p => p.split(' ').length > 150);
    if (longParagraphs.length > 0) {
        issues.push({
            title: trans('seolite::messages.paragraphs_too_long'),
            description: trans('seolite::messages.paragraphs_too_long_desc', { count: longParagraphs.length }),
            severity: 'low'
        });
    }

    return issues;
}

// Analyze missing links
function analyzeMissingLinks() {
    const issues = [];
    const links = document.querySelectorAll('a[href]');
    const internalLinks = Array.from(links).filter(link =>
        link.href.includes(window.location.hostname) || link.href.startsWith('/')
    );
    const externalLinks = Array.from(links).filter(link =>
        !link.href.includes(window.location.hostname) && !link.href.startsWith('/')
    );

    if (internalLinks < 3) {
        issues.push({
            title: trans('seolite::messages.insufficient_internal_linking'),
            description: trans('seolite::messages.insufficient_internal_linking_desc'),
            severity: 'medium'
        });
    }

    if (externalLinks.length === 0) {
        issues.push({
            title: trans('seolite::messages.no_external_links'),
            description: trans('seolite::messages.no_external_links_desc'),
            severity: 'low'
        });
    }

    return issues;
}

// Analyze heading structure
function analyzeHeadingStructure() {
    const issues = [];
    const h1s = getElements('h1');
    const h2s = getElements('h2');
    const headings = getTitles();

    // Check H1 issues
    if (h1s.length === 0) {
        issues.push({
            title: trans('seolite::messages.missing_h1_tag'),
            description: trans('seolite::messages.missing_h1_tag_desc'),
            severity: 'high' // Hard importance
        });
    } else if (h1s.length > 1) {
        issues.push({
            title: trans('seolite::messages.multiple_h1_tags'),
            description: trans('seolite::messages.multiple_h1_tags_desc'),
            severity: 'medium' // Medium importance
        });
    }

    // Check H1 length (50-80 perfect, outside = warning)
    if (h1s.length === 1) {
        const h1Length = countCharacters(h1s[0].innerText);
        if (h1Length < 50 || h1Length > 80) {
            issues.push({
                title: trans('seolite::messages.h1_length_issue'),
                description: `H1 has ${h1Length} characters. Perfect length is 50-80 characters for better SEO.`,
                severity: 'medium' // Medium importance
            });
        }
    }

    // Check heading hierarchy
    let previousLevel = 0;
    let hierarchyIssues = 0;
    headings.forEach(heading => {
        if (heading.level > previousLevel + 1) {
            hierarchyIssues++;
        }
        previousLevel = heading.level;
    });

    if (hierarchyIssues > 0) {
        issues.push({
            title: trans('seolite::messages.broken_heading_hierarchy'),
            description: trans('seolite::messages.broken_heading_hierarchy_desc'),
            severity: 'medium'
        });
    }

    return issues;
}

// Analyze missing meta tags
function analyzeMissingMetaTags() {
    const issues = [];

    // Check title tag
    const titleTag = document.querySelector('title');
    if (!titleTag || !titleTag.textContent.trim()) {
        issues.push({
            title: trans('seolite::messages.missing_title_tag'),
            description: trans('seolite::messages.missing_title_tag_desc'),
            severity: 'high'
        });
    } else {
        const titleLength = countCharacters(titleTag.textContent);
        if (titleLength < 30) {
            issues.push({
                title: trans('seolite::messages.title_too_short'),
                description: `Title has ${titleLength} characters. Too short, should be at least 30 characters. Ideal: 50-60 characters.`,
                severity: 'high' // Hard → Impact direct sur le CTR et le ranking
            });
        } else if (titleLength > 60) {
            issues.push({
                title: trans('seolite::messages.title_too_long'),
                description: `Title has ${titleLength} characters. Too long, will be truncated in search results. Ideal: 50-60 characters.`,
                severity: 'high' // Hard → Impact direct sur le CTR et le ranking
            });
        } else if (titleLength < 50) {
            issues.push({
                title: trans('seolite::messages.title_could_be_longer'),
                description: `Title has ${titleLength} characters. Consider expanding to 50-60 characters for better optimization.`,
                severity: 'medium'
            });
        }
    }

    // Check meta description
    const metaDesc = document.querySelector('meta[name="description"]');
    if (!metaDesc || !metaDesc.content.trim()) {
        issues.push({
            title: trans('seolite::messages.missing_meta_description'),
            description: trans('seolite::messages.missing_meta_description_desc'),
            severity: 'high'
        });
    } else {
        const descLength = countCharacters(metaDesc.content);
        if (descLength < 100) {
            issues.push({
                title: trans('seolite::messages.meta_description_too_short'),
                description: `Meta description has ${descLength} characters. Too vague, should be at least 100 characters. Ideal: 120-160 characters.`,
                severity: 'medium' // Medium → Influence le taux de clic
            });
        } else if (descLength > 160) {
            issues.push({
                title: trans('seolite::messages.meta_description_too_long'),
                description: `Meta description has ${descLength} characters. Will be truncated in search results. Ideal: 120-160 characters.`,
                severity: 'medium' // Medium → Influence le taux de clic
            });
        } else if (descLength < 120) {
            issues.push({
                title: trans('seolite::messages.meta_description_could_be_longer'),
                description: `Meta description has ${descLength} characters. Consider expanding to 120-160 characters for better engagement.`,
                severity: 'low'
            });
        }
    }

    // Check Open Graph tags
    const ogTitle = document.querySelector('meta[property="og:title"]');
    const ogDesc = document.querySelector('meta[property="og:description"]');
    const ogImage = document.querySelector('meta[property="og:image"]');

    if (!ogTitle || !ogDesc || !ogImage) {
        issues.push({
            title: trans('seolite::messages.missing_open_graph_tags'),
            description: trans('seolite::messages.missing_open_graph_tags_desc'),
            severity: 'low'
        });
    }

    // Check canonical URL
    const canonical = document.querySelector('link[rel="canonical"]');
    if (!canonical) {
        issues.push({
            title: trans('seolite::messages.missing_canonical_url'),
            description: trans('seolite::messages.missing_canonical_url_desc'),
            severity: 'medium'
        });
    }

    return issues;
}

function analyzeInformationRecommendations() {
    const issues = [];

    issues.push({
        title: trans('seolite::messages.register_server_voting_sites'),
        description: trans('seolite::messages.register_server_voting_sites_desc'),
        severity: 'info'
    });

    issues.push({
        title: trans('seolite::messages.fill_alt_tags'),
        description: trans('seolite::messages.fill_alt_tags_desc'),
        severity: 'info'
    });

    issues.push({
        title: trans('seolite::messages.include_cta_meta'),
        description: trans('seolite::messages.include_cta_meta_desc'),
        severity: 'info'
    });

    issues.push({
        title: trans('seolite::messages.use_short_sentences'),
        description: trans('seolite::messages.use_short_sentences_desc'),
        severity: 'info'
    });

    issues.push({
        title: trans('seolite::messages.mobile_responsive_check'),
        description: trans('seolite::messages.mobile_responsive_desc'),
        severity: 'info'
    });

    issues.push({
        title: trans('seolite::messages.optimize_images_webp'),
        description: trans('seolite::messages.optimize_images_webp_desc'),
        severity: 'info'
    });

    issues.push({
        title: trans('seolite::messages.regular_content_updates'),
        description: trans('seolite::messages.regular_content_updates_desc'),
        severity: 'info'
    });

    issues.push({
        title: trans('seolite::messages.monitor_page_loading_speed'),
        description: trans('seolite::messages.monitor_page_loading_speed_desc'),
        severity: 'info'
    });

    return issues;
}

// Trigger
createModuleTrigger(OFFCANVAS_recommendations_trigger, 'SEOLITE_recommendations_placeholder', () => {
    createListOfRecommendations(OFFCANVAS_recommendations);
});
