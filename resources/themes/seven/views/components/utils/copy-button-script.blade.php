<script type="text/javascript">
    let copyButton = document.querySelectorAll(".copyButton");

    console.log(copyButton)
    copyButton.forEach(function(e) {
        e.addEventListener("click", function() {
            let textToCopy = '{!! theme_config('settings.server.ip') ?? 'serveurliste.fr' !!}';

            // Création d'un élément temporaire pour la copie du texte
            let tempInput = document.createElement("input");
            tempInput.setAttribute("value", textToCopy);
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            let tooltip = new bootstrap.Tooltip(e);
            tooltip.show();

            // Masquer le tooltip après 3 secondes
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
</script>
