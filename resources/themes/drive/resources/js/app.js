document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const sidebarToggles = document.querySelectorAll('[data-drive-sidebar-toggle]');
    const sidebar = document.querySelector('.drive-sidebar');
    const overlay = document.querySelector('[data-drive-overlay]');
    const desktopQuery = window.matchMedia('(min-width: 992px)');

    const setOverlay = (visible) => {
        if (!overlay) return;

        if (visible) {
            overlay.removeAttribute('hidden');
        } else {
            overlay.setAttribute('hidden', 'hidden');
        }
    };

    const closeMobileSidebar = () => {
        body.classList.remove('drive-sidebar-open');
        setOverlay(false);
    };

    const applyLayoutMode = () => {
        if (desktopQuery.matches) {
            body.classList.add('drive-sidebar-collapsed');
            body.classList.remove('drive-sidebar-expanded-hover');
            closeMobileSidebar();
            return;
        }

        body.classList.remove('drive-sidebar-collapsed');
        body.classList.remove('drive-sidebar-expanded-hover');
    };

    const toggleSidebar = () => {
        if (desktopQuery.matches) return;

        const mobileOpen = !body.classList.contains('drive-sidebar-open');
        body.classList.toggle('drive-sidebar-open', mobileOpen);
        setOverlay(mobileOpen);
    };

    sidebarToggles.forEach((toggle) => {
        toggle.addEventListener('click', toggleSidebar);
    });

    overlay?.addEventListener('click', closeMobileSidebar);

    sidebar?.addEventListener('mouseenter', () => {
        if (desktopQuery.matches) {
            body.classList.add('drive-sidebar-expanded-hover');
        }
    });

    sidebar?.addEventListener('mouseleave', () => {
        body.classList.remove('drive-sidebar-expanded-hover');
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMobileSidebar();
            body.classList.remove('drive-sidebar-expanded-hover');
        }
    });

    if (desktopQuery.addEventListener) {
        desktopQuery.addEventListener('change', applyLayoutMode);
    } else {
        desktopQuery.addListener(applyLayoutMode);
    }

    applyLayoutMode();
});
