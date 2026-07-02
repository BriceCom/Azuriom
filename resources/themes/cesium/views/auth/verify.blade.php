@extends('layouts.app')

@section('title', trans('auth.verify'))

@section('content')
@if (session('resent'))
<div class="container px-4 py-3.5 mx-auto mb-10 border rounded-2xl border-steel-200" role="alert">
      <div class="flex">
         <div class="flex-shrink-0 my-auto">
            <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7842 5.2279C13.5737 3.57596 14.9685 2.75 16.5 2.75C18.0315 2.75 19.4263 3.57596 22.2157 5.2279L23.1593 5.78663C25.9487 7.43857 27.3435 8.26453 28.1093 9.625C28.875 10.9855 28.875 12.6374 28.875 15.9413V17.0587C28.875 20.3626 28.875 22.0146 28.1093 23.375C27.3435 24.7354 25.9487 25.5614 23.1593 27.2133L22.2157 27.7721C19.4263 29.424 18.0315 30.25 16.5 30.25C14.9685 30.25 13.5737 29.424 10.7842 27.7721L9.84076 27.2133C7.05128 25.5614 5.65653 24.7354 4.89077 23.375C4.125 22.0146 4.125 20.3626 4.125 17.0587V15.9413C4.125 12.6374 4.125 10.9855 4.89077 9.625C5.65653 8.26453 7.05128 7.43857 9.84076 5.78663L10.7842 5.2279ZM17.875 22C17.875 22.7594 17.2594 23.375 16.5 23.375C15.7406 23.375 15.125 22.7594 15.125 22C15.125 21.2406 15.7406 20.625 16.5 20.625C17.2594 20.625 17.875 21.2406 17.875 22ZM16.5 8.59375C17.0695 8.59375 17.5312 9.05546 17.5312 9.625V17.875C17.5312 18.4445 17.0695 18.9062 16.5 18.9062C15.9305 18.9062 15.4688 18.4445 15.4688 17.875V9.625C15.4688 9.05546 15.9305 8.59375 16.5 8.59375Z"></path>
            </svg>
         </div>
         <div class="flex items-center justify-between flex-1 ml-4">
            <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
            
            {{ trans('auth.verification.sent') }}
            
            </p>
            <p class="my-auto text-sm md:mt-0 md:ml-6">
               <form method="POST" action="{{ route('verification.resend') }}">
                     @csrf
                     <button type="submit" class="flex px-4 py-2.5 text-xs font-medium text-white rounded-xl bg-steel-200 hover:bg-steel-100 transition duration-200">
                         {{ trans('auth.verification.resend') }}
                     </button>
                 </form>
            </p>
         </div>
      </div>
   </div>
@endif
<div class="container flex flex-col w-full col-span-12 mx-auto">
      <div class="relative z-50 grid w-full h-full gap-8 p-8 overflow-y-scroll border border-steel-200 md:p-16 rounded-2xl md:gap-16 md:overflow-hidden">
         <div class="flex flex-col justify-center gap-8">
            <div class="flex flex-col">
               <h1 class="text-xl font-semibold text-white">{{ trans('auth.verify') }}</h1>
            </div>
            <div class="flex flex-col gap-2">
            <p class="text-xs text-white">{{ trans('auth.verification.check') }}</p>
            <p class="text-xs text-white">{{ trans('auth.verification.request') }}</p>
            </div>
         </div>
      </div>
   </div>
@endsection
