@if(!theme_config('footer.toggle'))
    <div class="bg-dark border-top">
        <div class="container">
            <div class="row py-4">
                <div class="col-md-4">
                    <h2 class="fw-semibold fs-5 text-primary">{{theme_config('footer.left.title') ?? trans('theme::theme.footer.us.title')}}</h2>
                    <p class="text-white-50  fw-normal">
                        {{theme_config('footer.left.paragraph') ?? trans('theme::theme.footer.us.description')}}
                    </p>
                    <ul class="list-unstyled d-flex gap-3 m-0 mt-2 p-0">
                        @foreach(social_links() as $link)
                            <li><a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
                                   data-bs-toggle="tooltip"
                                   class="d-inline-block">
                                    <i class="{{ $link->icon }} text-white"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-4 ">
                    <h2 class="fw-semibold fs-5 text-primary">{{theme_config('footer.middle.title') ?? trans('theme::theme.footer.social.title')}}</h2>
                    <ul class="list-unstyled d-flex flex-column gap-2">

                        @if(!theme_config('footer.middle.socials.active'))
                            @foreach(social_links() as $link)
                                <li>
                                    <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none">
                                        {{$link->title}}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        @if(theme_config('footer.middle.links'))
                            @foreach(theme_config('footer.middle.links') as $link)
                                <li>
                                    <a href="{{ $link['url'] ?? '' }}"  @if(isset($link['active']) && $link['active']) target="_blank" @endif rel="noopener noreferrer" class="text-white-50 text-decoration-none">
                                        {{$link['text'] ?? ''}}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        @if(!theme_config('footer.middle.serveurliste.active'))
                            <li>
                                <a href="{{theme_config('general.serveurliste') ?? 'https://serveurliste.com/'}}" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none">
                                    ServeurListe
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-4">
                    <h2 class="fw-semibold fs-5 text-primary">{{theme_config('footer.right.title') ?? trans('theme::theme.footer.support.title')}}</h2>
                    <p class="text-white-50  fw-normal">
                        {{theme_config('footer.right.paragraph') ?? trans('theme::theme.footer.support.description')}}
                    </p>
                    <a class="btn btn-primary" @if(theme_config('footer.right.blank')) target="_blank" rel="noopener noreferrer" @endif href="{{theme_config('footer.right.url') ?? (theme_config('general.serveurliste')??'https://serveurliste.com')}}">{{theme_config('footer.right.text') ?? trans('theme::theme.footer.support.vote_for', ['server_name'=>site_name()])}}</a>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="container @if(theme_config('footer.toggle')) text-center @endif">
    <p class="text-white-50 py-3 m-0">{{ setting('copyright') }} | <span title="Version {{$version_theme['version']}}">{{trans('theme::theme.footer.copyright')}} <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>
</div>

