@extends('layouts.app')

@section('title', 'Launcher')

@section('content')
    <div class="container py-8 my-8">
        <div class="row">
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center border-2 border-end border-secondary">
                <h2 class="text-uppercase">Qu'est-ce que {{site_name()}}</h2>
                <p class="text-center text-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur autem beatae blanditiis, consequatur dolor eius error eum facere fugiat itaque magnam, maxime neque nihil odio praesentium repudiandae sed ut voluptatum!</p>
                <div class="mt-4">
                    <h3 class="text-uppercase text-center">Jeux accessibles à tous</h3>
                    <ul class="list-unstyled d-flex align-items-center justify-content-center flex-wrap gap-4 mt-3">
                        @if(theme_config('launcher.who.games'))
                            @foreach(theme_config('launcher.who.games') as $link)
                                @if($link['text'] != null)
                                    <li class="position-relative d-flex justify-content-center bg-secondary rounded-2 px-4_5 py-1 text-sm fw-semibold">
                                        <img class="position-absolute top-50 start-0 translate-middle"
                                             aria-hidden="true"
                                             src="{{$link['img'] ? image_url($link['img']):"https://static.wikia.nocookie.net/minecraft_gamepedia/images/a/af/Apple_JE3_BE3.png"}}"
                                             alt="Icône"
                                             width="40" height="40">
                                        {{$link['text']}}
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                <h2 class="text-uppercase">Comment jouer sur {{site_name()}} ?</h2>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li class="d-flex align-items-center gap-2"><span class="d-flex align-items-center justify-content-center p-2 rounded-circle bg-secondary h5 " style="height: 32px; width: 32px">1</span> Ouvrez le jeu <b class="text-primary">Minecraft</b></li>
                    <li class="d-flex align-items-center gap-2"><span class="d-flex align-items-center justify-content-center p-2 rounded-circle bg-secondary h5 " style="height: 32px; width: 32px">2</span> Cliquez sur le bouton <b class="text-secondary fw-bold">Multijoueur</b> puis sur <b class="text-secondary fw-bold">Nouveau serveur</b></li>
                    <li class="d-flex align-items-center gap-2"><span class="d-flex align-items-center justify-content-center p-2 rounded-circle bg-secondary h5 " style="height: 32px; width: 32px">3</span> Copie et colle notre <b class="text-secondary fw-bold">adresse</b> dans <b class="text-secondary fw-bold">Adresse du serveur</b></li>
                    <li class="copyButton my-2"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!" aria-label="Adresse copiée!" data-bs-trigger="manual"
                    >
                        <div class="border-3 border p-3" style="border-color: rgba(255,255,255,0.20) !important">
                            <label for="ip" class="form-label mb-1">Adresse du serveur</label>
                            <input id="ip" type="text" class="form-control rounded-0" value="{{theme_config('home.ip.text') ?? 'play.pandonia.fr'}}">
                            <div class="mt-2 text-end">
                                <button class="d-inline-flex text-xs ms-auto">Copier l'adresse</button>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center gap-2"><span class="d-flex align-items-center justify-content-center p-2 rounded-circle bg-secondary h5 " style="height: 32px; width: 32px">4</span> Clique sur <b class="text-secondary fw-bold">Valider</b>, tu peux désormais jouer sur {{site_name()}}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
