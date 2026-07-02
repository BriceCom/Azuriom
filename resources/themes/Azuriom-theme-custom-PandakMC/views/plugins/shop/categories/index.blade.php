@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@section('content')
    <h1>{{ trans('shop::messages.title') }}</h1>

    <div class="row">
        <div class="col-12">
            <div class="list-group d-flex flex-md-row my-5">
                @if($displayHome)
                    <a href="{{ route('shop.home') }}" class="list-group-item py-2 @if($category === null)  fw-semibold active @endif">
                        {{ trans('messages.home') }}
                    </a>
                @endif

                @foreach($categories as $subCategory)
                    <a href="{{ route('shop.categories.show', $subCategory) }}"
                       class="list-group-item py-2 @if($subCategory->is($category))  fw-semibold active @endif">
                        {{ $subCategory->name }}
                    </a>

                    @foreach($subCategory->categories as $cat)
                        <a href="{{ route('shop.categories.show', $cat) }}"
                           class="list-group-item py-2 @if($cat->is($category))  fw-semibold active @endif">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                @endforeach
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $welcome }}
                </div>
            </div>
        </div>
    </div>
@endsection
