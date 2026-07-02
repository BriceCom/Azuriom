@extends('layouts.base')

@section('title', trans('messages.home'))

@php
    $showSidebar = !(
        theme_config('sidebar.buttons.off')
        && theme_config('sidebar.discord.off')
        && theme_config('sidebar.article.off')
        && theme_config('sidebar.vote.off')
    );
@endphp

@section('app')
    <main id="content" class="home-main d-flex flex-column gap-8 mb-15 pt-4 pt-md-6">
        <h1 class="d-none">{{ site_name() }}</h1>

        <div class="container">
           <div class="row gx-5 gy-5 align-items-start">
               @if($showSidebar)
                   <div class="col-lg-4">
                       <aside class="home-sidebar-stack d-flex flex-column gap-3">
                           <section data-aos="fade-left" data-aos-delay="80">@include('components.sidebar.buttons')</section>
                           <section data-aos="fade-left" data-aos-delay="110">@include('components.sidebar.top-vote')</section>
                           <section data-aos="fade-left" data-aos-delay="140">@include('components.sidebar.discord')</section>
                           <section data-aos="fade-left" data-aos-delay="170">@include('components.sidebar.hightlight-shop')</section>
                       </aside>
                   </div>
               @endif

               <div class="@if($showSidebar) col-lg-8 @else col-12 @endif">
                   <div class="home-flow d-flex flex-column gap-5">
                       @if(theme_config('home.cta.on'))
                           <section data-aos="fade-up" data-aos-delay="60">
                               @include('components.cta', [
                                   'icon' => theme_config('home.cta.icon') ?? 'bi bi-megaphone',
                                   'title' => theme_config('home.cta.title') ?? site_name(),
                                   'text' => theme_config('home.cta.text'),
                                   'button_text' => theme_config('home.cta.link.text'),
                                   'button_url' => theme_config('home.cta.link.url'),
                                   'image' => theme_config('home.cta.img')
                               ])
                           </section>
                       @endif

                       @if(theme_config('home.servers.on'))
                           <section data-aos="fade-up" data-aos-delay="90">
                               @include('components.servers')
                           </section>
                       @endif

                       @if(theme_config('home.video.trailer.off') !== 'on')
                           <section data-aos="fade-up" data-aos-delay="120">
                               @include('components.trailer')
                           </section>
                       @endif

                       @if(!theme_config('home.news.off'))
                           <section data-aos="fade-up" data-aos-delay="140">
                               @include('components.news')
                           </section>
                       @endif

                       @plugin('changelog')
                           @if(!theme_config('home.changelog.off'))
                               <section data-aos="fade-up" data-aos-delay="160">
                                   @include('components.changelog')
                               </section>
                          @endif
                       @endplugin
                   </div>
               </div>
           </div>
        </div>
    </main>
@endsection
