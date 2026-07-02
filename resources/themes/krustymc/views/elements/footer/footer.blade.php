<div class="footer">
    <div class="bg-body-secondary border-0 pt-8 py-3">
        <div class="container d-flex flex-wrap flex-md-nowrap justify-content-between gap-5 gap-md-0 pb-5">
            <div class="col-md-6 d-flex flex-column gap-5">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                    <div class="d-flex flex-column align-items-center gap-3">
                        <a href="/">
                            <img src="{{site_logo()}}" height="180" alt="Logo"/>
                        </a>
                    </div>

                    <div>
                        <h2>{{theme_config('footer.index.title') ?? site_name()}}</h2>
                        <p>{{theme_config('footer.index.description') ?? setting('description', '')}}</p>

                        <div class="d-flex flex-wrap align-items-center gap-4">
                            @include('components.ip-and-connected')
                            @include('components.socials')
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex flex-wrap align-items-baseline justify-content-md-center gap-3 gap-sm-5 gap-md-8">
                @if(theme_config('footer.index.links'))
                    @foreach(theme_config('footer.index.links') as $i => $links)
                        <div class="w-full">
                            <h3 class="h6 text-uppercase fw-semibold text-end">{{$links['title']}}</h3>
                            <ul class="list-unstyled">
                                @foreach($links['links'] as $link => $i)
                                    <li><a href="{{isset($i['url']) ? $i['url']:"#"}}"
                                           @if(isset($i['blank']) && $i['blank']) target="_blank"
                                           @endif class="text-sm text-end text-decoration-none">{{isset($i['text']) ? $i['text']: ''}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="container opacity-50">
            <p class="text-center text-md-start ps-md-4 text-xs m-0 fw-semibold">{{ setting('copyright') }}
                |
                <span>{{trans('theme::theme.footer.copyright')}}
                        <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.
                    </span>|
                @lang('messages.copyright')
            </p>
        </div>
    </div>
</div>
