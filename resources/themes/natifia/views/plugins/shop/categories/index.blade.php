@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-9">
                    @include('shop::categories._categories')
                    <div class="card">
                        <div class="card-body">
                            {{ $welcome }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    @include('shop::categories._sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
