@extends('layouts.base')

@section('title', $post->title)
@section('description', $post->description)
@section('type', 'article')

@push('meta')
<meta property="og:article:author:username" content="{{ $post->author->name }}">
<meta property="og:article:published_time" content="{{ $post->published_at->toIso8601String() }}">
<meta property="og:article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
@endpush

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        <div class="bg-steel-100 mb-10 rounded-2xl col-span-12">
            <div
                class="flex flex-raw items-center justify-between py-6 px-8 bg-steel-200 rounded-t-2xl overflow-hidden">
                <div class="flex justify-center items-center w-auto overflow-hidden">
                    <div>
                        @if($post->hasImage())
                        <img class="absolute h-12 rounded-lg shadow-xl mx-auto z-50"
                            src="{{ $post->author->getAvatar(150) }}" alt="{{ $post->title }}">
                        @endif
                        <div class="h-12 w-12 bg-steel-300 flex justify-center items-center rounded-lg">
                            <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-full mr-4 text-ellipsis truncate">
                        <h4 class="text-white font-semibold">{{ $post->title }}</h4>
                        <p class="text-xs text-steel-50 font-medium">Posté le <span class="text-white">{{
                                date('d/m/y', strtotime($post->created_at)) }}</span> par
                            <span class="text-white">{{ $post->author->name }}</span>
                        </p>
                    </div>
                </div>
                <div>
                    <div class="flex flex-col justify-center items-center rounded-xl bg-steel-300 h-14 w-14">
                        <p class="text-sm font-semibold text-white">{{
                            date('d', strtotime($post->created_at)) }}</p>
                        <div class="rounded-full h-0.5 w-6 bg-steel-200"></div>
                        <p class="text-xs font-semibold text-white w-10 truncate text-center uppercase">{{
                            date('M', strtotime($post->created_at)) }}</p>
                    </div>
                </div>
            </div>
            <div class="p-8 space-y-6">
                <p class="text-white text-xs font-semibold">Dernière mise à jour : {{
                    format_date($post->updated_at) }}</p>
                <img class="h-full w-full rounded-xl shadow-xl mx-auto z-50 text-center text-transparent text-sm font-medium justify-center items-center flex object-cover m-h max-h-96"
                    alt="Image du poste" src="{{ $post->imageUrl() }}">
                {!! $post->content !!}
                <div>
                    <div class="flex flex-wrap gap-3">
                        <button type="button"
                            class="flex items-center px-3.5 py-2.5 bg-steel-300 rounded-xl cursor-pointer @if($post->isLiked()) bg-forest @endif"
                            @guest disabled @endguest data-like-url="{{ route('posts.like', $post) }}">
                            <svg class="h-4 w-4" width="34" height="30" viewBox="0 0 34 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 30C16.4982 29.9994 16.0082 29.8477 15.5938 29.5648C9.45392 25.3969 6.79533 22.5391 5.32892 20.7523C2.20392 16.9438 0.707826 13.0336 0.750013 8.79922C0.799232 3.94688 4.6922 0 9.42814 0C12.8719 0 15.257 1.93984 16.6461 3.55547C16.6901 3.60613 16.7445 3.64676 16.8055 3.6746C16.8666 3.70244 16.9329 3.71685 17 3.71685C17.0671 3.71685 17.1334 3.70244 17.1945 3.6746C17.2556 3.64676 17.3099 3.60613 17.3539 3.55547C18.743 1.93828 21.1281 0 24.5719 0C29.3078 0 33.2008 3.94688 33.25 8.8C33.2922 13.0352 31.7945 16.9453 28.6711 20.7531C27.2047 22.5398 24.5461 25.3977 18.4063 29.5656C17.9917 29.8482 17.5017 29.9996 17 30Z"
                                    fill="white"></path>
                            </svg>
                            <span class="ml-2 text-xs font-medium text-white">{{ $post->likes->count() }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection