@extends('layouts.app')

@section('title', trans('shop::messages.title'))

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row gap-10" id="shop">
            <div class="min-w-[380px] order-2 lg:order-1">
                @include('shop::categories._sidebar')
            </div>

            <div class="card h-fit grow order-1">

                <div class="mb-16">
                    <h1 class="text-lg font-medium mb-2">{{ trans('shop::messages.title') }}</h1>
                </div>

                {{ $welcome }}
            </div>
        </div>
    </div>
@endsection
