@php $totalPlayers = $totalPlayers ?? 128 @endphp

<div class="stats d-flex flex-column align-items-center justify-content-center gap-3">
    <div class="stats__card d-flex flex-column justify-content-center align-items-center">
        <b>{{$totalPlayers}}</b>
        <p class="m-0 text-center text-uppercase">{{theme_config('home.index.stats.1.text') ?? "joueurs en ligne"}}</p>
    </div>
    <div class="stats__card d-flex flex-column justify-content-center align-items-center">
        <b>{{theme_config('home.index.stats.2.title') ?? "+128K"}}</b>
        <p class="m-0 text-center text-uppercase">{{theme_config('home.index.stats.2.text') ?? "joueurs uniques"}}</p>
    </div>
    <div class="stats__card d-flex flex-column justify-content-center align-items-center">
            <b>{{theme_config('home.index.stats.discord.title') ?? "à config"}}</b>
            <p class="m-0 text-center text-uppercase">{{theme_config('home.index.stats.discord.text') ?? "membres discord"}}</p>
            <a href="{{theme_config('home.index.discord.link') ?? 'https://discord.gg/ZdSPkxK5xT'}}" target="_blank">
                <i class="bi bi-discord"></i>
            </a>
    </div>
</div>

@include('components.discord.discordAPI', ['onlyCounter' => true])
