@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <section id="main-section" class="hero text-center d-flex align-items-center justify-content-center flex-column gap-4" style="--hero-img-height: {{theme_config('home.hero.image.height') ?? 50}}px;">
        @if(!theme_config('hero.server.toggle'))
            <div>
                <span class="server_count d-inline-block bg-tertiary rounded-pill py-2 px-4 fw-semibold text-tertiary">
                    @if($servers->where('home_display')->count() > 1)
                        @php($totalPlayers = 0)
                        @foreach($servers->where('home_display') as $server)
                            @php($totalPlayers += $server->getOnlinePlayers())
                        @endforeach
                    @endif
                    @if($servers->where('home_display')->count() > 0)
                        <span
                            class="server_count_span">{{$totalPlayers??$server->getOnlinePlayers()}}</span> {{theme_config('hero.server.text') ?? 'More than {online} players are online'}}
                    @endif
                </span>
            </div>
        @endif
        <div class="hero__content w-75">
            @if(theme_config('hero.text.title.toggle'))
                <h1 class="mx-auto">{{theme_config('hero.text.title')?? site_name().' website'}}</h1>
            @endif
            <p>{{theme_config('hero.text.text')?? 'Theme created by Dixept for Azuriom get this theme on Azuriom website'}}</p>
            @if(theme_config('home.hero.image.url'))
                <div class="hero__img {{theme_config('home.hero.image.full') ? 'full':""}}" style="--hero-img-margin: {{theme_config('home.hero.image.margin') ?? 0}}px;">
                    <img class="w-100 object-fit-contain" width="{{theme_config('home.hero.image.width') ?? 100}}"
                         src="{{theme_config('home.hero.image.url') ? image_url(theme_config('home.hero.image.url')):'https://azuriom.com/assets/svg/logo-white.svg'}}"
                         alt="{{theme_config('home.hero.image.alt')??'Basket'}}">
                </div>
            @endif
        </div>
        @if(theme_config('hero.server.ip'))
            <button data-clipboard-text="{{theme_config('hero.server.ip') ?? 'play.dixept.fr'}}"
                    class="copy_ip btn btn-primary rounded-pill py-3 px-4 text-uppercase fw-semibold">
                <div>
                    <div class="position-relative d-flex gap-2">
                        <p class="ip_address m-0">{{theme_config('hero.server.ip') ?? 'play.dixept.fr'}}</p>
                        <i class="{{theme_config('hero.server.icon') ?? 'bi bi-copy'}}"></i>
                    </div>
                </div>
            </button>
        @endif
        @if(theme_config('hero.url.link'))
            <a href="{{theme_config('hero.url.link') ?? ""}}"
               class="copy_ip btn btn-primary rounded-pill py-3 px-4 text-uppercase fw-semibold">
                {{theme_config('hero.url.text')}}
                <i class="{{theme_config('hero.server.icon') ?? 'bi bi-copy'}}"></i>
            </a>
        @endif
    </section>

    <div class="container px-lg-10 d-flex flex-column gap-lg-26">
        @if(!theme_config('home.trailer.toggle'))
            <section class="row gy-4 gx-5">
                <iframe class="col-12 col-lg-6 order-2" height="340"
                        src="{{theme_config('home.trailer.url') ?? 'https://www.youtube.com/embed/Xu5P6a7EWYg?si=hKwTgUydqz84O3ch'}}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                <div class="col-12 col-lg-6 text-md-start text-center order-md-2 order-1">
                    <h2 class="mb-3">{{theme_config('home.trailer.title') ?? 'Our awesome trailer'}}</h2>
                    <p>{{theme_config('home.trailer.paragraph') ?? 'This bloc can be disable or full edit. Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.'}}</p>
                </div>
            </section>
        @endif
        @if(!theme_config('home.news.toggle'))
            <section>
                @if(!$posts->isEmpty())
                    <h2 class="mb-5 text-md-start text-center">{{theme_config('home.news.title') ?? 'Dernières actualitées'}}</h2>
                    <div class="row gy-3 gx-4">
                        @foreach($posts->take(3) as $post)
                            <div class="col-12 col-md-6 col-lg-4">
                                <article class="post-preview card border-0 h-100">
                                    @if($post->hasImage())
                                        <a href="{{ route('posts.show', $post) }}"
                                           class="position-relative overflow-hidden">
                                            <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                                                 class="card-img-top post-image">
                                        </a>
                                    @endif
                                    <div class="card-body d-flex flex-column px-0">
                                        <h3 class="card-title">
                                            <a class="text-decoration-none"
                                               href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                                        <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($post->content), 180) }}</p>
                                        <div class="bg-light py-2 px-4 rounded-3 mt-3">
                                            {{ trans('messages.posts.posted', ['date' => format_date($post->published_at), 'user' => $post->author->name]) }}
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
        @if(!theme_config('home.about_us.toggle'))
            @includeIf('components.image-and-text', [
                'image' => theme_config('home.about_us.image.url') ? image_url(theme_config('home.about_us.image.url')):'https://assets-global.website-files.com/6364b6fd26e298b11fb9391f/6364b6fd26e298b303b93d91_3d-tb-education.png',
                'image_width' => theme_config('home.about_us.image.width') ?? 300,
                'image_height' => theme_config('home.about_us.image.height') ?? 400,
                'image_alt' => theme_config('home.about_us.image.alt') ?? 'Women on desktop',
                'title' => theme_config('home.about_us.title') ?? 'Qui sommes-nous?',
                'description' => theme_config('home.about_us.paragraph') ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'link_text' => theme_config('home.about_us.link.text') ?? 'En savoir plus',
                'link_position' => 'end',
                'link_href' => theme_config('home.about_us.link.url') ?? 'https://www.serveurliste.com/minecraft',
                'link_blank' => theme_config('home.about_us.link.blank') ?? true,
            ])
        @endif

        {{--    @if(!theme_config('home.image_or_text.toggle'))--}}
        {{--        @includeIf('components.text-image', [--}}
        {{--            'id' => 'image_or_text',--}}
        {{--            'amount' => (theme_config('home.image_or_text.amount')??3)--}}
        {{--        ])--}}
        {{--    @endif--}}

        @if(!theme_config('home.more_information.toggle'))
            @includeIf('components.image-and-text', [
                'image' => theme_config('home.more_information.image.url') ? image_url(theme_config('home.more_information.image.url')):'https://assets-global.website-files.com/6364b6fd26e298b11fb9391f/6364b6fd26e298bbffb93da8_3d-character-cv.png',
                'image_width' => theme_config('home.more_information.image.width') ?? 300,
                'image_height' => theme_config('home.more_information.image.height') ?? 400,
                'image_alt' => theme_config('home.more_information.image.alt') ?? 'Persons on desktop',
                'title' => theme_config('home.more_information.title') ?? 'More information',
                'description' => theme_config('home.more_information.paragraph') ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'link_text' => theme_config('home.more_information.link.text') ?? 'En savoir plus',
                'link_position' => 'end',
                'link_href' => theme_config('home.more_information.link.url') ?? 'https://www.serveurliste.com/minecraft',
                'link_blank' => theme_config('home.more_information.link.blank') ?? true,
                'revert' => true
            ])
        @endif

        {{--    @if(!theme_config('home.stats.toggle'))--}}
        {{--        @includeIf('components.text-image', [--}}
        {{--            'id' => 'stats',--}}
        {{--            'amount' => (theme_config('home.stats.amount')??4)--}}
        {{--        ])--}}
        {{--    @endif--}}

        @if(!theme_config('home.support_us.toggle'))
            <section class="px-2">
                <div class="row bg-tertiary text-tertiary rounded-4 py-5 px-4">
                    <div class="col-lg-3 text-center">
                        <img class="w-50"
                             src="{{theme_config('home.support_us.image.url') ? image_url(theme_config('home.support_us.image.url')):'https://static.vecteezy.com/system/resources/previews/014/034/135/original/shopping-basket-3d-illustration-png.png'}}"
                             alt="{{theme_config('home.support_us.image.alt')??'Basket'}}">
                    </div>
                    <div class="col">
                        <div>
                            <h3 class="fw-semibold">{{theme_config('home.support_us.title') ??'Nous soutenir'}}</h3>
                            <p>{{theme_config('home.support_us.paragraph') ??'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua lorem ipsum dolor sit amet consectetur adipiscing elit sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua'}}</p>
                        </div>
                        <div class="text-end">
                            <a href="{{theme_config('home.support_us.link.url')??''}}"
                               @if(theme_config('home.support_us.link.blank')) target="_blank"
                               @endif class="btn btn-primary">{{theme_config('home.support_us.link.text') ?? 'Notre boutique'}}</a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection

@push('footer-scripts')
    @if(!theme_config('hero.server.toggle'))
        <script type="text/javascript">
            const serverCounter = document.querySelector('.server_count');
            let serverCounterSpan = document.querySelector('.server_count_span')
            const serverSpan = serverCounterSpan.innerText;
            serverCounterSpan.innerHTML = ""
            if (serverCounter.innerText.includes('{online}')) {
                serverCounter.innerText = serverCounter.innerText.replace('{online}', serverSpan)
            }
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
        <script type="text/javascript">
            var clipboard = new ClipboardJS('.copy_ip')
            clipboard.on('success', function (e) {
                let elm = document.querySelector(".ip_address");
                elm.innerHTML = '{{theme_config('hero.server.textcopied') ?? mb_strtoupper(trans('theme::theme.general.server-button.ipCopied'))}}';
                setTimeout(function () {
                    elm.innerHTML = '{{theme_config('hero.server.ip') ?? 'play.dixept.fr'}}';
                }, 1500);
            });
        </script>
    @endif
@endpush
