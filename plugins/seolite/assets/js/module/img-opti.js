// Consts
const OFFCANVAS_imageOptimization_id = "SEOLITE_imageOptimization"
const OFFCANVAS_imageOptimization_trigger = getElements(`#${OFFCANVAS_imageOptimization_id}--trigger`)
const OFFCANVAS_imageOptimization = getElements(`#${OFFCANVAS_imageOptimization_id}`)

// Cache for analysis results to prevent score changes on repeated accordion openings
let cachedImageAnalysis = null;

// Function to get image format from src
function getImageFormat(src) {
    if (!src) return 'unknown';

    try {
        // Extract file extension from URL (handle query parameters) - Compatible approach
        let pathname = src.toLowerCase();

        // Remove query parameters and fragments
        const queryIndex = pathname.indexOf('?');
        if (queryIndex !== -1) {
            pathname = pathname.substring(0, queryIndex);
        }
        const fragmentIndex = pathname.indexOf('#');
        if (fragmentIndex !== -1) {
            pathname = pathname.substring(0, fragmentIndex);
        }

        // Extract extension
        const extension = pathname.split('.').pop();

        // Map extensions to formats
        const formatMap = {
            'webp': 'webp',
            'jpg': 'jpeg',
            'jpeg': 'jpeg',
            'png': 'png',
            'gif': 'gif',
            'svg': 'svg',
            'bmp': 'bmp',
            'tiff': 'tiff',
            'tif': 'tiff',
            'ico': 'ico'
        };

        return formatMap[extension] || 'unknown';
    } catch (error) {
        console.warn('Error parsing image format:', error);
        return 'unknown';
    }
}

// Function to analyze image optimization
function analyzeImageOptimization(images) {
    let webpCount = 0;
    let otherCount = 0;
    const imageAnalysis = [];

    images.forEach(img => {
        const format = getImageFormat(img.src);
        const isWebP = format === 'webp';

        if (isWebP) {
            webpCount++;
        } else {
            otherCount++;
        }

        imageAnalysis.push({
            element: img,
            src: img.src,
            format: format,
            isWebP: isWebP,
            alt: img.alt || '',
            size: img.naturalWidth && img.naturalHeight ? `${img.naturalWidth}x${img.naturalHeight}` : 'Unknown'
        });
    });

    const totalImages = images.length;
    const optimizationPercentage = totalImages > 0 ? Math.round((webpCount / totalImages) * 100) : 0;

    return {
        webpCount,
        otherCount,
        totalImages,
        optimizationPercentage,
        imageAnalysis
    };
}

// Function to create image optimization list
function createListOfImageOptimization(list, images) {
    // Use cached analysis if available to prevent score changes on accordion reopening
    if (cachedImageAnalysis === null) {
        cachedImageAnalysis = analyzeImageOptimization(images);
    }
    const analysis = cachedImageAnalysis;

    // Update summary
    document.getElementById('SEOLITE_webp_count').textContent = analysis.webpCount;
    document.getElementById('SEOLITE_other_count').textContent = analysis.otherCount;
    document.getElementById('SEOLITE_optimization_percentage').textContent = `${analysis.optimizationPercentage}%`;

    // Show summary
    document.getElementById('SEOLITE_imageOptimization_summary').classList.remove('d-none');

    // Create list items for each image
    analysis.imageAnalysis.forEach(imageData => {
        const ID = setRandomId();

        const li = document.createElement('li');
        li.setAttribute(DATA_SEO_ATTR, ID);
        li.classList.add('mb-3', 'p-3', 'border', 'rounded', 'shadow-sm');

        // Header with image info
        const headerDiv = document.createElement('div');
        headerDiv.classList.add('d-flex', 'align-items-start', 'gap-2', 'mb-2');

        // Thumbnail
        const thumbnail = document.createElement('img');
        thumbnail.src = imageData.src;
        thumbnail.classList.add('rounded');
        thumbnail.style.width = '40px';
        thumbnail.style.height = '40px';
        thumbnail.style.objectFit = 'cover';
        thumbnail.onerror = function() {
            this.style.display = 'none';
        };

        const infoText = document.createElement('div');
        infoText.classList.add('col-5');
        infoText.innerHTML = `
                    <div class="fw-semibold small text-truncate">${imageData.src.split('/').pop() || 'Unknown'}</div>
                    <div class="text-muted small">${imageData.size}</div>
                `;

        // Format badge
        const formatBadge = document.createElement('span');
        formatBadge.classList.add('badge', imageData.isWebP ? 'bg-success' : 'bg-warning', 'small', 'ms-auto');
        formatBadge.innerHTML = `<i class="bi bi-image me-1"></i>${imageData.format.toUpperCase()}`;

        headerDiv.appendChild(thumbnail);
        headerDiv.appendChild(infoText);
        headerDiv.appendChild(formatBadge);


        // Message
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('small', 'mt-2');

        if (imageData.isWebP) {
            messageDiv.innerHTML = `<i class="bi bi-check-circle text-success me-1"></i>${trans('seolite::messages.optimized_webp_format')}`;
            messageDiv.classList.add('text-success');
        } else {
            messageDiv.innerHTML = `<i class="bi bi-exclamation-triangle text-warning me-1"></i>${trans('seolite::messages.not_optimized_webp')}`;
            messageDiv.classList.add('text-warning');
        }

        li.appendChild(headerDiv);
        li.appendChild(messageDiv);

        // Click to highlight image
        addHighlightClickHandler(li, imageData.element);

        list[0].appendChild(li);
    });

    // Update score
    calculateImageOptimizationScore(analysis);
}

// Function to calculate image optimization score (20 points max)
function calculateImageOptimizationScore(analysis) {
    const score = {
        total: Math.round((analysis.optimizationPercentage / 100) * 20),
        max: 20
    };

    // Use utility function to update score display
    updateScoreDisplay(OFFCANVAS_imageOptimization_id, score);

    return score;
}

// Helper: collect background-image URLs as image-like entries
function getBackgroundImageEntries() {
    const entries = [];
    const elements = document.querySelectorAll('body:not(#seoliteOffcanvas) *');
    elements.forEach(el => {
        const style = window.getComputedStyle(el);
        const bg = style.getPropertyValue('background-image');
        if (bg && bg !== 'none') {
            const match = bg.match(/url\(["']?(.*?)["']?\)/i);
            if (match && match[1]) {
                const src = match[1];
                // Ignore data URIs to avoid noise
                if (!src.startsWith('data:')) {
                    entries.push({ element: el, src: src, alt: '', naturalWidth: null, naturalHeight: null });
                }
            }
        }
    });
    return entries;
}

// Trigger image optimization analysis
createModuleTrigger(OFFCANVAS_imageOptimization_trigger, 'SEOLITE_imageOptimization_placeholder', () => {
    // Build combined list: <img> tags + CSS background images
    const imgTagEntries = Array.from(imgElems).map(img => img);
    const bgEntries = getBackgroundImageEntries();

    // Merge, while avoiding duplicates by src
    const bySrc = new Map();
    imgTagEntries.forEach(it => { if (it && it.src) bySrc.set(it.src, it); });
    bgEntries.forEach(be => { if (be && be.src && !bySrc.has(be.src)) bySrc.set(be.src, be); });

    const combined = Array.from(bySrc.values());
    createListOfImageOptimization(OFFCANVAS_imageOptimization, combined);
});
