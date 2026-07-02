document.addEventListener('DOMContentLoaded', function () {
    updateCounters();
});

function updateCounters() {
    const replacements = {};

    // Only add replacements if values exist
    if (window.THEME.server_online !== undefined) {
        replacements['{server_online}'] = window.THEME.server_online;
    }
    if (window.THEME.discord_online !== undefined) {
        replacements['{discord_online}'] = window.THEME.discord_online;
    }

    // Get all elements with data-editable="true"
    const editableElements = document.querySelectorAll('[data-editable="true"]');

    // Process each editable element
    editableElements.forEach(element => {
        let html = element.innerHTML;
        let hasChanges = false;

        // Check and replace each pattern
        Object.entries(replacements).forEach(([search, replace]) => {
            if (html.includes(search)) {
                html = html.replaceAll(search, replace);
                hasChanges = true;
            }
        });

        // Only update the element if changes were made
        if (hasChanges) {
            element.innerHTML = html;
        }
    });
}