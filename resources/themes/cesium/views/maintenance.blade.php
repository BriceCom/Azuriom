@extends('layouts.app')

@section('content')

    <div class="container px-4 py-5 mx-auto mb-10 border rounded-2xl border-steel-200">
      <div class="flex">
         <div class="flex-shrink-0 my-auto">
            <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7842 5.2279C13.5737 3.57596 14.9685 2.75 16.5 2.75C18.0315 2.75 19.4263 3.57596 22.2157 5.2279L23.1593 5.78663C25.9487 7.43857 27.3435 8.26453 28.1093 9.625C28.875 10.9855 28.875 12.6374 28.875 15.9413V17.0587C28.875 20.3626 28.875 22.0146 28.1093 23.375C27.3435 24.7354 25.9487 25.5614 23.1593 27.2133L22.2157 27.7721C19.4263 29.424 18.0315 30.25 16.5 30.25C14.9685 30.25 13.5737 29.424 10.7842 27.7721L9.84076 27.2133C7.05128 25.5614 5.65653 24.7354 4.89077 23.375C4.125 22.0146 4.125 20.3626 4.125 17.0587V15.9413C4.125 12.6374 4.125 10.9855 4.89077 9.625C5.65653 8.26453 7.05128 7.43857 9.84076 5.78663L10.7842 5.2279ZM17.875 22C17.875 22.7594 17.2594 23.375 16.5 23.375C15.7406 23.375 15.125 22.7594 15.125 22C15.125 21.2406 15.7406 20.625 16.5 20.625C17.2594 20.625 17.875 21.2406 17.875 22ZM16.5 8.59375C17.0695 8.59375 17.5312 9.05546 17.5312 9.625V17.875C17.5312 18.4445 17.0695 18.9062 16.5 18.9062C15.9305 18.9062 15.4688 18.4445 15.4688 17.875V9.625C15.4688 9.05546 15.9305 8.59375 16.5 8.59375Z"></path>
            </svg>
         </div>
         <div class="flex items-center justify-between flex-1 ml-4 text-sm text-white">
            {{ $maintenanceMessage }}
         </div>
      </div>
   </div>


   <div class="container flex flex-col items-center justify-center px-6 py-8 mx-auto mb-10 border rounded-2xl border-steel-200">

         <h1 class="max-w-xl mb-4 text-xl font-semibold text-center text-white md:text-3xl">Désolé, notre site est indisponibles pour cause de maintenance.</h1>
         <svg class="h-32 md:h-64" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--twemoji" preserveAspectRatio="xMidYMid meet"><path fill="#FFCC4D" d="M36 15a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h28a4 4 0 0 1 4 4v8z"/><path d="M6 3H4a4 4 0 0 0-4 4v2l6-6zm6 0L0 15c0 1.36.682 2.558 1.72 3.28L17 3h-5zM7 19h5L28 3h-5zm16 0L35.892 6.108A3.995 3.995 0 0 0 33.64 3.36L18 19h5zm13-4v-3l-7 7h3a4 4 0 0 0 4-4z" fill="#292F33"/><path fill="#99AAB5" d="M4 19h5v14H4zm23 0h5v14h-5z"/></svg>

   </div>
@endsection
