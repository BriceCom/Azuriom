@extends('layouts.app')

@section('title', 'Launcher')

@section('content')
    <h1>Rejoignez-nous</h1>
    <p class="text-center fs-5">
        <img class="float-left icon-arrow"
             src="{{theme_asset('/images/petits/fleche-droite.svg')}}" alt="décoration">
        {!! empty($description) ? trans('launcher::messages.description') : $description !!}
    </p>

    <video src="{{theme_asset('/images/launcher/launcher.mp4')}}"
           type="video/mp4" autoplay="autoplay"
           muted="muted"
           loop="loop"
           playsinline=""
            class="border-gradient mt-5 bg-purple-1000"
    >
    </video>

    <img class="d-block mx-auto my-5" src="{{theme_asset('/images/petits/line.png')}}" alt="séparateur">
    <div class="launcher d-flex justify-content-evenly flex-wrap text-center">
        @if(!$windowsEnabled)
            <a href="{{ $windows }}" target="_blank"
               class="d-inline-block border-gradient py-2 px-3 text-decoration-none font-family-azul text-white bg-purple-1000">

                <img class="object-position-center"
                     src="{{theme_asset('/images/launcher/windows-download-launcher.svg')}}"
                     alt="Windows">

                <p class="card-text">Windows</p>
            </a>
        @endif
        @if(!$macEnabled)
            <a href="{{ $mac }}" target="_blank"
               class="d-inline-block border-gradient py-2 px-3 text-decoration-none font-family-azul text-white bg-purple-1000">
                <img class="object-position-center"
                     src="{{theme_asset('/images/launcher/apple-download-launcher.svg')}}"
                     alt="macOS">
                <p class="card-text">macOS</p>
            </a>
        @endif
        @if(!$linuxEnabled)
            <a href="{{ $linux }}" target="_blank"
               class="d-inline-block border-gradient py-2 px-3 text-decoration-none font-family-azul text-white bg-purple-1000">
                <img class="object-position-center"
                     src="{{theme_asset('/images/launcher/linux-download-launcher.svg')}}"
                     alt="Linux">
                <p class="mb-0 mt-1">Linux</p>
            </a>
        @endif
    </div>
@endsection
