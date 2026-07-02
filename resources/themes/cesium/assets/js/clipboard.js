function copyClipboard() {

    document.getElementById('ip').select();
    document.getElementById('ip').setSelectionRange(0, 99999);
    document.execCommand("copy");
    navigator.clipboard.writeText(document.getElementById('ip').value);

}

document.getElementById("copy_ip").addEventListener("click", copyClipboard);

async function copyToClipboard(textToCopy) {
    // Navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        await navigator.clipboard.writeText(textToCopy);
    } else {

        const tempInput = document.createElement("input");
        tempInput.value = textToCopy;
        tempInput.style.position = "absolute";
        tempInput.style.left = "-999999px";

        document.body.prepend(tempInput);
        tempInput.select();

        try {
            document.execCommand('copy');
        } catch (error) {
            console.error(error);
        } finally {
            tempInput.remove();
        }
    }
}

let copyButton = document.querySelectorAll(".clipboard");

copyButton.forEach(function(e) {
    e.addEventListener("click", function() {
        let textToCopy = document.getElementById('ip').value;
        copyToClipboard(textToCopy);

        let tooltip = new bootstrap.Tooltip(e);
        tooltip.show();

        setTimeout(function() {
            tooltip.hide();
        }, 2000);
    })

    e.addEventListener("mouseover", function() {
        let tooltip = bootstrap.Tooltip.getInstance(e);
        if (tooltip) {
            tooltip.hide();
        }
    });
});
