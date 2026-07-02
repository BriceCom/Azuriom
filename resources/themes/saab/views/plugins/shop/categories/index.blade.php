@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('shop::categories._top-bar')
        </div>

        <div>
            @include('shop::categories._user-infos')
        </div>

        <div class="col-lg-3">
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
