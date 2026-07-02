@props([
    'title' => false,
    'content' => null,
    'reverse' => false
])

<div class="d-flex flex-column flex-xl-row @if(!$reverse) justify-content-between @endif gap-7">
    <div class="d-flex flex-column @if($reverse) order-2 @endif">
        @if($title)
            <hgroup class="mb-4">
                <h2 class="mb-2 text-uppercase">{{theme_config('home.join.title') ?? "Rejoindre Hyvers"}}</h2>
                @if(theme_config('home.join.text'))
                    <p>{{theme_config('home.join.text')}}</p>
                @endif
            </hgroup>
        @endif

        @if($content)
            {!! $content !!}
        @endif
    </div>

    <div class="w-fit position-relative join-image">
        <img src="{{theme_asset('/images/bg_minecraft.webp')}}" alt="" class="img-fluid">

        <div class="position-absolute top-50 start-50 translate-middle">
            <div>
                <span class="d-block mb-1 ff-quarterny text-xl mb-1">Adresse du serveur</span>
                <p id="serverIp" type="text"
                   class="typewriter ff-quarterny bg-dark border border-white ps-2 py-1 mb-4 text-xl text-white"
                   data-value="{{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}" data-animate="input-ip"></p>
            </div>

            @include('components.join-button', ['style' => 'secondary', 'content'=> "Copier l'ip !", "icon" => false])
        </div>
    </div>
</div>
