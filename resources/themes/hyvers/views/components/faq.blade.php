<div>
    <hgroup class="mb-5">
        <h2 class="text-uppercase text-2xl">{{theme_config('home.join.faq.title') ?? "Foire aux questions"}}</h2>
        @if(theme_config('home.join.faq.text'))
            <p class="mb-0">{{theme_config('home.join.faq.text')}}</p>
        @endif
    </hgroup>

    <div class="d-flex flex-column gap-1">
        @if(theme_config('home.join.faq.faqs'))
            @foreach(theme_config('home.join.faq.faqs') as $faq)
                <details class="w-100 h-auto btn btn-secondary flex-column align-items-start text-start gap-0">
                    <summary class="w-100 text-uppercase py-2.5">{{$faq['name']}}</summary>
                    <div class="mb-0 mt-3 text-sm pb-2">
                        {!! $faq['content'] !!}
                    </div>
                </details>
            @endforeach
        @else
            <details class="w-100 h-auto btn btn-secondary flex-column align-items-start text-start gap-0">
                <summary class="w-100 text-uppercase py-2.5">Comment remplir la FAQ ?</summary>
                <p class="mb-0 mt-3 text-sm pb-2">
                    Rendez-vous dans la configuration du thème > Accueil > Rejoindre
                </p>
            </details>
        @endif
    </div>
</div>
