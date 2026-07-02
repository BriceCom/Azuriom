@extends('layouts.app')

@section('title', trans('wiki::messages.title'))

@section('content')
    @include('wiki::partials._header', ['title' => trans('wiki::messages.title')])

    <div id="wiki" class="mt-8 container mx-auto w-full col-span-12 flex flex-col">
        @foreach($categories as $category)



            <a class="mb-8" href="{{ route('wiki.show', $category) }}">
        <div class="flex flex-raw flex-shrink-0 items-center justify-between py-4 px-4  border-steel-200 border rounded-2xl overflow-hidden">
        <div class="flex justify-center items-center w-auto overflow-hidden">
            <div>
                
                <div class="h-10 w-10 flex justify-center items-center">
                <i class="text-white text-xl {{ $category->icon ?? 'bi bi-book' }}"></i>
                </div>
            </div>
            <div class="flex flex-col pl-4">
                
                    <div class="hs-tooltip inline-block [--trigger:hover] [--placement:bottom]">
                    <div class="hs-tooltip-toggle block text-left cursor-pointer">
                        <div class="font-semibold text-white truncate">
                            {{ $category->name }}
                        </div>
                    </div>
                    </div>
            </div>
        </div>
        </div>
        </a>

        @endforeach
    </div>
@endsection
