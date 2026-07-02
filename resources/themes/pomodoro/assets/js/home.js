document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-copy-server-ip="true"]').forEach(function (button) {
        button.addEventListener('click', function () {
            const textToCopy = button.getAttribute('data-copyboard-text');
            const tooltip = bootstrap.Tooltip.getOrCreateInstance(button);

            if (!textToCopy) {
                return;
            }

            const onCopied = function () {
                tooltip.show();
                setTimeout(function () {
                    tooltip.hide();
                }, 1500);
            };

            const fallbackCopy = function () {
                const area = document.createElement('textarea');
                area.value = textToCopy;
                area.style.position = 'fixed';
                area.style.opacity = '0';
                document.body.appendChild(area);
                area.focus();
                area.select();
                document.execCommand('copy');
                document.body.removeChild(area);
                onCopied();
            };

            if (!navigator.clipboard || typeof navigator.clipboard.writeText !== 'function') {
                fallbackCopy();
                return;
            }

            navigator.clipboard.writeText(textToCopy).then(onCopied).catch(fallbackCopy);
        });
    });
});
