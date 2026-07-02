<div class="join w-fit bg-body-secondary d-flex flex-column flex-md-row align-items-center p-5 p-md-8 gap-6 rounded-2 mx-auto">
    <div>
        <p class="mb-2 text-lg text-light">{{theme_config('home.join.text') ?? "Disponible de la 1.8 à la 1.20 en version Java"}}</p>
        <h2 class="fw-bolder text-light mb-6">Rejoignez <span class="text-primary-gradient">
                    {{site_name()}}
                </span> <br>Aujourd'hui !</h2>

        @include('components.join-button')
    </div>
    <div>
        <img aria-hidden="true" src="{{theme_asset('images/island.webp')}}" alt="Ile du jeu Minecraft" height="266">
    </div>
</div>
