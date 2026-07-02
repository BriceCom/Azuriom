@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@section('content')
    <div class="row">
        <div class="col-lg-9">
            @include('shop::categories._categories')
            <div class="card overflow-visible">
                <div class="card-body rounded-3">
                    {{ $welcome }}
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            @include('shop::categories._sidebar')
        </div>
    </div>
@endsection
