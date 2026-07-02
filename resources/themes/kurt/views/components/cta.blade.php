@if(theme_config('home.cta.off') !== 'on')
    <section class="container">
        <div class="row gx-5 gy-4">
            <div class="col-lg-5">
                <div class="overflow-hidden rounded-4">
                    <img
                        src="{{theme_config('home.cta.img') ? image_url(theme_config('home.cta.img')) : 'https://placehold.co/600x400'}}"
                        alt="" class=" rounded-4" height="331">
                </div>
            </div>
            <div class="col-lg-6" data-editable="true">
                <h2 class="fw-bold mb-2">{{theme_config('home.cta.title') ?? "Lorem ipsum dolor sit amet."}}</h2>
                @if(theme_config('home.cta.text'))
                    <div>
                        {!!theme_config('home.cta.text')!!}
                    </div>
                @else
                    <p>Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum
                        is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing and typesetting industry. m
                        Ipsum is simpm Ipsum is sm Ipsum is simp</p>
                @endif
                @if(theme_config('home.cta.link.text'))
                    <a href="{{theme_config('home.cta.link.url')}}"
                       class="btn btn-primary">{{theme_config('home.cta.link.text')}}</a>
                @else
                    <a href="#" class="btn btn-primary">SHOP NOW</a>
                @endif
            </div>
        </div>
    </section>
@endif
