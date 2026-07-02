<!-- TESTIMONIAL SECTION START -->
<section class="pt90 pb170"  style="font-size-adjust: {{theme_config('avis.index.fontSize') != 0 ?  theme_config('avis.index.fontSize'):"unset"}};">
    <div class="container">
        @if(theme_config('avis.index.players'))
            <div class="row">
                <div class="title-bl text-center wow fadeIn" data-wow-duration="2s">
                    <div class="title color-white">
                        {{theme_config('avis.index.title') ?? "Avis"}}
                    </div>
                    <div class="subtitle">
                        {{theme_config('avis.index.title') ?? "Avis"}}
                    </div>
                </div>
                <div class="testimonial-slider testimonial-tpl mt100">
                        @foreach(theme_config('avis.index.players') as $player)
                            @if($player['name'])
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 px-3">
                                    <div class="slide-item">
                                        <div class="author-img">
                                            <img src="{{ "https://mc-heads.net/head/".$player['name'] }}" alt="Avatar de l'auteur" width="90" height="90" class="rounded-pill">
                                        </div>
                                        <div class="text-center">
                                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                                            <div class="fsize-24 fweight-700 color-white font-agency uppercase">
                                                {{ $player['name'] }}
                                            </div>
                                            <div class="color-1 fsize-14 fweight-700 uppercase">
                                                {{ $player['tag'] }}
                                            </div>
                                            <div class="fsize-20 italic mt40">
                                                «{{ $player['text'] }}»
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
<!-- TESTIMONIAL SECTION END -->
