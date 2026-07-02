let copyButton = document.querySelectorAll("[data-copyboard='true']");

copyButton.forEach(function (e) {
    e.addEventListener("click", function () {
        let textToCopy = e.getAttribute("data-copyboard-text");

        // Create temp element for copy
        let tempInput = document.createElement("input");
        tempInput.setAttribute("value", textToCopy);
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        let tooltip = new bootstrap.Tooltip(e);
        tooltip.show();

        // Hide tooltip for 3 seconds
        setTimeout(function () {
            tooltip.hide();
        }, 2000);
    })

    e.addEventListener("mouseover", function () {
        let tooltip = bootstrap.Tooltip.getInstance(e);
        if (tooltip) {
            tooltip.hide();
        }
    });
});
