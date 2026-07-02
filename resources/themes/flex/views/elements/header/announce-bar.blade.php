@if(theme_config('header.modules.announceBar.on'))
    <div class="announce-bar px-2 py-2.5" style="background-color: {{ theme_config('header.modules.announceBar.bg') ?? '#892958' }};">
        {!! theme_config('header.modules.announceBar.text') !!}
    </div>
@endif
