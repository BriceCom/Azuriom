@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div class="container content py-4">
        @include('elements.session-alerts')

        <!--@if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif-->

        <div class="row align-items-start">
            <div class="col-lg-8">
                @if(theme_config('home.slider'))
                    <div id="carouselHomePage" class="carousel carousel-dark slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach(theme_config('home.slider') as $slider)
                                @if($slider['text'] && $slider['image'])
                                    <button type="button" data-bs-target="#carouselHomePage" data-bs-slide-to="{{$loop->index}}" @if($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{$loop->index}}"></button>
                                @endif
                            @endforeach
                        </div>
                        <div class="carousel-inner py-3">
                            @foreach(theme_config('home.slider') as $slider)
                                @if($slider['text'] && $slider['image'])
                                    <div class="carousel-item @if($loop->first) active @endif" data-bs-interval="8000">
                                        <div class="position-relative">
                                            <img src="{{image_url($slider['image'])}}" alt="" class="w-100 slider-image">
                                            <div class="position-absolute top-0 end-0 start-0">
                                                <div>
                                                    <div class="position-absolute d-flex slider-title h-100">
                                                        <p class="my-auto mx-1 mx-md-3 text-primary fw-light">{{ $slider['text'] }}</p>
                                                    </div>
                                                    <img src="{{theme_asset('/image/slider_title_1.svg')}}" draggable="false" alt="Fond pour le titre" class="w-100 opacity-75">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHomePage" data-bs-slide="prev">
                    <span class="carousel-control carousel-control-prev-icon d-flex justify-content-center align-items-center" aria-hidden="true">
                        <svg class="text-primary" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#e9ad3d" d="M9.2945 18.9112C9.72155 18.7306 10 18.3052 10 17.8333V15H21C21.5523 15 22 14.5523 22 14V10C22 9.44772 21.5523 9 21 9H10V6.1667C10 5.69483 9.72155 5.26942 9.2945 5.08884C8.86744 4.90826 8.37588 5.00808 8.04902 5.34174L2.33474 11.175C1.88842 11.6307 1.88842 12.3693 2.33474 12.825L8.04902 18.6583C8.37588 18.9919 8.86744 19.0917 9.2945 18.9112Z"/>
                        </svg>
                    </span>
                                <span class="visually-hidden">Précédent</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselHomePage" data-bs-slide="next">
                    <span class="carousel-control carousel-control-next-icon d-flex justify-content-center align-items-center" aria-hidden="true">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#e9ad3d" d="M14.7055 18.9112C14.2784 18.7306 14 18.3052 14 17.8333V15H3C2.44772 15 2 14.5523 2 14V10C2 9.44772 2.44772 9 3 9H14V6.1667C14 5.69483 14.2784 5.26942 14.7055 5.08884C15.1326 4.90826 15.6241 5.00808 15.951 5.34174L21.6653 11.175C22.1116 11.6307 22.1116 12.3693 21.6653 12.825L15.951 18.6583C15.6241 18.9919 15.1326 19.0917 14.7055 18.9112Z"/>
                        </svg>
                    </span>
                                <span class="visually-hidden">Suivant</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="row d-flex flex-column gap-3">
                    <h2 class="text-center text-md-start text-uppercase last-news">Dernières nouveautés</h2>
                    <div class="d-flex flex-column gap-5 gap-md-4">
                        @foreach($posts->take(3) as $post)
                             <div class="article-wrapper d-flex  align-items-center justify-content-center gap-3">
                                <div class="article-img-wrapper">
                                    @if($post->hasImage())
                                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="article-img-top">
                                    @endif
                                </div>
                                <div class="w-100 d-flex flex-column">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <h3 class="article-title fw-bolder"><a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-uppercase"><u>{{ $post->title }}</u></a></h3>
                                        <span class="fw-bold"><u>{{format_date($post->published_at)}}</u></span>
                                    </div>
                                    <div class="article-text-wrapper">
                                        <p class="article-text mb-0">{{ Str::limit(strip_tags($post->content), 280) }}</p>
                                    </div>
                                    <div class="text-center text-md-end space">
                                        <a class="btn btn-primary btn-py" href="{{ route('posts.show', $post) }}">{{ trans('messages.posts.read') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                        <a href="{{route('posts.index')}}" class="text-center text-decoration-none text-uppercase"><u>Voir toutes les nouveautés</u></a>
                </div>
            </div>
            <div class="col-lg-4 px-3 mt-5 mt-lg-0">
                @includeIf('components.sidebar')
            </div>
        </div>

    </div>
@endsection
