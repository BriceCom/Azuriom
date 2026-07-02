
<div class="announce">
@php $message = setting('home_message'); @endphp

@if($message)
    <h5>{!! $message !!}</h5>
@else
    <h5>🔧 EN COURS DE DEVELOPPEMENT ! 🔧</h5>
@endif
</div>

<div class="hero-logo-wrapper">
        <img class="bg-logo" src="{{ site_logo() }}" alt="Logo">
    </div>

    <div class="hero-statut-wrapper">
        <div class="statut">
            <h5>{{theme_config('navbar-text')}}</h5>
        </div>
<div class="ping">
    <p>
        @if(!$servers->isEmpty())
            🟢 {{ $servers->first()->getOnlinePlayers() }}
        @else
            🔴 ...
        @endif
    </p>

    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
    </svg>
</div>
</div>

<section class="background-section">
    <div class="content-overlay">
        <div class="section-fade-bottom"></div>
    </div>
</section>
