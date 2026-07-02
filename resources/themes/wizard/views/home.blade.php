@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div class="home-background d-flex align-items-center justify-content-center flex-column text-white"
         style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat;">
        <div class="container text-center">
            <div class="my-3">
                @include('elements.session-alerts')
            </div>
            @if(theme_config('home.hero.media'))
                <img class="d-block mx-auto img-fluid" src="{{ image_url(theme_config('home.hero.media'))}}"
                 alt="{{site_name()}}">
            @endif
            <img class="d-block mx-auto my-5" src="{{theme_asset('/images/petits/line.png')}}" alt="séparateur">
            <h1 class="fw-bold my-5 bg-image-none hero-title">{{theme_config('home.hero.title')}}</h1>

            <button
                class="clipboard btn-special"
                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!"
                data-bs-trigger="manual"
            >
                {{theme_config('home.hero.name_btn')}}
            </button>
        </div>
    </div>

    @if($message)
        <div class="border-separator-container">
            <div class="container my-5">
                <div class="card card-body">
                    {!! $message  !!}
                </div>
            </div>
        </div>
    @endif

    <div class="position-relative border-separator-container">
        @if(theme_config('home.block_1.back'))
            <img class="position-absolute w-100 h-100 top-0 start-0 object-cover object-position-center"
                 src="{{ image_url(theme_config('home.block_1.back'))}}"
                 alt="{{site_name()}}">
        @endif
        <div class="position-relative container py-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="text-center text-lg-start">
                        <div class="ornament-lg pb-3 d-inline-block">
                            <h2 class="text-gradient fw-bold text-uppercase fs-2">{{theme_config('home.block_1.title')}}</h2>
                        </div>
                    </div>
                    <div class="card card-body mt-2 border-gradient" style="background-color: rgba(26, 32, 44, .3);">
                        <p class="mb-0">{{theme_config('home.block_1.description')}}</p>
                    </div>
                </div>
                <div class="col-md-4 text-center my-4 my-md-0">
                    @if(theme_config('home.block_1.render'))
                        <img class="object-position-center"
                             src="{{ image_url(theme_config('home.block_1.render'))}}"
                             alt="{{site_name()}}">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="position-relative">
        @if(theme_config('home.article.back'))
            <img class="position-absolute w-100 h-100 top-0 start-0 object-cover object-position-center"
                 src="{{ image_url(theme_config('home.article.back'))}}"
                 alt="{{site_name()}}">
        @endif
        <div class="position-relative container py-5">
            <div class="text-center">
                <h2 class="text-gradient fw-bold text-uppercase fs-2">{{theme_config('home.article.title')}}</h2>
                <img class="d-block mx-auto" src="{{theme_asset('/images/petits/line.png')}}" alt="séparateur">
            </div>
            <div class="row">
                <div class="col-lg-8">

                    @php
                        $posts = Azuriom\Models\Post::published()
                        ->with('author')
                        ->latest('published_at')
                        ->paginate(5);
                    @endphp
                    <div class="articles border-gradient p-4 me-lg-4">
                        @if(! $posts->isEmpty())
                            @foreach($posts as $post)
                                <a href="{{ route('posts.show', $post) }}" title="{{ $post->title }}"
                                   class="card-article d-block text-decoration-none">
                                    <div class="article row align-items-stretch">
                                        <div class="col-md-4">
                                            <div class="border-gradient h-100">
                                                @if($post->hasImage())
                                                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                                                         class=" h-100 w-100 object-cover">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body mt-3 mt-md-0">
                                                <h3 class="text-gradient fw-bold text-uppercase fs-5 mb-1">{{ $post->title }}</h3>
                                                <p class="card-text text-white">{{ Str::limit(strip_tags($post->content), 250) }}</p>
                                            </div>
                                            <div class="card-footer text-end fst-italic fs-7 text-gray-500">
                                                Publié le {{format_date($post->published_at)}} par <span
                                                    class="text-yellow-600">{{ $post->author->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                    {{ $posts->links() }}

                </div>
                <div class="col-lg-4">
                    <div class="border-gradient p-4 text-center">
                        <h3 class="text-gradient fw-bold text-uppercase fs-5 mb-3">Nos réseaux sociaux</h3>

                        @foreach(social_links() as $link)
                            <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank"
                               rel="noopener noreferrer"
                               data-bs-toggle="tooltip"
                               class="d-inline-block mx-1 p-2" style="color: {{ $link->color }}">
                                <i class="{{ $link->icon }} fs-3"></i>
                            </a>
                        @endforeach
                    </div>
                    <div class="text-center my-4 my-md-0">
                        @if(theme_config('home.article.render'))
                            <img class="object-position-center"
                                 src="{{ image_url(theme_config('home.article.render'))}}"
                                 alt="{{site_name()}}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footer-scripts')
    <script type="text/javascript">
        async function copyToClipboard(textToCopy) {
            // Navigator clipboard api needs a secure context (https)
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(textToCopy);
            } else {

                const tempInput = document.createElement("input");
                tempInput.value = textToCopy;
                tempInput.style.position = "absolute";
                tempInput.style.left = "-999999px";

                document.body.prepend(tempInput);
                tempInput.select();

                try {
                    document.execCommand('copy');
                } catch (error) {
                    console.error(error);
                } finally {
                    tempInput.remove();
                }
            }
        }

        let copyButton = document.querySelectorAll(".clipboard");

        copyButton.forEach(function(e) {
            e.addEventListener("click", function() {
                let textToCopy = '{!! theme_config('home.hero.ip_btn') ?? 'play.dixept.fr' !!}';
                copyToClipboard(textToCopy);

                let tooltip = new bootstrap.Tooltip(e);
                tooltip.show();

                setTimeout(function() {
                    tooltip.hide();
                }, 2000);
            })

            e.addEventListener("mouseover", function() {
                let tooltip = bootstrap.Tooltip.getInstance(e);
                if (tooltip) {
                    tooltip.hide();
                }
            });
        });
    </script>
@endpush
