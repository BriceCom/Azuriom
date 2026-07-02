@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@section('content')
    <h1>{{ trans('shop::messages.title') }}</h1>

    <div class="row">
        <div class="col-lg-3">
            <div class="list-group mb-3">
                @if($displayHome)
                    <a href="{{ route('shop.home') }}" class="list-group-item @if($category === null) active @endif">
                        {{ trans('messages.home') }}
                    </a>
                @endif

                @foreach($categories as $subCategory)
                    <a href="{{ route('shop.categories.show', $subCategory) }}" class="list-group-item @if($subCategory->is($category)) active @endif">
                        {{ $subCategory->name }}
                    </a>

                    @foreach($subCategory->categories as $cat)
                        <a href="{{ route('shop.categories.show', $cat) }}" class="list-group-item ps-5 @if($cat->is($category)) active @endif">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                @endforeach
            </div>
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
