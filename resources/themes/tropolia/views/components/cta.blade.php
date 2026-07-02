@if(theme_config('home.cta.off') !== 'on')
<section class="container">
            <div class="row gx-4.5 gy-4" data-aos="fade-up" data-aos-delay="0">
                <div class="col-lg-5">
                    <div class="overflow-hidden rounded-4">
                        <img src="{{theme_config('home.cta.img') ? image_url(theme_config('home.cta.img')) : 'https://placehold.co/600x400'}}" alt="" class=" rounded-4" height="331" loading="lazy" draggable="false">
                    </div>
                </div>
                <div class="col-lg-6" data-editable="true">
                    <h2 class="fw-bold mb-1">{!! theme_config('home.cta.title') ?? "Lorem ipsum dolor sit amet."!!}</h2>
                    @if(theme_config('home.cta.text'))
                    <div class="opacity-75 mb-4  fw-light">
                        {{ theme_config('home.cta.text') }}
                    </div>
                    @else
                        <p class="opacity-75 mb-4 fw-light">Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simp</p>
                    @endif
                    @if(theme_config('home.cta.button.text'))
                        <a href="{{theme_config('home.cta.button.url')}}" class="btn btn-primary mt-4">

                            @if(theme_config('home.cta.button.icon'))
                                <i class="{{theme_config('home.cta.button.icon')}}"></i>
                            @endif

                            {{theme_config('home.cta.button.text')}}
                        </a>
                    @endif
                </div>
            </div>
        </section>
@endif
