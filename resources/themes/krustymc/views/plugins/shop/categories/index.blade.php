@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@section('content')
    <hgroup>
        <h1>{{ theme_config('shop.title') ?? trans('shop::messages.title') }}</h1>
        <p> {{ theme_config('shop.text') ?? theme_config('shop.text') }}</p>
    </hgroup>

    <div class="row">
        <div class="col-lg-3">
            @include('shop::categories._user')
            @include('shop::categories._sidebar')
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    {{ $welcome }}
                </div>
            </div>
        </div>
    </div>
@endsection
