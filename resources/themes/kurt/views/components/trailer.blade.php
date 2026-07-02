@if(theme_config('home.video.trailer.off') !== 'on')
        <section class="container">
            <h2 class="fw-bold mb-3">{{theme_config('home.video.title') ?? "Lorem ipsum dolor sit amet."}}</h2>
            <p class="mb-5 col-lg-6">
                {{theme_config('home.video.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur ducimus earum enim
                           exercitationem
                           iure labore optio quis rerum sapiente ut?"}}
            </p>
            <div class="trailer overflow-hidden">
                <iframe class="w-100 rounded-5" height="563" src="{{theme_config('home.video.url') ?? "https://www.youtube.com/embed/sOE98frT3Uk?si=Xd-Io8SuMz6RN4Wy"}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </section>
@endif
