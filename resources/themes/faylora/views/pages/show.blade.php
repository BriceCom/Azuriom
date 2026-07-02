@extends('layouts.base')

@section('title', $page->title)
@section('description', $page->description)

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        <div class="bg-steel-100 rounded-2xl col-span-12">
            <div class="flex overflow-x-hidden items-center justify-start py-2 px-8 bg-steel-200 rounded-t-2xl">
                <div class="flex justify-center items-center w-auto">
                    <img class="rounded-lg mx-auto z-50 w-24" src="{{ theme_asset('img/book.png') }}">
                    <div class="ml-6 w-full mr-4 text-ellipsis truncate">
                        <h1 class="text-white font-semibold text-2xl truncate">{{ $page->title }}</h1>
                        <p class="text-xs text-steel-50 font-medium truncate">{{ $page->description }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="p-8 space-y-6">
                <p class="text-white text-xs font-semibold">Dernière mise à jour : {{ date('d/m/y' ,
                    strtotime($page->updated_at)) }}</p>
                {!! $page->content !!}
            </div>
        </div>
    </div>
</main>
@endsection