<div class="howjoin d-flex flex-column align-items-center">
    <h2 class="text-uppercase text-center mb-4">Comment nous rejoindre ?</h2>

    <div class="howjoin__form d-flex flex-column justify-content-center align-items-center gap-4 gap-md-5 mt-5">
        <div class="mc-input">
            {!! theme_config('home.index.howjoin.title') ?? site_name() ." L’ere des samourai !" !!}
        </div>
        <div class="mc-input">
            {{theme_config('home.index.ip.text') ?? 'play.pandakmc.fr'}}
        </div>

        <button
            class="clipboard w-fit d-flex flex-row align-items-center cursor-pointer border-0 mb-0 p-0 rounded-3"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!"
            data-bs-trigger="manual"
        >
            <img src="{{theme_asset("/images/btn_minecraft.webp")}}" alt="Button minecraft copier l'ip">
        </button>

    </div>
</div>
