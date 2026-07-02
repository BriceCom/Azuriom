@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')
    <div class="container">
       <div class="row mb-4">
           <div class="col-md-6 offset-md-3">
            <div class="margin-top-40"></div>
               <div class="card has-icon fadeIn">
                <div class="icon">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                   <div class="card-body" align="center">
                        <h2>{{ config('theme.welcome_title') }}</h2>
                        <p align="justify">
                        {{ config('theme.welcome_text') }}
                        </p>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="white-segment py-4">
       <div class="container">
           <div class="row mb-4">
               <div class="col-md-4">
                   <div class="card toSlideInRight toAnimate" align="center">
                       <div class="card-body">
                           <h1 class="playercount colorMaj">0</h1>
                           <h6>JOUEURS EN LIGNE</h6>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="card toFadeIn toAnimate" align="center">
                       <div class="card-body">
                           <h1 class="colorMaj">{{ config('theme.unique_players') }}</h1>
                           <h6>JOUEURS UNIQUES</h6>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="card toSlideInLeft toAnimate" align="center">
                       <div class="card-body">
                           <h1 class="colorMaj discordcount">15000+</h1>
                           <h6 >MEMBRES DISCORD</h6>
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://platform.twitter.com/widgets.js" async></script>
@endpush


