<div class="copyright">
    <div class="container">
        <p>{{ setting('copyright') }} | <span title="Version ?">{{trans('theme::theme.footer.copyright')}} <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" rel="noopener noreferrer">Dixept</a>.</span> | @lang('messages.copyright') </p>

        @foreach(social_links() as $link)
            <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer"
               data-bs-toggle="tooltip"
               class="d-inline-block mx-1 p-2 rounded-circle" style="background: {{ $link->color }}">
                <i class="{{ $link->icon }} text-white"></i>
            </a>
        @endforeach
    </div>
</div>
