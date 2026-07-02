@extends('layouts.base')

@section('title', 'Dedipass')

@push('scripts')
<script src="https://api.dedipass.com/v1/pay.js" defer></script>
@endpush

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        <div class="w-full col-span-12 rounded-2xl bg-steel-100">
            <div class="flex flex-col py-8 px-8 bg-steel-200 rounded-2xl overflow-hidden gap-8">
                <div class="flex flex-raw items-center justify-between w-full">
                    <div class="flex justify-center items-center w-auto overflow-hidden">
                        <div>
                            <img class="absolute h-10 rounded-lg shadow-xl mx-auto z-50"
                                src="{{ auth()->user()->getAvatar(150) }}">
                            <div class="h-10 w-10 bg-steel-300 flex justify-center items-center rounded-lg">
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
                            <h4 class="text-white font-semibold text-xs truncate">{{ auth()->user()->name }}</h4>
                        </div>
                    </div>
                    <div>
                        <div
                            class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-12 pl-5 pr-3 text-white">
                            <p class="text-white text-sm font-semibold mr-2 ml-3">{{ auth()->user()->money }}</p>
                            <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2 mr-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full col-span-12 mt-10">
            <div class="bg-steel-100 rounded-2xl">
                <div class="flex overflow-x-hidden items-center justify-start py-2 px-8 bg-steel-200 rounded-t-2xl">
                    <div class="flex justify-center items-center w-auto">
                        <img class="rounded-lg mx-auto z-50 w-24" src="{{ theme_asset('img/chest.png') }}">
                        <div class="ml-6 w-full mr-4 text-ellipsis truncate">
                            <h1 class="text-white font-semibold text-2xl truncate">Créditer mon compte</h1>
                            <p class="text-xs text-steel-50 font-medium truncate">Créditer votre compte pour acheter sur
                                notre
                                boutique</p>
                        </div>
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    <div data-dedipass="{{ $dedipassPublicKey }}" data-dedipass-custom="{{ $dedipassCustom }}"
                        class="rounded-md"></div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection