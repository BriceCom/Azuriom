@extends('layouts.app')
@section('title', trans('messages.profile.2fa.title'))
@section('content')
<div class="container flex flex-col w-full col-span-12 mx-auto">
   <div class="relative z-50 w-full h-full gap-8 p-8 overflow-y-scroll border border-steel-200 md:p-16 rounded-2xl md:gap-16 md:overflow-hidden">
      <div class="flex flex-col justify-center gap-8">
         <div class="flex flex-col">
            <h1 class="text-xl font-semibold text-white">{{ trans('messages.profile.2fa.title') }}</h1>
         </div>
         <form action="{{ route('profile.2fa.disable') }}" method="POST" class="flex flex-col gap-8 bg-steel-300">
            @if($user->two_factor_recovery_codes !== null)
            <p>
               <a data-bs-toggle="collapse" href="#codesCollapse" role="button" aria-expanded="false" aria-controls="codesCollapse">
               {{ trans('messages.profile.2fa.codes') }}
               </a>
            </p>
            <div id="codesCollapse" class="flex flex-col gap-8">
               <ul class="text-xs text-white">
                  @foreach($user->two_factor_recovery_codes ?? [] as $code)
                  <li>
                     <samp>{{ $code }}</samp>
                  </li>
                  @endforeach
               </ul>
               <a href="{{ route('profile.2fa.codes') }}" class="gap-8 px-3 py-4 text-sm text-white bg-steel-400 hover:bg-steel-200 rounded-xl h-14" download="{{ $codesBackupName }}">
               <i class="bi bi-download"></i> {{ trans('messages.actions.download') }}
               </a>
            </div>
            @endif
            @csrf
            <button type="submit" class="gap-8 px-3 py-4 text-sm text-white bg-steel-400 hover:bg-steel-200 rounded-xl h-14">
            <i class="bi bi-shield-slash"></i> {{ trans('messages.profile.2fa.disable') }}
            </button>
         </form>
      </div>
   </div>
</div>
<a class="hidden w-5 h-5" href="{{ route('profile.index') }}">
<i class="bi bi-arrow-left"></i> {{ trans('messages.actions.back') }}
</a>
@endsection