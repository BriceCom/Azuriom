@extends('layouts.app')

@section('title', trans('auth.login'))

@section('content')
<div class="container mx-auto w-full col-span-12 flex flex-col">
<div class="w-full border-steel-200 border rounded-2xl p-8 mt-10">
      <div class="grid divide-y divide-steel-200">
         <div class="flex flex-wrap items-start -mx-4">
            <div class="w-full sm:w-1/4 px-4 mb-8 sm:mb-0">
               <span class="block text-sm font-medium text-white">2FA</span>
               <p class="text-xs text-steel-50 mt-1">Activer l'authentification à deux facteurs</p>
            </div>
            <form action="{{ route('login.2fa') }}" method="POST" class="w-full sm:w-3/4 px-4">
                @csrf
               <div class="flex flex-wrap -mx-4 -mb-10">
                  <div class="w-full lg:w-1/2 px-4 mb-8">
                     <label class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl transition duration-200">
                     <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.2fa.code') }}</span>
                     <input autofocus autocomplete="one-time-code" id="code" name="code" class="h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 px-5" type="text" value="" placeholder="{{ trans('auth.2fa.code') }}" required="" maxlength="6">
                     </label>
                  </div>
                  @error('code')
                    <span class="text-danger text-xs font-semibold" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  <div class="w-full lg:w-1/2 px-4 mb-10">
                     <button type="submit" class="w-full bg-steel-400 py-4 px-4 text-white text-md rounded-xl transition duartion-200 hover:bg-steel-200">Activer l'authentification à deux facteurs</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
