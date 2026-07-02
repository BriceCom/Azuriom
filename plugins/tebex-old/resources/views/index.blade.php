@extends('layouts.app')

@section('title', setting("tebex.shop.title", trans("tebex::messages.shop")))

@section('content')

    @if(setting("tebex.shop.title"))
        <hgroup>
            @if(setting("tebex.shop.title"))
                <h1>{{ setting("tebex.shop.title")}}</h1>
            @endif
            @if(setting("tebex.shop.subtitle"))
                <p>{{ setting("tebex.shop.subtitle") }}</p>
            @endif
        </hgroup>
    @endif

    <div class="row" id="tebex">
        <div class="col-lg-3">
            @include('tebex::categories._sidebar')
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!! setting('tebex.shop.home.message', trans('tebex::messages.home.placeholder')) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
