@extends('layouts.base')
@php
    $plugname = request()->route()->uri;

    $plugname = str_replace('/','_',$plugname);

    $hero = match($plugname){
        'profile' => [
            'order' => theme_config('profile.hero.order') != 0 ? theme_config('profile.hero.order'):'0',
            'personnage' => theme_config('profile.hero.image') ? image_url(theme_config('profile.hero.image')):theme_asset('image/steve_craft_dc.png'),
            'title' => theme_config('profile.hero.title') ? theme_config('profile.hero.title'):"Votre profil de héro !",
            'paragraphe' => theme_config('profile.hero.paragraph') ? theme_config('profile.hero.paragraph'):""
            ],
        'vote' => [
            'order' => theme_config('vote.hero.order') != 0 ? theme_config('vote.hero.order'):'0',
            'personnage' => theme_config('vote.hero.image') ? image_url(theme_config('vote.hero.image')):theme_asset('image/alex.png'),
            'title' => theme_config('vote.hero.title') ? theme_config('vote.hero.title'):"Nous recherche toujours des héros pour nous aider !",
            'paragraphe' => theme_config('vote.hero.paragraph') ? theme_config('vote.hero.paragraph'):"C’est en grande partie grâce à vos votes que notre serveur peut être mis en avant et que nous pouvons nous améliorer pour le futur de notre projet !"
            ],
        'shop_categories_{category}' => [
            'order' => theme_config('shop.hero.order') != 1 ? theme_config('shop.hero.order'):'1',
            'personnage' => theme_config('shop.hero.image') ? image_url(theme_config('shop.hero.image')):theme_asset('image/steve_chest.png'),
            'title' => theme_config('shop.hero.title') ? theme_config('shop.hero.title'):"Faites briller votre soutien enparticipant à notre évolution",
            'paragraphe' => theme_config('shop.hero.paragraph') ? theme_config('shop.hero.paragraph'):"ATTENTION: Vous n’êtes en aucun cas dans l’obligation de réaliser un achat sur notre boutique ! Cette acte doit être réalisé avec consentement et volonté de soutenir notre projet !"
            ],
        'shop_profile' => [
            'order' => theme_config('purchases.hero.order') != 0 ? theme_config('purchases.hero.order'):'0',
            'personnage' => theme_config('purchases.hero.image') ? image_url(theme_config('purchases.hero.image')):theme_asset('image/villager_libraire.png'),
            'title' => theme_config('purchases.hero.title') ? theme_config('purchases.hero.title'):"Tous les achats réalisé dans notre boutique",
            'paragraphe' => theme_config('purchases.hero.paragraph') ? theme_config('purchases.hero.paragraph'):""
            ],
        'shop_cart' => [
            'order' => theme_config('cart.hero.order') != 0 ? theme_config('cart.hero.order'):'0',
            'personnage' => theme_config('cart.hero.image') ? image_url(theme_config('cart.hero.image')):theme_asset('image/homme_libraire.png'),
            'title' => theme_config('cart.hero.title') ? theme_config('cart.hero.title'):"Tous les achats réalisé dans notre boutique",
            'paragraphe' => theme_config('cart.hero.paragraph') ? theme_config('cart.hero.paragraph'):""
            ],
        'shop_payments_payment' => [
            'order' => theme_config('offers.hero.order') != 0 ? theme_config('offers.hero.order'):'0',
            'personnage' => theme_config('offers.hero.image') ? image_url(theme_config('offers.hero.image')):theme_asset('image/villager_farmer.png'),
            'title' => theme_config('offers.hero.title') ? theme_config('offers.hero.title'):"Choisissez votre moyen de paiement préféré",
            'paragraphe' => theme_config('offers.hero.paragraph') ? theme_config('offers.hero.paragraph'):""
            ],
        default => [
            'is_default' => true,
            'order' => theme_config('general.hero.random') ? rand(0,1):'1',
            'personnage' => theme_asset('image/steve_forgeron.png'),
            'title' => theme_config('general.hero.title') ? theme_config('general.hero.title'):"Dainesia sollicite ses héros pour défendre son royaume !",
            'paragraphe' => theme_config('general.hero.paragraph') ? theme_config('general.hero.paragraph'):"Devenez un héros légendaire en explorant des donjons dangereux, en combattant des créatures maléfiques et en protégeant le royaume !"
            ],
    };

    if(str_contains($plugname, 'support')) $plugname = 'support';
    if(str_contains($plugname, 'cps')) $plugname = 'cps_wrapper';
    if(str_contains($plugname, 'shop')) $plugname = 'shop';
    if(str_contains($plugname, 'forum')) $plugname = 'forum';
    if(str_contains($plugname, 'path')) $plugname = request()->route()->path;
    if(str_contains($plugname, 'post')) $plugname = request()->route()->post->title;
    if(str_contains($plugname, 'profile')) $plugname = 'profile';

@endphp

@section('app')
    <main>
        <div class="container-fluid d-flex justify-content-between position-relative hero d-flex align-items-center overflow-hidden">
            <img loading="lazy" aria-hidden="true" class="dungeons_icon" src="{{theme_asset('image/tripe_icon_dungeons.svg')}}" alt="Triple icone du serveur {{site_name()}}" draggable="false">
                <div class="flex-grow-1 flex-lg-grow-0 row hero-content align-items-end px-lg-5">
                    <div class="d-none {{$hero['order'] != '1' ? 'd-lg-flex justify-content-center':'d-lg-block'}} col-12 col-lg-5 hero-personnage order-{{$hero['order']}}">
                        <img loading="lazy" src="{{$hero['personnage']}}" alt="Personnage du jeu minecraft" draggable="false">
                    </div>
                    <div class="flex-lg-grow-1 col-12 col-lg-7 align-self-center text-center text-lg-start px-4 px-md-5 px-lg-3">
                        @if(!isset($hero['is_default']))
                            <h1 class="fw-bold display-1">{{$hero['title']}}</h1>
                        @else
                            <h2 class="fw-bold display-1">{{$hero['title']}}</h2>
                        @endif
                        @if($hero['paragraphe'] != '')
                            <p>{!!$hero['paragraphe']!!}</p>
                        @endif
                    </div>
                </div>
            <img loading="lazy" aria-hidden="true" class="dungeons_icon" src="{{theme_asset('image/tripe_icon_dungeons.svg')}}" alt="Triple icone du serveur {{site_name()}}" draggable="false">
        </div>
        <div class="container content my-5 py-5">
            <div id="{{$plugname}}">
                @include('elements.session-alerts')

                @yield('content')
            </div>
        </div>
    </main>
@endsection
