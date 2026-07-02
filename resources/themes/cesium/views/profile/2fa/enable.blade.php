@extends('layouts.app')

@section('title', trans('messages.profile.2fa.title'))

@section('content')
<div class="container flex flex-col w-full col-span-12 mx-auto">
   <div class="relative z-50 grid w-full h-full grid-cols-1 gap-8 p-8 overflow-y-scroll border border-steel-200 md:p-16 rounded-2xl md:grid-cols-2 md:gap-16 md:overflow-hidden">
      <div class="order-2">
         <div class="flex flex-col items-center justify-center h-full">
            {{ $qrCode }}
         </div>
      </div>
      <div class="flex flex-col justify-center order-1 gap-8">
         <div class="flex flex-col">
            <h1 class="text-xl font-semibold text-white">{{ trans('messages.profile.2fa.title') }}</h1>
            <p class="text-xs text-steel-50">@lang('messages.profile.2fa.secret', ['secret' => $secret])</p>
         </div>
         <form action="{{ route('profile.2fa.enable') }}" method="POST" class="flex flex-col gap-8 bg-steel-300">
            @csrf
            <input type="hidden" name="2fa_key" value="{{ $secret }}">
            <label for="code_2fa" class="relative flex w-full py-4 border h-14 border-steel-200 hover:border-white rounded-xl">
            <input autocomplete="one-time-code" id="code_2fa" name="code" type="text" required autofocus class="block w-full h-full px-5 font-medium text-white truncate bg-transparent border-0 outline-none placeholder-steel-100 focus:ring-0 focus:outline-none focus:border-0 whitespace-nowrap overflow-ellipsis" placeholder="123 456">
            <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">123 456</span>
            </label>
            @error('code')
            <span class="text-xs font-semibold text-danger" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
            <button type="submit" class="gap-8 px-3 py-4 text-sm text-white bg-steel-400 hover:bg-steel-200 rounded-xl h-14">
            <i class="bi bi-shield-check"></i> {{ trans('messages.actions.enable') }}
            </button>
            <a class="flex items-center justify-center text-sm font-medium transition duration-300 cursor-pointer text-steel-100 hover:text-white" href="{{ route('profile.index') }}">
            <i class="bi bi-x-lg"></i> {{ trans('messages.actions.cancel') }}
            </a>
         </form>
      </div>
   </div>
</div>
@endsection