<div class="container container-footer">
    <footer class="bg-body-secondary d-flex flex-column gap-4.5 p-2 py-4.5 p-md-4.5 rounded-top-5">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
            @include('components.socials')

            <div class="d-flex flex-wrap align-items-center gap-3">
                @include('components.join-button', ['variant' => 'secondary'])
                <a href="#top" class="btn btn-primary btn-icon">
                    <i class="bi bi-arrow-up"></i>
                </a>
            </div>
        </div>

        <div class="row gx-5 justify-content-between">
            <div class="col-lg-6">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4 mb-lg-0">
                    @php($footerImage = theme_config('footer.index.image'))
                    <img src="{{ $footerImage ? image_url($footerImage) : site_logo() }}" alt="Logo {{site_name()}}" class="object-fit-contain" style="max-width: 200px"/>

                    <div class="flex-grow-1">
                        <h2 class="h3">{{theme_config('footer.index.title') ?? site_name()}}</h2>
                        <p class="text-sm opacity-75 mb-0">{{theme_config('footer.index.text') ?? "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."}}</p>
                    </div>
                </div>
            </div>

            @if(theme_config('footer.index.links'))
                @foreach(theme_config('footer.index.links') as $link)
                    <div class="col-lg-3">
                        <h3 class="mb-2">{{$link['title'] ?? ""}}</h3>

                        <ul class="w-100 list-unstyled col-lg-3">
                            @if($link['links'])
                                @foreach($link['links'] as $sublink)
                                    @if($sublink['name'])
                                        <li><a href="{{$sublink['href'] ?? "#"}}"
                                               class="nav-link fw-light text-lg anim_text-up py-1"
                                               @if(isset($sublink['target'])) target="_blank" @endif><b>{{$sublink['name'] ?? ""}}</b></a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endforeach
            @endif

            @if(theme_config('footer.index.button.text'))
                <div class="col-lg-3 d-flex flex-column">
                    <h3 class="mb-3">{{theme_config('footer.index.button.title') ?? ""}}</h3>

                    @if(theme_config('footer.index.button.description'))
                        <p class="mb-3 opacity-75 text-sm">{{theme_config('footer.index.button.description') ?? ""}}</p>
                    @endif

                    <a href="{{theme_config('footer.index.button.url') ?? "#"}}"
                       class="w-fit btn btn-outline-tertiary"
                       rel="noopener noreferrer">@if(theme_config('footer.index.button.icon'))
                            <i class="{{theme_config('footer.index.button.icon')}}"></i>
                        @endif {{theme_config('footer.index.button.text') ?? ""}}</a>
                </div>
            @endif

        </div>

        <p class="mb-0">
            <small class="text-xs opacity-50">{{ setting('copyright') }}
                |
                @if(theme_config('premium.serveurliste.link'))
                    @if(!theme_config('footer.index.dixept_copyright.off'))
                        <span>{{trans('theme::theme.footer.copyright')}}
                        <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
                    </span>|
                    @endif
                @else
                    <span>{{trans('theme::theme.footer.copyright')}}
                    <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
                </span>|
                @endif
                @lang('messages.copyright')
            </small>
        </p>
    </footer>
</div>
