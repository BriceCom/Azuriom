@if(theme_config('home.join.off') !== 'on')
    <section class="radial-gradient py-11">
        <div class="container d-flex flex-column gap-11">
            @include('components.join', ["title" =>  theme_config('home.join.title') ?? null, "content" =>  theme_config('home.join.content') ?? null])

            <div class="col-12 col-lg-7">
                @include('components.faq')
            </div>
        </div>
    </section>
@endif
