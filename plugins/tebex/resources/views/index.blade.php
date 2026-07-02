@extends('layouts.app')

@section('title', setting("tebex.shop.title", trans("tebex::messages.shop")))

@section('content')
    <div class="row">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                @if(setting("tebex.shop.title"))
                    <h1>{{ setting("tebex.shop.title")}}</h1>
                @endif
                @if(setting("tebex.shop.subtitle"))
                    <h4>{{ setting("tebex.shop.subtitle") }}</h4>
                @endif
            </div>
        </div>

        <div class="col-lg-3">
            @include('tebex::categories._sidebar')
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">{!! setting('tebex.shop.home.message', trans('tebex::messages.home.placeholder')) !!}</div>
            </div>
        </div>
    </div>

    @include('tebex::packages.show')
@endsection

@push('scripts')
    @include('tebex::components.store.scripts')
@endpush
