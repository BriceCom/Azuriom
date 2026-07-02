@extends('layouts.base')

@section('title', trans('paysafecardmanual::messages.title'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        <div class="w-full col-span-12 rounded-2xl bg-steel-100">
            @if(session('success'))
            <div class="flex w-full py-4 px-5 bg-forest rounded-2xl text-white text-sm justify-between" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="flex w-full py-4 px-5 bg-danger rounded-2xl text-white text-sm justify-between" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div id="status-message"></div>
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
                    <div class="flex flex-col">
                        <span class="text-white font-semibold md:text-2xl text-lg truncate">{{
                            trans('paysafecardmanual::messages.title') }}</span>
                        <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                    </div>
                    <form action="{{ route('paysafecardmanual.pay') }}" method="POST"
                        class="bg-steel-100 flex flex-col gap-8">
                        @csrf

                        <div class="relative bg-inherit">
                            <input type="text" id="code" name="code"
                                placeholder="{{ trans('paysafecardmanual::messages.fields.pin') }}"
                                value="{{ old('code') }}"
                                class="peer bg-transparent h-14 w-full rounded-xl text-white placeholder-transparent px-4 border-white/20 focus:border-white/50 focus:outline-none font-display font-medium text-sm border transition duration-300 @error('code') is-invalid @enderror"
                                required="" autofocus>
                            <label for="code"
                                class="mt-2.5 absolute cursor-text left-0 -top-5 text-sm text-white/30 bg-inherit mx-2 px-2 peer-placeholder-shown:text-sm peer-placeholder-shown:text-white/30 peer-placeholder-shown:top-2 peer-focus:-top-5 peer-focus:text-white/30 peer-focus:text-sm transition-all font-display font-medium @error('code') is-invalid @enderror">{{
                                trans('paysafecardmanual::messages.fields.pin') }}</label>
                            @error('code')
                            <span class="text-danger text-sm" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="bg-primary px-3 py-4 rounded-xl text-white h-14 text-sm"
                            data-ripple-dark="true">
                            {{ trans('messages.actions.send') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection