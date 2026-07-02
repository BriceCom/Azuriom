@if(theme_config('home.discord.off') !== 'on')
    <section class="py-11 bg-blue">
        <div class="discord-section mx-auto text-white text-center px-4">
            <h2>{{theme_config('home.discord.title') ?? "Rejoignez la communauté  Discord"}}</h2>
            <p>{{theme_config('home.discord.text') ?? "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry."}}</p>
            <a href="{{theme_config('settings.discord.link' ?? "#")}}" class="btn btn-currentColor text-uppercase mt-4" style="--di-btn-color: var(--di-blue); --di-btn-color-hsl: var(--di-blue-hsl)"><i class="bi bi-discord"></i> Rejoindre le discord</a>
        </div>
    </section>
@endif
