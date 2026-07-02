@if(theme_config('home.video.trailer.off') !== 'on')
        <section class="container">
            <div class="overflow-hidden">
                <iframe class="w-100 rounded-5" height="563" src="{{theme_config('home.video.url') ?? "https://www.youtube.com/embed/sOE98frT3Uk?si=Xd-Io8SuMz6RN4Wy"}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </section>
@endif
