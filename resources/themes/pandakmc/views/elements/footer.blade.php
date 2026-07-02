<div>
    <img src="{{theme_asset("/images/pandarender.webp")}}" alt="Illustration d'un panda" class="footer__panda">
    <div class="footer__content bg-body-secondary py-3">
        <div class="container d-flex justify-content-between align-items-center flex-column flex-md-row px-md-8 px-lg-0">
            <div class="order-2 order-md-0 text-center text-md-start">
                <p data-bs-toggle="tooltip" title="{!!  setting('copyright') ?? "<b>PandakMC</b> - Nous ne sommes pas affiliés à Mojang" !!}. Thème crée par Dixept.fr et propulsé par Azuriom.com" class="d-inline-block w-fit mb-2 md-0"><b>PandakMC</b> - {!!  setting('copyright') ?? "Nous ne sommes pas affiliés à Mojang" !!}</p>
                <ul class="list-unstyled d-flex gap-2 align-items-center justify-content-center justify-content-md-start mb-0">
                    <li><a href="{{ theme_config("footer.index.links.1.url") ?? "/cgu" }}" class="text-sm"></a>{{ theme_config("footer.index.links.1.text") ?? "CGU" }}</li>
                    <li>/ <a href="{{ theme_config("footer.index.links.2.url") ?? "/cgv" }}" class="text-sm"></a>{{ theme_config("footer.index.links.2.text") ?? "CGV" }}</li>
                    <li>- <a href="{{ theme_config("footer.index.links.3.url") ?? "/mentions-legales" }}" class="text-sm"></a>{{ theme_config("footer.index.links.3.text") ?? "Mentions Légales" }}</li>
                </ul>
            </div>
            <div class="order-1 footer__img">
                <img src="{{ site_logo() }}" alt="Logo de {{ site_name() }}" height="120">
            </div>
        </div>
    </div>
</div>
