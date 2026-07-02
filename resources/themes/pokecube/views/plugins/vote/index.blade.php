@extends('layouts.app')

@section('title', trans('vote::messages.title'))
@include('elements.section')

@section('content')

<div class="vote-wrapper">

    <!-- COLONNE GAUCHE -->
    <div class="left-col">

        <!-- GRAND RECTANGLE -->
        <div class="big-box">
            <img class="vote-logo" src="{{ site_logo() }}" />
            <div class="description">
                <h5>VOTEZ POUR LE SERVEUR ET OBTENEZ 1 CLE DE VOTE !</h5>
                <p>Faites la commande <span class="presentation-title-poke">/claim</span> en jeu pour obtenir vos clés de vote.</p>
            </div>
        </div>

<!-- DEUX CARRÉS -->
@guest
<div class="bottom-row">

    {{-- SITE 1 invité --}}
    <div class="small-box-guest">
        <img class="vote-logo-small" src="{{ theme_asset('img/vote_1.png') }}" />
        <div class="description">
            <h5>SITE N°1</h5>
            <p>Connectez-vous</p>
        </div>
    </div>

    {{-- SITE 2 invité --}}
    <div class="small-box-guest">
        <img class="vote-logo-small" src="{{ theme_asset('img/vote_2.png') }}" />
        <div class="description">
            <h5>SITE N°2</h5>
            <p>Connectez-vous</p>
        </div>
    </div>

</div>
@else
@auth
<div class="bottom-row">

    {{-- SITE 1 connecté --}}
    @if(isset($sites[0]))
        <div class="small-box-guest">
            <img class="vote-logo-small" src="{{ theme_asset('img/vote_1.png') }}" />
            <div class="description">
                <h5>{{ $sites[0]->name }}</h5>

                @php
                    $time1 = $sites[0]->getNextVoteTime($user, request())?->valueOf();
                @endphp

                <p>
                    @if($time1)
                        <span class="vote-timer" data-time="{{ $time1 }}"></span>
                    @else
                        Votez maintenant
                    @endif
                </p>
            </div>
        </div>
    @else
        <div class="small-box-guest">
            <img class="vote-logo-small" src="{{ theme_asset('img/vote_1.png') }}" />
            <div class="description">
                <h5>SITE N°1</h5>
                <p>Aucun site</p>
            </div>
        </div>
    @endif

    {{-- SITE 2 connecté --}}
    @if(isset($sites[1]))
        <div class="small-box-guest">
            <img class="vote-logo-small" src="{{ theme_asset('img/vote_2.png') }}" />
            <div class="description">
                <h5>{{ $sites[1]->name }}</h5>

                @php
                    $time2 = $sites[1]->getNextVoteTime($user, request())?->valueOf();
                @endphp

                <p>
                    @if($time2)
                        <span class="vote-timer" data-time="{{ $time2 }}"></span>
                    @else
                        Votez maintenant
                    @endif
                </p>
            </div>
        </div>
    @else
        <div class="small-box-guest">
            <img class="vote-logo-small" src="{{ theme_asset('img/vote_2.png') }}" />
            <div class="description">
                <h5>SITE N°2</h5>
                <p>Aucun site</p>
            </div>
        </div>
    @endif

</div>
@endauth
@endguest


    </div>

    <!-- COLONNE DROITE -->
    <div class="right-col">
        <div class="right-top">
        @guest
        <img id="skin-preview" 
         src="https://mc-heads.net/body/Steve/100" 
         alt="Skin" 
         class="skin-img">
        @else
            @auth
                <div class="logout-button">
                    <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        ☓
                    </a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                    <img id="skin-preview" 
            src="https://mc-heads.net/body/{{auth()->user()->name}}/100" 
            alt="Skin" 
            class="skin-img">
            @endauth
        @endguest

        <div class="skin-form">
            @guest
            <form class="vote-input-card" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
                <input type="text" id="stepNameInput" name="name" class="vote-input" placeholder="Entrez un pseudo...">
                <button type ="submit" class ="vote-check-btn" id="pseudo-btn">{{ trans('messages.actions.continue') }}</button>
            </form>
            @else
                @auth
                    <p>{{auth()->user()->name}}</p>
                    <p>0 votes</p>
                @endauth
            @endguest
        </div>
        </div>
    </div>

</div>

@php
    $top = $votes->take(3);
@endphp

<div class="podium-wrapper">

    @if($top->isEmpty())
        <div class="vote-error">
            <p>Aucun joueur n’a encore voté ce mois-ci.</p>
        </div>
    @else

        <div class="podium">

            {{-- 2ème place --}}
            @if(isset($top[1]))
            <div class="podium-place second">
                <img class="podium-skin" src="https://mc-heads.net/body/{{ $top[1]->user->name }}/100">
                <span class="podium-name">{{ $top[1]->user->name }}</span>
                <span class="podium-votes">{{ $top[1]->votes }} votes</span>
                <div class="podium-bar">2</div>
            </div>
            @endif

            {{-- 1ère place --}}
            @if(isset($top[0]))
            <div class="podium-place first">
                <img class="podium-skin" src="https://mc-heads.net/body/{{ $top[0]->user->name }}/100">
                <span class="podium-name">{{ $top[0]->user->name }}</span>
                <span class="podium-votes">{{ $top[0]->votes }} votes</span>
                <div class="podium-bar">1</div>
            </div>
            @endif

            {{-- 3ème place --}}
            @if(isset($top[2]))
            <div class="podium-place third">
                <img class="podium-skin" src="https://mc-heads.net/body/{{ $top[2]->user->name }}/100">
                <span class="podium-name">{{ $top[2]->user->name }}</span>
                <span class="podium-votes">{{ $top[2]->votes }} votes</span>
                <div class="podium-bar">3</div>
            </div>
            @endif

        </div>

    @endif

</div>

    <div class="vote-page-line"></div>


<h2 class="ranking-title">CLASSEMENT DU MOIS</h2>

<div class="ranking-table">

    @php
        $top10 = $votes->take(10);
    @endphp

    @if($top10->isEmpty())
        <div class="vote-error">
            <p>Aucun joueur n’a encore voté ce mois-ci.</p>
        </div>
    @else

        @foreach($top10 as $index => $vote)
            @php
                $position = $index + 1;
            @endphp

            <div class="ranking-row position-{{ $position }}">

                <!-- Position -->
                <div class="ranking-pos">
                    {{ $position }}
                </div>

                <!-- Skin -->
                <img class="ranking-skin"
                     src="https://mc-heads.net/avatar/{{ $vote->user->name }}/60">

                <!-- Pseudo -->
                <div class="ranking-name">
                    {{ $vote->user->name }}
                </div>


                <!-- Votes -->
                <div class="ranking-votes">
                    {{ $vote->votes }}
                </div>

            </div>
        @endforeach

    @endif

</div>
