<footer class="bg-body-secondary text-white px-2 px-md-7 pt-7 pb-3">

    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between">
            <div>
                <img src="{{site_logo()}}" alt="Logo {{site_name()}}" width="308" class="object-fit-contain"
                     draggable="false">
            </div>

            <div class="flex-grow-1 d-flex flex-column flex-md-row justify-content-end navbar-nav mt-4.5 mt-md-0">

                @if(theme_config('footer.index.links'))
                    @foreach(theme_config('footer.index.links') as $link)
                        <ul class="list-unstyled col-md-3">
                            <h3 class="mb-2">{{$link['title'] ?? ""}}</h3>
                            @if($link['links'])
                                @foreach($link['links'] as $sublink)
                                    @if($sublink['name'])
                                        <li><a href="{{$sublink['href'] ?? "#"}}"
                                               class="nav-link fw-light text-uppercase text-md anim_text-up"
                                               @if(isset($sublink['target'])) target="_blank" @endif><b>{{$sublink['name'] ?? ""}}</b></a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    @endforeach
                @endif

                @if(theme_config('footer.index.button.text'))
                    <div class="col-md-3 d-flex flex-column">
                        <h3 class="mb-3">{{theme_config('footer.index.button.title') ?? ""}}</h3>
                        <a href="{{theme_config('footer.index.button.url') ?? "#"}}"
                           class="w-fit btn btn-outline-tertiary"
                           rel="noopener noreferrer">@if(theme_config('footer.index.button.icon'))
                                <i class="{{theme_config('footer.index.button.icon')}}"></i>
                            @endif {{theme_config('footer.index.button.text') ?? ""}}</a>
                    </div>
                @endif
            </div>
        </div>

        <p class="text-end mb-0 mt-4.5">
            <small class="opacity-50 ms-auto">{{ setting('copyright') }}
                @lang('messages.copyright')

                <span>{{trans('theme::theme.footer.copyright')}}
                <a href="https://discord.com/invite/KVmpqz7n6M" target="_blank" rel="noopener noreferrer">Bryx</a>.
            </span>
            </small>
        </p>
    </div>
</footer>
