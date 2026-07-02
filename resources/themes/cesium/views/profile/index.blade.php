@extends('layouts.app')
@section('title', trans('messages.profile.title'))
@section('content')
<div class="container mx-auto w-full col-span-12 flex flex-col">
@if($canVerifyEmail)
@if (session('resent'))
<div class="container  py-3.5 mx-auto mb-10 border rounded-2xl border-steel-200" role="alert">
   <div class="flex">
      <div class="flex-shrink-0 my-auto">
         <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
            <path xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM15.7071 9.29289C16.0976 9.68342 16.0976 10.3166 15.7071 10.7071L12.0243 14.3899C11.4586 14.9556 10.5414 14.9556 9.97568 14.3899L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929C8.68342 10.9024 9.31658 10.9024 9.70711 11.2929L11 12.5858L14.2929 9.29289C14.6834 8.90237 15.3166 8.90237 15.7071 9.29289Z" fill="#323232"/>
         </svg>
      </div>
      <div class="flex items-center justify-between flex-1 ml-4">
         <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
            {{ trans('auth.verification.sent') }} 
         </p>
         <p class="my-auto text-sm md:mt-0 md:ml-6">
            <a class="flex  py-2.5 text-xs font-medium text-white rounded-xl bg-steel-200 hover:bg-steel-100 transition duration-200" href="{{ route('login') }}">
               <svg class="w-5 h-5 my-auto mr-2 fill-white" width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M19.25 7.25676C19.25 10.298 16.7744 12.7635 13.7206 12.7635C13.1634 12.7635 11.8947 12.6354 11.2774 12.1232L10.5059 12.8916C10.0523 13.3434 10.1748 13.4764 10.3765 13.6955C10.4607 13.7869 10.5588 13.8933 10.6345 14.0442C10.6345 14.0442 11.2774 14.9406 10.6345 15.8371C10.2487 16.3493 9.16851 17.0664 7.9341 15.8371L7.67692 16.0932C7.67692 16.0932 8.44846 16.9896 7.80551 17.8861C7.41974 18.3984 6.39103 18.9106 5.4909 18.0142L4.59078 18.9106C3.97354 19.5253 3.21917 19.1667 2.91914 18.9106L2.14761 18.1422C1.4275 17.425 1.84756 16.6481 2.14761 16.3493L8.83426 9.69001C8.83426 9.69001 8.19131 8.66546 8.19131 7.25676C8.19131 4.21546 10.6669 1.75 13.7206 1.75C16.7744 1.75 19.25 4.21546 19.25 7.25676ZM13.7209 9.17779C14.7861 9.17779 15.6496 8.31776 15.6496 7.25684C15.6496 6.19592 14.7861 5.33587 13.7209 5.33587C12.6556 5.33587 11.792 6.19592 11.792 7.25684C11.792 8.31776 12.6556 9.17779 13.7209 9.17779Z"></path>
               </svg>
               <span class="my-auto tracking-wide">Connexion</span>
            </a>
         </p>
      </div>
   </div>
</div>
@endif
<div class="container  py-3.5 mx-auto mb-10 border rounded-2xl  border-steel-200" role="alert">
   <div class="flex">
      <div class="flex-shrink-0 my-auto">
         <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7842 5.2279C13.5737 3.57596 14.9685 2.75 16.5 2.75C18.0315 2.75 19.4263 3.57596 22.2157 5.2279L23.1593 5.78663C25.9487 7.43857 27.3435 8.26453 28.1093 9.625C28.875 10.9855 28.875 12.6374 28.875 15.9413V17.0587C28.875 20.3626 28.875 22.0146 28.1093 23.375C27.3435 24.7354 25.9487 25.5614 23.1593 27.2133L22.2157 27.7721C19.4263 29.424 18.0315 30.25 16.5 30.25C14.9685 30.25 13.5737 29.424 10.7842 27.7721L9.84076 27.2133C7.05128 25.5614 5.65653 24.7354 4.89077 23.375C4.125 22.0146 4.125 20.3626 4.125 17.0587V15.9413C4.125 12.6374 4.125 10.9855 4.89077 9.625C5.65653 8.26453 7.05128 7.43857 9.84076 5.78663L10.7842 5.2279ZM17.875 22C17.875 22.7594 17.2594 23.375 16.5 23.375C15.7406 23.375 15.125 22.7594 15.125 22C15.125 21.2406 15.7406 20.625 16.5 20.625C17.2594 20.625 17.875 21.2406 17.875 22ZM16.5 8.59375C17.0695 8.59375 17.5312 9.05546 17.5312 9.625V17.875C17.5312 18.4445 17.0695 18.9062 16.5 18.9062C15.9305 18.9062 15.4688 18.4445 15.4688 17.875V9.625C15.4688 9.05546 15.9305 8.59375 16.5 8.59375Z"></path>
         </svg>
      </div>
      <div class="flex items-center justify-between flex-1 ml-4">
         <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
            {{ trans('messages.profile.email_verification') }}, {{ trans('auth.verification.request') }}
         </p>
         <p class="my-auto text-sm md:mt-0 md:ml-6">
         <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="flex  py-2.5 text-xs font-medium text-white rounded-xl bg-steel-200 hover:bg-steel-100 transition duration-200">
               <svg class="w-5 h-5 my-auto mr-2 fill-white" width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M19.25 7.25676C19.25 10.298 16.7744 12.7635 13.7206 12.7635C13.1634 12.7635 11.8947 12.6354 11.2774 12.1232L10.5059 12.8916C10.0523 13.3434 10.1748 13.4764 10.3765 13.6955C10.4607 13.7869 10.5588 13.8933 10.6345 14.0442C10.6345 14.0442 11.2774 14.9406 10.6345 15.8371C10.2487 16.3493 9.16851 17.0664 7.9341 15.8371L7.67692 16.0932C7.67692 16.0932 8.44846 16.9896 7.80551 17.8861C7.41974 18.3984 6.39103 18.9106 5.4909 18.0142L4.59078 18.9106C3.97354 19.5253 3.21917 19.1667 2.91914 18.9106L2.14761 18.1422C1.4275 17.425 1.84756 16.6481 2.14761 16.3493L8.83426 9.69001C8.83426 9.69001 8.19131 8.66546 8.19131 7.25676C8.19131 4.21546 10.6669 1.75 13.7206 1.75C16.7744 1.75 19.25 4.21546 19.25 7.25676ZM13.7209 9.17779C14.7861 9.17779 15.6496 8.31776 15.6496 7.25684C15.6496 6.19592 14.7861 5.33587 13.7209 5.33587C12.6556 5.33587 11.792 6.19592 11.792 7.25684C11.792 8.31776 12.6556 9.17779 13.7209 9.17779Z"></path>
               </svg>
               <span class="my-auto tracking-wide">{{ trans('auth.verification.resend') }}</span>
            </button>
         </form>
         </p>
      </div>
   </div>
</div>
@endif
<div class="flex flex-raw flex-shrink-0 items-center justify-between py-4 px-4  border-steel-200 border rounded-2xl overflow-hidden">
   <div class="flex justify-center items-center w-auto overflow-hidden">
      <div>
         <img class="absolute h-10 rounded-lg shadow-xl mx-auto z-10 text-transparent" src="{{ $user->getAvatar(150) }}" alt="{{ $user->name }}">
         <div class="h-10 w-10 bg-steel-300 flex justify-center items-center rounded-lg">
            <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
               <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
               <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
               </path>
            </svg>
         </div>
      </div>
      <div class="flex flex-col pl-4">
         
            <div class="hs-tooltip inline-block [--trigger:hover] [--placement:bottom]">
               <div class="hs-tooltip-toggle block text-left cursor-pointer">
                  <div class="font-semibold text-white truncate">
                     {{ $user->name }}
                     <span class="my-auto badge text-xs rounded px-1 py-0.5" style="{{ $user->role->getBadgeStyle() }};">{{ $user->role->name }}</span>
                  </div>
                  <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 max-w-xs cursor-default bg-steel-200 divide-y divide-steel-100 shadow-lg rounded-xl" role="tooltip">
                     <div class="p-4 sm:p-5">
                        <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                           <div class="flex-shrink-0">
                              <img class="absolute z-50 h-6 mx-auto text-transparent rounded-full shadow-xl" src="{{ $user->getAvatar(150) }}" alt="{{ $user->name }}">
                              <div class="flex items-center justify-center w-6 h-6 rounded-full bg-steel-300">
                                 <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                 </svg>
                              </div>
                           </div>
                           <div class="grow flex">
                              <p class="text-sm font-semibold text-white my-auto">
                                 {{ $user->name }}
                              </p>
                              <div class="bg-steel-100 px-1.5 py-0.5 my-auto ml-1.5 text-xs text-white rounded font-semibold" style="{{ $user->role->getBadgeStyle() }};">
                                 <!--- role --->
                                 {{ $user->role->name }}
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <ul class="text-xs text-steel-50">
               <li class="inline-block relative last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-steel-50 before:rounded-full">
                  {{ $user->email }}
               </li>
            </ul>
         
      </div>
   </div>
   <div class="md:w-28 w-20 justify-end items-end overflow-hidden truncate">
      <div class="relative flex flex-raw items-center md:rounded-xl rounded-lg border border-steel-200 md:h-12 h-10 text-white w-full truncate overflow-hidden justify-center">
         <p class="text-white text-sm font-semibold truncate break-all md:mr-14 mr-10 md:ml-4 ml-3">{{ $user->money }}</p>
         <img src="{{ theme_asset('static/coin.png') }}" class="absolute md:h-7 md:w-7 w-5 h-5 right-4">
      </div>
   </div>
</div>
<div class="grid md:grid-cols-2 grid-cols-1 w-full border-steel-200 border rounded-2xl mt-10">
   <div class="flex justify-center items-center">
      <canvas id="skin_container" data-name="{{ $user->name }}"></canvas>
   </div>
   <div class="flex flex-col w-full px-10 md:pt-10 pt-0 pb-10">
   
            <h1 class="text-md font-medium text-white mb-4">{{ trans('messages.notifications.info') }}</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
               <div class="flex relative w-full h-14 py-4 px-2 border border-steel-200 hover:border-white rounded-xl cursor-not-allowed">
                  <div class="font-medium text-white pl-3 my-auto h-full justify-start items-center flex truncate whitespace-nowrap overflow-ellipsis">
                     {{ $user->name }}
                  </div>
                  <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.name') }}</span>
               </div>
               @if($user->game_id)
               <div class="flex relative w-full h-14 py-4 px-2 border border-steel-200 hover:border-white rounded-xl cursor-not-allowed">
                  <div class="font-medium text-white pl-3 my-auto h-full justify-start items-center flex truncate whitespace-nowrap overflow-ellipsis">
                     {{ $user->game_id }}
                  </div>
                  <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">UUID</span>
               </div>
               @endif
               <div class="flex relative w-full h-14 py-4 px-2 border border-steel-200 hover:border-white rounded-xl cursor-not-allowed">
                  <div class="font-medium text-white pl-3 my-auto h-full justify-start items-center flex truncate whitespace-nowrap overflow-ellipsis">
                     {{ format_date($user->created_at, true) }}
                  </div>
                  <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('messages.fields.date') }}</span>
               </div>
               <div class="flex relative w-full h-14 py-4 px-2 border border-steel-200 hover:border-white rounded-xl cursor-not-allowed">
                  <div class="font-medium text-white pl-3 my-auto h-full justify-start items-center flex truncate whitespace-nowrap overflow-ellipsis">
                     {{ $user->money }}
                  </div>
                  <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('messages.fields.money') }}</span>
               </div>
               <div class="flex relative w-full h-14 py-4 px-2 border border-steel-200 hover:border-white rounded-xl cursor-not-allowed">
                  <div class="font-medium text-white pl-3 my-auto h-full justify-start items-center flex truncate whitespace-nowrap overflow-ellipsis">
                     {{ $user->role->name }}
                  </div>
                  <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('messages.fields.role') }}</span>
               </div>
               <div class="flex relative w-full h-14 py-4 px-2 border border-steel-200 hover:border-white rounded-xl cursor-not-allowed">
                  <div class="font-medium text-white pl-3 my-auto h-full justify-start items-center flex truncate whitespace-nowrap overflow-ellipsis">
                     {{ trans('messages.lang') }}
                  </div>
                  <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('admin.settings.index.locale') }}</span>
               </div>
            </div>
         </div>
</div>
<div class="w-full border-steel-200 border rounded-2xl mt-10">
   <div class="grid divide-y divide-steel-200 gap-8 rounded-2xl pb-8 px-8">









      <div class="flex flex-wrap items-start pt-8">
         <div class="w-full sm:w-1/4 mb-8 sm:mb-0 sm:pr-8">
            <span class="block text-sm font-medium text-white">{{ trans('auth.email') }}</span>
            <p class="text-xs text-steel-100 mt-1">Votre adresse email est utilisée pour la reception des notifications.</p>
         </div>
         <form action="{{ route('profile.email') }}" method="POST" class="w-full sm:w-3/4 mb-10">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 -mb-10">
               <div class="flex flex-col w-full">
                  <label for="email" class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl">
                     <input type="email" name="email" id="email" class="px-5 h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis" value="{{ old('email', $user->email ?? '') }}" placeholder="{{ trans('auth.email') }}" required>
                     <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.email') }}</span>
                  </label>
                  @error('email')
                  <span class="text-danger text-xs pr-12 mt-2 font-semibold flex items-center truncate" role="alert">
                     <svg class="flex-shrink-0 h-4 w-4 fill-danger my-auto mr-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.84308 3.80211C9.8718 2.6007 10.8862 2 12 2C13.1138 2 14.1282 2.6007 16.1569 3.80211L16.8431 4.20846C18.8718 5.40987 19.8862 6.01057 20.4431 7C21 7.98943 21 9.19084 21 11.5937V12.4063C21 14.8092 21 16.0106 20.4431 17C19.8862 17.9894 18.8718 18.5901 16.8431 19.7915L16.1569 20.1979C14.1282 21.3993 13.1138 22 12 22C10.8862 22 9.8718 21.3993 7.84308 20.1979L7.15692 19.7915C5.1282 18.5901 4.11384 17.9894 3.55692 17C3 16.0106 3 14.8092 3 12.4063V11.5937C3 9.19084 3 7.98943 3.55692 7C4.11384 6.01057 5.1282 5.40987 7.15692 4.20846L7.84308 3.80211ZM13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16ZM12 6.25C12.4142 6.25 12.75 6.58579 12.75 7V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V7C11.25 6.58579 11.5858 6.25 12 6.25Z"/>
                     </svg>
                     {{ $message }}
                  </span>
                  @enderror
               </div>
               <label for="password" class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl">
                  <input type="password" name="email_confirm_pass" name="email" id="password" class="px-5 h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis" placeholder="{{ trans('auth.current_password') }}" required>
                  <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.current_password') }}</span>
               </label>
               <button type="submit" class="h-14 w-full bg-steel-400 py-4 px-4 text-white text-md rounded-xl transition duartion-200 hover:bg-steel-200 truncate">{{ trans('messages.profile.change_email') }}</button>
            </div>
         </form>
      </div>

      


<?php 
$pluginManager = app(\Azuriom\Extensions\Plugin\PluginManager::class);
$plugins = $pluginManager->plugins();
?>



@foreach ($plugins as $plugin)
@if ($plugin->id == 'shop')
      <div class="flex flex-wrap items-start pt-8">
         <div class="w-full sm:w-1/4 mb-8 sm:mb-0 sm:pr-8">
            <span class="block text-sm font-medium text-white">{{ trans('shop::messages.title') }}</span>
            <p class="text-xs text-steel-100 mt-1">{{ trans('shop::messages.profile.payments_desc') }}</p>
         </div>
         <div class="w-full sm:w-3/4">
            <div class="flex flex-wrap">
               <div class="w-full">
                  <div class="overflow-x-auto">
                     <a href="{ route('shop.profile') }" class="py-4 px-2 flex justify-center bg-steel-400 text-white text-md rounded-xl transition duartion-200 hover:bg-steel-200">
                     {{ trans('shop::messages.profile.payments') }}
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endif
@endforeach



      @if(! oauth_login())
      <div class="flex flex-wrap items-start pt-8">
         <div class="w-full sm:w-1/4 mb-8 sm:mb-0 sm:pr-8">
            <span class="block text-sm font-medium text-white">{{ trans('messages.profile.change_password') }}</span>
            <p class="text-xs text-steel-100 mt-1">Modifiez votre mot de passe actuel par un nouveau mot de passe.</p>
         </div>
         <form action="{{ route('profile.password') }}" method="POST" class="w-full sm:w-3/4 mb-10">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 -mb-10">
               <div class="flex flex-col w-full">
                  <label for="password_confirm_pass" class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl">
                     <input type="password" name="password_confirm_pass" id="password_confirm_pass" class="px-5 h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis" placeholder="{{ trans('auth.current_password') }}" required>
                     <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.current_password') }}</span>
                  </label>
                  @error('password_confirm_pass')
                  <span class="text-danger text-xs pr-12 mt-2 font-semibold flex items-center truncate" role="alert">
                     <svg class="flex-shrink-0 h-4 w-4 fill-danger my-auto mr-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.84308 3.80211C9.8718 2.6007 10.8862 2 12 2C13.1138 2 14.1282 2.6007 16.1569 3.80211L16.8431 4.20846C18.8718 5.40987 19.8862 6.01057 20.4431 7C21 7.98943 21 9.19084 21 11.5937V12.4063C21 14.8092 21 16.0106 20.4431 17C19.8862 17.9894 18.8718 18.5901 16.8431 19.7915L16.1569 20.1979C14.1282 21.3993 13.1138 22 12 22C10.8862 22 9.8718 21.3993 7.84308 20.1979L7.15692 19.7915C5.1282 18.5901 4.11384 17.9894 3.55692 17C3 16.0106 3 14.8092 3 12.4063V11.5937C3 9.19084 3 7.98943 3.55692 7C4.11384 6.01057 5.1282 5.40987 7.15692 4.20846L7.84308 3.80211ZM13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16ZM12 6.25C12.4142 6.25 12.75 6.58579 12.75 7V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V7C11.25 6.58579 11.5858 6.25 12 6.25Z"/>
                     </svg>
                     {{ $message }}
                  </span>
                  @enderror
               </div>
               <div class="flex flex-col w-full">
                  <label for="password" class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl">
                     <input type="password" name="password" id="password" class="px-5 h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis" placeholder="{{ trans('auth.password') }}" required>
                     <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.password') }}</span>
                  </label>
                  @error('password')
                  <span class="text-danger text-xs pr-12 mt-2 font-semibold flex items-center truncate" role="alert">
                     <svg class="flex-shrink-0 h-4 w-4 fill-danger my-auto mr-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.84308 3.80211C9.8718 2.6007 10.8862 2 12 2C13.1138 2 14.1282 2.6007 16.1569 3.80211L16.8431 4.20846C18.8718 5.40987 19.8862 6.01057 20.4431 7C21 7.98943 21 9.19084 21 11.5937V12.4063C21 14.8092 21 16.0106 20.4431 17C19.8862 17.9894 18.8718 18.5901 16.8431 19.7915L16.1569 20.1979C14.1282 21.3993 13.1138 22 12 22C10.8862 22 9.8718 21.3993 7.84308 20.1979L7.15692 19.7915C5.1282 18.5901 4.11384 17.9894 3.55692 17C3 16.0106 3 14.8092 3 12.4063V11.5937C3 9.19084 3 7.98943 3.55692 7C4.11384 6.01057 5.1282 5.40987 7.15692 4.20846L7.84308 3.80211ZM13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16ZM12 6.25C12.4142 6.25 12.75 6.58579 12.75 7V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V7C11.25 6.58579 11.5858 6.25 12 6.25Z"/>
                     </svg>
                     {{ $message }}
                  </span>
                  @enderror
               </div>
               <label for="password_confirmation" class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl">
                     <input type="password" name="password_confirmation" id="password_confirmation" class="px-5 h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis" placeholder="{{ trans('auth.confirm_password') }}" required>
                     <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.confirm_password') }}</span>
               </label>
               <button type="submit" class="h-14 w-full bg-steel-400 py-4 px-4 text-white text-md rounded-xl transition duartion-200 hover:bg-steel-200 truncate">{{ trans('messages.actions.update') }}</button>
            </div>
         </form>
      </div>
      @endif

      @if(! oauth_login())
      <div class="flex flex-wrap items-start pt-8">
         <div class="w-full sm:w-1/4 mb-8 sm:mb-0 sm:pr-8">
            <span class="block text-sm font-medium text-white">Authentification à deux facteur</span>
            <p class="text-xs text-steel-100 mt-1">Securisez votre compte avec l'authentification à deux facteur.</p>
         </div>
         <div class="w-full sm:w-3/4">
            <div class="flex flex-wrap">
               <div class="w-full">
                  <div class="overflow-x-auto">
                     <a href="{{ route('profile.2fa.index') }}" class="py-4 px-2 flex justify-center bg-steel-400 text-white text-md rounded-xl transition duartion-200 hover:bg-steel-200">
                     @if($user->hasTwoFactorAuth())
                        {{ trans('shop::messages.profile.payments') }}
                     @else
                        {{ trans('messages.profile.2fa.enable') }}
                     @endif
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endif


      @if($enableDiscordLink)
      <div class="flex flex-wrap items-start pt-8">
         <div class="w-full sm:w-1/4 mb-8 sm:mb-0 sm:pr-8">
            <span class="block text-sm font-medium text-white">Discord</span>
            <p class="text-xs text-steel-100 mt-1">{{ trans('admin.roles.discord.title') }}</p>
         </div>
         <div class="w-full sm:w-3/4">
            <div class="flex flex-wrap">
               <div class="w-full">
                  <div class="overflow-x-auto">
                     @if($discordAccount !== null)
                        <form action="{{ route('profile.discord.unlink') }}" method="POST">
                           @csrf
                           <button type="submit" class="w-full py-4 px-2 flex justify-center bg-steel-400 text-white text-md rounded-xl transition duartion-200 hover:bg-steel-200">{{ trans('messages.profile.discord.unlink') }}</button>
                        </form>
                     @else
                        <a href="{{ route('profile.discord.link') }}" class="py-4 px-2 flex justify-center bg-steel-400 text-white text-md rounded-xl transition duartion-200 hover:bg-steel-200">{{ trans('messages.profile.discord.link') }}</a>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endif


      @if(! oauth_login())
         @if($canChangeName)
      <div class="flex flex-wrap items-start pt-8">
         <div class="w-full sm:w-1/4 mb-8 sm:mb-0 sm:pr-8">
            <span class="block text-sm font-medium text-white">{{ trans('auth.name') }}</span>
            <p class="text-xs text-steel-100 mt-1">Changer votre pseudo.</p>
         </div>
         <form action="{{ route('profile.name') }}" method="POST" class="w-full sm:w-3/4 mb-10">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 -mb-10">
               <div class="flex flex-col w-full">
                  <label for="change_name" class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl">
                     <input type="text" name="name" id="change_name" class="px-5 h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis" placeholder="{{ trans('auth.name') }}" value="{{ old('name', $user->name ?? '') }}" required>
                     <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('auth.name') }}</span>
                  </label>
                  @error('name')
                  <span class="text-danger text-xs pr-12 mt-2 font-semibold flex items-center truncate" role="alert">
                     <svg class="flex-shrink-0 h-4 w-4 fill-danger my-auto mr-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.84308 3.80211C9.8718 2.6007 10.8862 2 12 2C13.1138 2 14.1282 2.6007 16.1569 3.80211L16.8431 4.20846C18.8718 5.40987 19.8862 6.01057 20.4431 7C21 7.98943 21 9.19084 21 11.5937V12.4063C21 14.8092 21 16.0106 20.4431 17C19.8862 17.9894 18.8718 18.5901 16.8431 19.7915L16.1569 20.1979C14.1282 21.3993 13.1138 22 12 22C10.8862 22 9.8718 21.3993 7.84308 20.1979L7.15692 19.7915C5.1282 18.5901 4.11384 17.9894 3.55692 17C3 16.0106 3 14.8092 3 12.4063V11.5937C3 9.19084 3 7.98943 3.55692 7C4.11384 6.01057 5.1282 5.40987 7.15692 4.20846L7.84308 3.80211ZM13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16ZM12 6.25C12.4142 6.25 12.75 6.58579 12.75 7V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V7C11.25 6.58579 11.5858 6.25 12 6.25Z"/>
                     </svg>
                     {{ $message }}
                  </span>
                  @enderror
               </div>
               <button type="submit" class="h-14 w-full bg-steel-400 py-4 px-4 text-white text-md rounded-xl transition duartion-200 hover:bg-steel-200 truncate">{{ trans('messages.profile.change_name') }}</button>
            </div>
         </form>
      </div>
         @endif
      @endif
      
      @if(! oauth_login())
         @if($canDelete)
         <div class="flex flex-wrap items-start pt-8">
            <div class="w-full sm:w-1/4 mb-8 sm:mb-0 sm:pr-8">
               <span class="block text-sm font-medium text-white">{{ trans('messages.profile.delete.btn') }}</span>
               <p class="text-xs text-steel-100 mt-1">{{ trans('messages.profile.delete.title') }}</p>
            </div>
            <div class="w-full sm:w-3/4">
               <div class="flex flex-wrap">
                  <div class="w-full">
                     <div class="overflow-x-auto">
                           <a href="{{ route('profile.delete.index') }}" class="py-4 px-2 flex justify-center bg-danger text-white text-md rounded-xl transition duartion-200 hover:bg-opacity-90">{{ trans('messages.profile.delete.btn') }}</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endif
      @endif
   </div>
</div>
@foreach($cards ?? [] as $card)
<div class="w-full bg-steel-400 border-steel-200 border rounded-2xl p-8 mt-10">
   <h2 class="text-white text-xl font-semibold">
      {{ $card['name'] }}
   </h2>
   @include($card['view'])
</div>
@endforeach
@endsection
