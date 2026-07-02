@extends('layouts.app')

@section('title', trans('auth.passwords.confirm'))

@section('content')
<div class="container flex flex-col w-full col-span-12 mx-auto">
      <div class="relative z-50 w-full h-full gap-8 p-8 overflow-y-scroll border border-steel-200 md:p-16 rounded-2xl md:gap-16 md:overflow-hidden">
         <div class="flex flex-col justify-center gap-8">
            <div class="flex flex-col">
               <h1 class="text-xl font-semibold text-white">{{ trans('auth.passwords.confirm') }}</h1>
            </div>
            <form action="{{ route('password.confirm') }}" method="POST" class="flex flex-col gap-8 bg-steel-300">
               @csrf

               <label for="password" class="relative flex w-full py-4 border h-14 border-steel-200 hover:border-white rounded-xl">
               <input type="password" name="password" required id="password" class="block w-full h-full px-5 font-medium text-white truncate bg-transparent border-0 outline-none placeholder-steel-100 focus:ring-0 focus:outline-none focus:border-0 whitespace-nowrap overflow-ellipsis" autocomplete="current-password" placeholder="{{ trans('auth.password') }}">
               <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.password') }}</span>
               </label>
               @error('password')
                <span class="text-xs font-semibold text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


               <button type="submit" class="px-3 py-4 text-sm text-white bg-steel-400 hover:bg-steel-200 rounded-xl h-14">
                     {{ trans('auth.passwords.confirm') }}
               </button>


               <a class="flex items-center justify-center text-sm font-medium transition duration-300 cursor-pointer text-steel-100 hover:text-white" href="{{ route('password.request') }}">
               {{ trans('auth.forgot_password') }}
               </a>

            </form>
         </div>
      </div>
   </div>
@endsection
