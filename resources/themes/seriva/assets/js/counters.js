document.addEventListener('DOMContentLoaded', updateCounters);

function updateCounters() {
    if (!window.THEME) return;

    const stats = {
        discord: window.THEME.discord_online,
        server: window.THEME.server_online
    };

    document.querySelectorAll('[data-count]').forEach(element => {
        const type = element.getAttribute('data-count');
        const value = stats[type];

        if (value !== undefined) {
            element.textContent = value;
        }
    });

    const replacements = {};
    if (stats.server !== undefined) replacements['{server_online}'] = stats.server;
    if (stats.discord !== undefined) replacements['{discord_online}'] = stats.discord;

    const editableElements = document.querySelectorAll('[data-editable="true"]');

    if (Object.keys(replacements).length === 0 || editableElements.length === 0) return;

    editableElements.forEach(element => {
        let html = element.innerHTML;
        let hasChanges = false;

        for (const [key, value] of Object.entries(replacements)) {
            if (html.includes(key)) {
                html = html.replaceAll(key, value);
                hasChanges = true;
            }
        }

        if (hasChanges) {
            element.innerHTML = html;
        }
    });
}
