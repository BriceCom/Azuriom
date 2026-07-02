@props([
    'title' => "Comment rejoindre KrustyMc",
    'content' => "Découvrez comment rejoindre notre serveur !",
    'reverse' => false
])

<div data-aos="fade-up" class="d-flex flex-column flex-xl-row @if(!$reverse) justify-content-between @endif gap-7">
    <div class="d-flex flex-column @if($reverse) order-2 @endif">
        @if($title)
            <hgroup class="mb-4">
                <h2 class="mb-2 text-uppercase">{{theme_config('home.join.title') ?? "Nous rejoindre"}}</h2>
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
        <img src="{{theme_asset('/images/bg_minecraft.webp')}}" alt="" class="img-fluid" draggable="false">

        <div class="position-absolute top-50 start-50 translate-middle">
            <span class="d-block mb-1 ff-quarterny text-xl mb-2 text-white">Adresse du serveur</span>

            <input type="text" class="form-control rounded-0 px-2 mb-3"
                   value="{{theme_config('settings.server.ip') ?? 'play.dixept.fr'}}" disabled/>

            @include('components.join-button', ['style' => 'secondary', 'content'=> "Copier l'ip !", "icon" => false])
        </div>
    </div>
</div>
