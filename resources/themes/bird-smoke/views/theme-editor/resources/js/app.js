(() => {
    const normalizeButtonVariant = (value, fallback = 'primary') => {
        const allowed = new Set(['server', 'primary', 'secondary', 'tertiary', 'quaternary']);
        return allowed.has(String(value || '').trim()) ? String(value).trim() : fallback;
    };

    const normalizeTextKey = (value) => String(value || '')
        .normalize('NFKD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/\s+/g, ' ')
        .trim()
        .toLowerCase();

    const applyHeaderButtonStyles = () => {
        const headerShell = document.querySelector('[data-te-node="layout-header-shell"]');
        if (!(headerShell instanceof HTMLElement)) {
            return;
        }

        let rules = [];
        try {
            const rawRules = headerShell.getAttribute('data-te-header-button-rules') || '[]';
            const parsed = JSON.parse(rawRules);
            if (Array.isArray(parsed)) {
                rules = parsed.filter((item) => item && typeof item === 'object');
            }
        } catch (error) {
            rules = [];
        }

        const serverAddress = String(headerShell.getAttribute('data-te-server-address') || '').trim();
        const links = Array.from(headerShell.querySelectorAll('.navbar .navbar-nav.me-auto .nav-item > a'));
        const variantClassByType = {
            primary: 'btn-primary',
            secondary: 'btn-secondary',
            tertiary: 'btn-tertiary',
            quaternary: 'btn-quaternary',
            server: 'btn-server',
        };

        links.forEach((link) => {
            if (!(link instanceof HTMLAnchorElement)) {
                return;
            }

            const originalText = String(link.dataset.teOriginalText || link.textContent || '').trim();
            if (!link.dataset.teOriginalText) {
                link.dataset.teOriginalText = originalText;
            }
            if (!link.dataset.teOriginalHref) {
                link.dataset.teOriginalHref = link.getAttribute('href') || '#';
            }
            if (!link.dataset.teOriginalClass) {
                link.dataset.teOriginalClass = link.className;
            }

            const originalHref = String(link.dataset.teOriginalHref || '#');
            const originalClass = String(link.dataset.teOriginalClass || '');
            const match = rules.find((rule) => {
                const normalizedLabel = normalizeTextKey(rule.label);
                const normalizedOriginalText = normalizeTextKey(originalText);
                return normalizedLabel.length > 0 && (
                    normalizedLabel === normalizedOriginalText
                    || normalizedOriginalText.includes(normalizedLabel)
                );
            }) || null;

            link.className = originalClass;
            link.classList.remove('btn', 'btn-primary', 'btn-secondary', 'btn-tertiary', 'btn-quaternary', 'btn-server');
            link.textContent = originalText;
            link.setAttribute('href', originalHref);
            link.removeAttribute('data-copyboard');
            link.removeAttribute('data-copyboard-text');
            link.removeAttribute('data-bs-toggle');
            link.removeAttribute('data-bs-title');

            if (!match) {
                return;
            }

            const variant = normalizeButtonVariant(match.variant, 'primary');
            link.classList.remove('nav-link');
            link.classList.add('btn', variantClassByType[variant] || 'btn-primary');

            if (variant === 'server') {
                link.textContent = serverAddress || 'Serveur indisponible';
                link.setAttribute('href', '#');
                link.setAttribute('data-copyboard', 'true');
                link.setAttribute('data-copyboard-text', serverAddress);
                link.setAttribute('data-bs-toggle', 'tooltip');
                link.setAttribute('data-bs-title', 'Copié !');
            }
        });

        if (typeof window.initCopyboard === 'function') {
            window.initCopyboard();
        }
    };

    const initAos = () => {
        if (!window.AOS || typeof window.AOS.init !== 'function') {
            return;
        }

        window.AOS.init({
            duration: 650,
            once: true,
            offset: 40,
            easing: 'ease-out-cubic',
        });
    };

    const boot = () => {
        if (typeof window.initBackgroundParticles === 'function') {
            window.initBackgroundParticles();
        }

        applyHeaderButtonStyles();
        initAos();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }
})();
