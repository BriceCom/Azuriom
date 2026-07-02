<div class="position-absolute top-0 w-100 footer-background opacity-50" style="background: linear-gradient(180deg, rgba(14,13,19,1) 0%, rgba(255,255,255,0) 100%), url('{{ theme_config('footer.background') ? image_url((theme_config('footer.background')??"https://via.placeholder.com/2000x500")): image_url(setting('background')) }}') center / cover no-repeat;"></div>
<div class="container-fluid px-md-8 py-3 py-md-8 pb-md-4 row gap-4 gap-md-0 justify-content-center">
    <div class="col-md-3 d-flex flex-column align-items-center align-items-md-start flex-md-row gap-3 text-md-start">
        <div>
            <img class="object-fit-contain" src="{{site_logo()}}" alt="Logo de {{site_name()}}" height="100" width="100">
        </div>
        <div class="text-md-start text-center">
            <h2 class="h5">Statistiques</h2>
            <span class="d-block text-sm text-white-50">{{ theme_config('footer.stats.1') ?? "1450 inscrits sur la V1"}}</span>
            <span class="text-sm text-white-50">{{ theme_config('footer.stats.2') ?? "789 connectés"}}</span>
        </div>
    </div>
    <div class="col-md-6 text-center">
        <h2 class="h5">{{theme_config('footer.about.title') ?? "L'histoire de natifia"}}</h2>
        <p class="text-white-50 text-sm m-0">
            {{ theme_config('footer.about.paragraph') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. A architecto blanditiis dolor doloribus et eum nemo quam, sunt vel vero.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aspernatur dicta ducimus et itaque neque nesciunt nisi ratione totam vitae!" }}
        </p>
    </div>
    <div class="col-md-3 text-md-start text-center">
        <h2 class="h5 m-0">Réseaux sociaux</h2>
        <small class="opacity-50">Rejoins-nous pour être informé!</small>
        <ul class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 list-unstyled mt-2">
            @foreach(social_links() as $link)
                <li>
                    <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                       data-bs-toggle="tooltip"
                       class="d-inline-flex align-items-center justify-content-center p-2 border rounded-circle text-decoration-none" style="width: 40px; height: 40px">
                        <i class="{{ $link->icon }} text-white d-flex"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-4 px-md-8 mt-2 py-1 mt-md-0 text-center bg-dark bg-opacity-75">
    <p class="m-0 text-sm">{{ setting('copyright') }} | <span title="Version {{$version_theme['version']}}">{{trans('theme::theme.footer.copyright')}} <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
    <ul class="d-flex align-items-center gap-2 text-sm list-unstyled m-0">
        @if(theme_config('footer.important.links'))
            @foreach(theme_config('footer.important.links') as $link)
                @if($link['text'] != null)
                    <li><a class="text-sm text-decoration-none0" href="{{$link['url']}}" @if(isset($link['blank']) && $link['blank']) target="_blank" @endif rel="noopener">{{$link['text']}}</a></li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
