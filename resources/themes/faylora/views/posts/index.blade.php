@extends('layouts.base')

@section('title', trans('messages.posts.posts'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        @include('elements.widgets.home_widget')
        <div class="w-full col-span-12 xl:col-span-9 xl:pl-10 mt-10 xl:mt-0">
            <div class="bg-steel-200 mb-10 rounded-2xl text-white font-semibold text-2xl truncate p-8 text-center">{{
                trans('messages.posts.posts') }}</div>
            @if(! $posts->isEmpty())
            @foreach($posts as $post)
            <div class="bg-steel-100 mb-10 rounded-2xl">
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
                    <img class="h-full w-full rounded-xl shadow-xl mx-auto z-50 text-center text-transparent text-sm font-medium justify-center items-center flex object-cover"
                        alt="Image du poste" src="{{ $post->imageUrl() }}">
                    {!! $post->content !!}
                    <div>
                        <div class="flex flex-wrap gap-3">
                            <a class="flex items-center px-3.5 py-2.5 bg-steel-300 rounded-xl cursor-pointer">
                                <svg class="h-4 w-4" width="34" height="30" viewBox="0 0 34 30" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 30C16.4982 29.9994 16.0082 29.8477 15.5938 29.5648C9.45392 25.3969 6.79533 22.5391 5.32892 20.7523C2.20392 16.9438 0.707826 13.0336 0.750013 8.79922C0.799232 3.94688 4.6922 0 9.42814 0C12.8719 0 15.257 1.93984 16.6461 3.55547C16.6901 3.60613 16.7445 3.64676 16.8055 3.6746C16.8666 3.70244 16.9329 3.71685 17 3.71685C17.0671 3.71685 17.1334 3.70244 17.1945 3.6746C17.2556 3.64676 17.3099 3.60613 17.3539 3.55547C18.743 1.93828 21.1281 0 24.5719 0C29.3078 0 33.2008 3.94688 33.25 8.8C33.2922 13.0352 31.7945 16.9453 28.6711 20.7531C27.2047 22.5398 24.5461 25.3977 18.4063 29.5656C17.9917 29.8482 17.5017 29.9996 17 30Z"
                                        fill="white"></path>
                                </svg>
                                <span class="ml-2 text-xs font-medium text-white">{{ $post->likes->count() }}</span>
                            </a>
                            <a href="{{ route('posts.show', $post) }}"
                                class="flex items-center px-3.5 py-2.5 bg-steel-300 rounded-xl cursor-pointer">
                                <svg class="h-4 w-4" width="28" height="36" viewBox="0 0 28 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.75 0.5H5.25C3.92436 0.501448 2.65343 1.0287 1.71607 1.96606C0.778697 2.90343 0.251448 4.17436 0.25 5.5V30.5C0.251448 31.8256 0.778697 33.0966 1.71607 34.0339C2.65343 34.9713 3.92436 35.4986 5.25 35.5H22.75C24.0756 35.4986 25.3466 34.9713 26.2839 34.0339C27.2213 33.0966 27.7486 31.8256 27.75 30.5V5.5C27.7486 4.17436 27.2213 2.90343 26.2839 1.96606C25.3466 1.0287 24.0756 0.501448 22.75 0.5ZM14 21.75H7.75C7.41848 21.75 7.10054 21.6183 6.86612 21.3839C6.6317 21.1495 6.5 20.8315 6.5 20.5C6.5 20.1685 6.6317 19.8505 6.86612 19.6161C7.10054 19.3817 7.41848 19.25 7.75 19.25H14C14.3315 19.25 14.6495 19.3817 14.8839 19.6161C15.1183 19.8505 15.25 20.1685 15.25 20.5C15.25 20.8315 15.1183 21.1495 14.8839 21.3839C14.6495 21.6183 14.3315 21.75 14 21.75ZM20.25 15.5H7.75C7.41848 15.5 7.10054 15.3683 6.86612 15.1339C6.6317 14.8995 6.5 14.5815 6.5 14.25C6.5 13.9185 6.6317 13.6005 6.86612 13.3661C7.10054 13.1317 7.41848 13 7.75 13H20.25C20.5815 13 20.8995 13.1317 21.1339 13.3661C21.3683 13.6005 21.5 13.9185 21.5 14.25C21.5 14.5815 21.3683 14.8995 21.1339 15.1339C20.8995 15.3683 20.5815 15.5 20.25 15.5ZM20.25 9.25H7.75C7.41848 9.25 7.10054 9.1183 6.86612 8.88388C6.6317 8.64946 6.5 8.33152 6.5 8C6.5 7.66848 6.6317 7.35054 6.86612 7.11612C7.10054 6.8817 7.41848 6.75 7.75 6.75H20.25C20.5815 6.75 20.8995 6.8817 21.1339 7.11612C21.3683 7.35054 21.5 7.66848 21.5 8C21.5 8.33152 21.3683 8.64946 21.1339 8.88388C20.8995 9.1183 20.5815 9.25 20.25 9.25Z"
                                        fill="white"></path>
                                </svg>
                                <span class="ml-2 text-xs font-medium text-white">Lire plus</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</main>
@endsection