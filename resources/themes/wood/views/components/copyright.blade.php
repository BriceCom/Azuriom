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
