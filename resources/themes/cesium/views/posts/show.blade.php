@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->description)
@section('type', 'article')

@push('meta')
<meta property="og:article:author:username" content="{{ $post->author->name }}">
<meta property="og:article:published_time" content="{{ $post->published_at->toIso8601String() }}">
<meta property="og:article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
@endpush

@section('content')


   @if(!$post->isPublished())
   <div class="container px-4 py-5 mx-auto mb-10 border rounded-2xl  border-steel-200">
      <div class="flex">
         <div class="flex-shrink-0 my-auto">
            <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7842 5.2279C13.5737 3.57596 14.9685 2.75 16.5 2.75C18.0315 2.75 19.4263 3.57596 22.2157 5.2279L23.1593 5.78663C25.9487 7.43857 27.3435 8.26453 28.1093 9.625C28.875 10.9855 28.875 12.6374 28.875 15.9413V17.0587C28.875 20.3626 28.875 22.0146 28.1093 23.375C27.3435 24.7354 25.9487 25.5614 23.1593 27.2133L22.2157 27.7721C19.4263 29.424 18.0315 30.25 16.5 30.25C14.9685 30.25 13.5737 29.424 10.7842 27.7721L9.84076 27.2133C7.05128 25.5614 5.65653 24.7354 4.89077 23.375C4.125 22.0146 4.125 20.3626 4.125 17.0587V15.9413C4.125 12.6374 4.125 10.9855 4.89077 9.625C5.65653 8.26453 7.05128 7.43857 9.84076 5.78663L10.7842 5.2279ZM17.875 22C17.875 22.7594 17.2594 23.375 16.5 23.375C15.7406 23.375 15.125 22.7594 15.125 22C15.125 21.2406 15.7406 20.625 16.5 20.625C17.2594 20.625 17.875 21.2406 17.875 22ZM16.5 8.59375C17.0695 8.59375 17.5312 9.05546 17.5312 9.625V17.875C17.5312 18.4445 17.0695 18.9062 16.5 18.9062C15.9305 18.9062 15.4688 18.4445 15.4688 17.875V9.625C15.4688 9.05546 15.9305 8.59375 16.5 8.59375Z"></path>
            </svg>
         </div>
         <div class="flex items-center justify-between flex-1 ml-4">
            <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
               {{ trans('messages.posts.unpublished') }}
            </p>
         </div>
      </div>
   </div>
   @endif

   @guest
   <div class="container px-4 py-3.5 mx-auto mb-10 border rounded-2xl  border-steel-200">
      <div class="flex">
         <div class="flex-shrink-0 my-auto">
            <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7842 5.2279C13.5737 3.57596 14.9685 2.75 16.5 2.75C18.0315 2.75 19.4263 3.57596 22.2157 5.2279L23.1593 5.78663C25.9487 7.43857 27.3435 8.26453 28.1093 9.625C28.875 10.9855 28.875 12.6374 28.875 15.9413V17.0587C28.875 20.3626 28.875 22.0146 28.1093 23.375C27.3435 24.7354 25.9487 25.5614 23.1593 27.2133L22.2157 27.7721C19.4263 29.424 18.0315 30.25 16.5 30.25C14.9685 30.25 13.5737 29.424 10.7842 27.7721L9.84076 27.2133C7.05128 25.5614 5.65653 24.7354 4.89077 23.375C4.125 22.0146 4.125 20.3626 4.125 17.0587V15.9413C4.125 12.6374 4.125 10.9855 4.89077 9.625C5.65653 8.26453 7.05128 7.43857 9.84076 5.78663L10.7842 5.2279ZM17.875 22C17.875 22.7594 17.2594 23.375 16.5 23.375C15.7406 23.375 15.125 22.7594 15.125 22C15.125 21.2406 15.7406 20.625 16.5 20.625C17.2594 20.625 17.875 21.2406 17.875 22ZM16.5 8.59375C17.0695 8.59375 17.5312 9.05546 17.5312 9.625V17.875C17.5312 18.4445 17.0695 18.9062 16.5 18.9062C15.9305 18.9062 15.4688 18.4445 15.4688 17.875V9.625C15.4688 9.05546 15.9305 8.59375 16.5 8.59375Z"></path>
            </svg>
         </div>
         <div class="flex items-center justify-between flex-1 ml-4">
            <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
               {{ trans('messages.comments.guest') }}
            </p>
            <p class="my-auto text-sm md:mt-0 md:ml-6">
               <a class="flex px-4 py-2.5 text-xs font-medium text-white rounded-xl bg-steel-400 hover:bg-steel-200 transition duration-200" href="{{ route('login') }}">
                  <svg class="w-5 h-5 my-auto mr-2 fill-white" width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M19.25 7.25676C19.25 10.298 16.7744 12.7635 13.7206 12.7635C13.1634 12.7635 11.8947 12.6354 11.2774 12.1232L10.5059 12.8916C10.0523 13.3434 10.1748 13.4764 10.3765 13.6955C10.4607 13.7869 10.5588 13.8933 10.6345 14.0442C10.6345 14.0442 11.2774 14.9406 10.6345 15.8371C10.2487 16.3493 9.16851 17.0664 7.9341 15.8371L7.67692 16.0932C7.67692 16.0932 8.44846 16.9896 7.80551 17.8861C7.41974 18.3984 6.39103 18.9106 5.4909 18.0142L4.59078 18.9106C3.97354 19.5253 3.21917 19.1667 2.91914 18.9106L2.14761 18.1422C1.4275 17.425 1.84756 16.6481 2.14761 16.3493L8.83426 9.69001C8.83426 9.69001 8.19131 8.66546 8.19131 7.25676C8.19131 4.21546 10.6669 1.75 13.7206 1.75C16.7744 1.75 19.25 4.21546 19.25 7.25676ZM13.7209 9.17779C14.7861 9.17779 15.6496 8.31776 15.6496 7.25684C15.6496 6.19592 14.7861 5.33587 13.7209 5.33587C12.6556 5.33587 11.792 6.19592 11.792 7.25684C11.792 8.31776 12.6556 9.17779 13.7209 9.17779Z"></path>
                  </svg>
                  <span class="my-auto tracking-wide">Connexion</span>
               </a>
            </p>
         </div>
      </div>
   </div>
   @endguest
      
   <div class="border rounded-2xl border-steel-200 w-full p-8 container mx-auto">
      <div class="flex justify-between items-center mb-6">
         <div class="flex w-full sm:items-center gap-x-5">
            <div class="flex-shrink-0">
               <img class="absolute z-10 h-10 mx-auto text-transparent rounded-lg shadow-xl" src="{{ $post->author->getAvatar() }}" alt="{{ $post->author->name }}">
               <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-steel-300">
                  <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                     <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                     </circle>
                     <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                     </path>
                  </svg>
               </div>
            </div>
            <div class="grow">
               <div class="flex justify-between items-center gap-2">
                  <div>
                     <div class="hs-tooltip inline-block [--trigger:hover] [--placement:bottom]">
                        <div class="hs-tooltip-toggle block text-left cursor-pointer">
                           <span class="font-semibold text-white">
                           {{ $post->author->name }}
                           </span>
                           <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 max-w-xs cursor-default bg-steel-200 shadow-lg rounded-xl" role="tooltip">
                              <div class="p-4 sm:p-5">
                                 <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                                    <div class="flex-shrink-0">
                                       <img class="absolute z-50 h-6 mx-auto text-transparent rounded-full shadow-xl" src="https://mc-heads.net/avatar/{{ $post->author->name }}/150.png" alt="Zones">
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
                                          {{ $post->author->name }}
                                       </p>
                                       <div class="bg-steel-100 px-1.5 py-0.5 my-auto ml-1.5 text-xs text-white rounded font-semibold" style="{{ $post->author->role->getBadgeStyle() }};">
                                          <!--- role --->
                                          {{ $post->author->role->name }}

                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <ul class="text-xs text-steel-50">
                        <li class="inline-block relative pr-6 last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-steel-50 before:rounded-full">
                           <!--- format_date() avec heure --->
                           {{ $post->created_at->format('d/m/Y' . ' à ' . 'H:i') }}
                        </li>
                        <li class="inline-block relative pr-6 last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-steel-50 before:rounded-full">
                           <!--- TEMPS LECTURE -->
                           @php
                           $contenu_article = $post->content; // Récupérez le contenu de $post->content
                           // Supprimez toutes les balises HTML
                           $texte_sans_balises = strip_tags($contenu_article);
                           // Compter le nombre de caractères
                           $nombre_de_caracteres = strlen($texte_sans_balises);
                           // Estimation du temps de lecture moyen (supposons 200 mots par minute)
                           $temps_de_lecture_minutes = ceil($nombre_de_caracteres / 1000);
                           @endphp
                           {{ $temps_de_lecture_minutes }} minutes
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="space-y-3 mb-6">
         <h2 class="text-xl font-bold md:text-2xl text-white line-clamp-2 break-all">{{ $post->title }}</h2>
         <p class="text-lg text-steel-50 font-medium break-all line-clamp-2">{{ $post->description }}</p>
      </div>
      @if($post->hasImage())
      <div class="aspect-w-7 aspect-h-4">
         <img class="rounded-2xl object-cover bg-steel-200" src="{{ $post->imageUrl() }}">
      </div>
      @endif
      <div class="mt-8 space-y-5 text-white text-sm break-all leading-5 article">
         {!! $post->content !!}
      </div>
      <div class="mt-5 flex flex-wrap gap-4 leading-6">
         
         <button id="like" type="button" @guest disabled @endguest data-like-url="{{ route('posts.like', $post) }}" class="p-4 flex-auto w-56 rounded-xl flex items-center justify-center shadow-sm @guest cursor-not-allowed @endguest btn bg-steel-400 hover:bg-steel-200 hs-tooltip-toggle font-medium @if($post->isLiked()) active @endif align-middle transition duration-200 text-sm text-white">
               <svg class="w-4 h-4 fill-white mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z"></path>
               </svg>
               <span class="likes-count">{{ $post->likes->count() }}</span>
               <span class="d-none spinner-border spinner-border-sm load-spinner hidden" role="status"></span>
   </button>

   <label for="content" class="cursor-pointer hover:bg-steel-200 p-4 flex-auto w-56 rounded-xl flex items-center justify-center bg-steel-400 shadow-sm font-medium align-middle transition duration-200 text-sm text-white">
   <svg class="w-4 h-4 fill-white mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 22C17.5228 22 22 17.5228 22 12C22 11.094 21.8795 10.2162 21.6537 9.38161C21.5684 9.06633 21.1987 8.94083 20.9028 9.0791C20.3248 9.34916 19.68 9.5 19 9.5C16.5147 9.5 14.5 7.48528 14.5 5C14.5 4.31996 14.6508 3.67516 14.9209 3.09722C15.0592 2.80131 14.9337 2.4316 14.6184 2.3463C13.7838 2.12048 12.906 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22Z"/>
                  <circle cx="19" cy="5" r="3"/>
               </svg>
               {{ $post->comments->count() }}
</label>

   <div class="hs-dropdown relative flex-auto w-56 rounded-xl flex items-center justify-center font-medium align-middle transition-all text-sm text-white ">
               <button type="button" id="blog-article-share-dropdown" class="w-full hover:bg-steel-200 hs-dropdown-toggle p-4 inline-flex justify-center items-center rounded-xl shadow-sm font-medium bg-steel-400 transition duration-200 text-white text-sm ">
                  <svg class="w-4 h-4 fill-white mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z"/>
                  </svg>
                  Partager
               </button>
               <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mb-1 z-50 bg-steel-200 shadow-2xl rounded-xl p-2" aria-labelledby="blog-article-share-dropdown">
                  <input id="link_share_{{ $post->slug }}" class="hidden" value="{{ request()->getHost(); }}/news/{{ $post->slug }}">
                  <button onclick="document.getElementById('link_share_{{ $post->slug }}').select();document.getElementById('link_share_{{ $post->slug }}').setSelectionRange(0, 99999);document.execCommand('copy');navigator.clipboard.writeText(document.getElementById('link_share_{{ $post->slug }}').value);" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100">
                     <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.25 9C1.25 5.27208 4.27208 2.25 8 2.25H12C15.7279 2.25 18.75 5.27208 18.75 9C18.75 12.7279 15.7279 15.75 12 15.75H10C9.58579 15.75 9.25 15.4142 9.25 15C9.25 14.5858 9.58579 14.25 10 14.25H12C14.8995 14.25 17.25 11.8995 17.25 9C17.25 6.10051 14.8995 3.75 12 3.75H8C5.10051 3.75 2.75 6.10051 2.75 9C2.75 10.3451 3.25487 11.5705 4.08664 12.4998C4.36288 12.8085 4.33662 13.2826 4.02797 13.5589C3.71933 13.8351 3.24518 13.8088 2.96894 13.5002C1.90054 12.3065 1.25 10.7283 1.25 9ZM12 9.75C9.10051 9.75 6.75 12.1005 6.75 15C6.75 17.8995 9.10051 20.25 12 20.25H16C18.8995 20.25 21.25 17.8995 21.25 15C21.25 13.6549 20.7451 12.4295 19.9134 11.5002C19.6371 11.1915 19.6634 10.7174 19.972 10.4411C20.2807 10.1649 20.7548 10.1912 21.0311 10.4998C22.0995 11.6935 22.75 13.2717 22.75 15C22.75 18.7279 19.7279 21.75 16 21.75H12C8.27208 21.75 5.25 18.7279 5.25 15C5.25 11.2721 8.27208 8.25 12 8.25H14C14.4142 8.25 14.75 8.58579 14.75 9C14.75 9.41421 14.4142 9.75 14 9.75H12Z"/>
                     </svg>
                     Copier le lien
                  </button>
                  <a target="_blank" class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100" href="http://twitter.com/share?text={{ theme_config('twitter_share_message') }}&url=https://{{ request()->getHost(); }}/news/{{ $post->slug }}&hashtags={{ site_name() }}">
                     <svg class="w-4 h-4 fill-white hover:fill-steel-50" xmlns="http://www.w3.org/2000/svg" class="flex-none w-4 h-4 transition fill-white group-hover:fill-steel-50" viewBox="0 0 512 512">
                        <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
                     </svg>
                     Partager sur X
                  </a>
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100" href="mailto:[Adresse e-mail]?subject={{ $post->title }}&body=https://{{ request()->getHost(); }}/news/{{ $post->slug }}">
                     <svg class="w-4 h-4 fill-white hover:fill-steel-50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 6C22 7.65685 20.6569 9 19 9C17.3431 9 16 7.65685 16 6C16 4.34315 17.3431 3 19 3C20.6569 3 22 4.34315 22 6Z"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14 5H10C6.22876 5 4.34315 5 3.17157 6.17157C2 7.34315 2 9.22876 2 13C2 16.7712 2 18.6569 3.17157 19.8284C4.34315 21 6.22876 21 10 21H14C17.7712 21 19.6569 21 20.8284 19.8284C22 18.6569 22 16.7712 22 13C22 11.5466 22 10.3733 21.9329 9.413C21.1453 10.0905 20.1205 10.5 19 10.5C18.5213 10.5 18.0601 10.4253 17.6274 10.2868L16.2837 11.4066C15.3973 12.1452 14.6789 12.7439 14.0448 13.1517C13.3843 13.5765 12.7411 13.8449 12 13.8449C11.2589 13.8449 10.6157 13.5765 9.95518 13.1517C9.32112 12.7439 8.60271 12.1452 7.71636 11.4066L5.51986 9.57617C5.20165 9.31099 5.15866 8.83807 5.42383 8.51986C5.68901 8.20165 6.16193 8.15866 6.48014 8.42383L8.63903 10.2229C9.57199 11.0004 10.2197 11.5384 10.7666 11.8901C11.2959 12.2306 11.6549 12.3449 12 12.3449C12.3451 12.3449 12.7041 12.2306 13.2334 11.8901C13.7803 11.5384 14.428 11.0004 15.361 10.2229L16.2004 9.52335C15.1643 8.69893 14.5 7.42704 14.5 6C14.5 5.65638 14.5385 5.32175 14.6115 5.0002C14.4133 5 14.2096 5 14 5Z"/>
                     </svg>
                     Envoyer par Mail
                  </a>
               </div>
            </div>
         
      </div>
   </div>

   <section id="comments">
      @foreach($post->comments as $comment)
      <li class="flex border rounded-2xl border-steel-200 w-full p-8 container mx-auto mt-10">
         <div class="flex-shrink-0">
            <img class="absolute z-10 h-10 mx-auto text-transparent rounded-lg shadow-xl" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-steel-300">
               <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                  </circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
               </svg>
            </div>
         </div>
         <div class="ml-4 grow  w-full space-y-3">
            <div class="space-y-2">
               <div>
                  <div class="hs-tooltip inline-block [--trigger:hover] [--placement:bottom]">
                     <div class="hs-tooltip-toggle block text-left cursor-pointer">
                        <span class="font-semibold text-white" >
                        {{ $comment->author->name }}
                        </span>
                        <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 max-w-xs cursor-default bg-steel-200 divide-y divide-steel-100 shadow-lg rounded-xl hidden" role="tooltip" style="position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate(302px, 480px);" data-popper-placement="bottom">
                           <div class="p-4 sm:p-5">
                              <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                                 <div class="flex-shrink-0">
                                    <img class="absolute z-50 h-6 mx-auto text-transparent rounded-full shadow-xl" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}">
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
                                       {{ $comment->author->name }}
                                    </p>
                                    <div class="bg-steel-100 px-1.5 py-0.5 my-auto ml-1.5 text-xs text-white rounded font-semibold" style="{{ $comment->author->role->getBadgeStyle() }};">
                                       <!--- role --->
                                       {{ $comment->author->role->name }}
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <ul class="text-xs text-steel-50">
                     <li class="inline-block relative pr-6 last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-steel-50 before:rounded-full">
                        <!--- format_date() avec heure --->
                        @lang('messages.comments.author', ['user' => e($comment->author->name), 'date' => format_date($comment->created_at, true)])
                     </li>
                  </ul>
               </div>
               <div class="space-y-1.5 break-all leading-y-6 text-sm text-white line-clamp-5">
                  {{ $comment->parseContent() }}
               </div>
            </div>
            <div class="flex flex-wrap w-full justify-end gap-3">
               @can('delete', $comment)
               <a href="{{ route('posts.comments.destroy', [$post, $comment]) }}" data-confirm="delete" title="{{ trans('messages.actions.delete') }}" data-hs-overlay="#confirm_delete_comment" class="mt-2 btn bg-red-500 py-1.5 px-2 inline-flex justify-center items-center gap-x-1.5 rounded-md font-medium  align-middle transition-all text-xs text-white">
                  <svg class="w-3.5 h-3.5 fill-white my-auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M3 6.52381C3 6.12932 3.32671 5.80952 3.72973 5.80952H8.51787C8.52437 4.9683 8.61554 3.81504 9.45037 3.01668C10.1074 2.38839 11.0081 2 12 2C12.9919 2 13.8926 2.38839 14.5496 3.01668C15.3844 3.81504 15.4756 4.9683 15.4821 5.80952H20.2703C20.6733 5.80952 21 6.12932 21 6.52381C21 6.9183 20.6733 7.2381 20.2703 7.2381H3.72973C3.32671 7.2381 3 6.9183 3 6.52381Z"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M11.5956 22H12.4044C15.1871 22 16.5785 22 17.4831 21.1141C18.3878 20.2281 18.4803 18.7749 18.6654 15.8685L18.9321 11.6806C19.0326 10.1036 19.0828 9.31511 18.6289 8.81545C18.1751 8.31579 17.4087 8.31579 15.876 8.31579H8.12404C6.59127 8.31579 5.82488 8.31579 5.37105 8.81545C4.91722 9.31511 4.96744 10.1036 5.06788 11.6806L5.33459 15.8685C5.5197 18.7749 5.61225 20.2281 6.51689 21.1141C7.42153 22 8.81289 22 11.5956 22ZM10.2463 12.1885C10.2051 11.7546 9.83753 11.4381 9.42537 11.4815C9.01321 11.5249 8.71251 11.9117 8.75372 12.3456L9.25372 17.6087C9.29494 18.0426 9.66247 18.3591 10.0746 18.3157C10.4868 18.2724 10.7875 17.8855 10.7463 17.4516L10.2463 12.1885ZM14.5746 11.4815C14.9868 11.5249 15.2875 11.9117 15.2463 12.3456L14.7463 17.6087C14.7051 18.0426 14.3375 18.3591 13.9254 18.3157C13.5132 18.2724 13.2125 17.8855 13.2537 17.4516L13.7537 12.1885C13.7949 11.7546 14.1625 11.4381 14.5746 11.4815Z"/>
                  </svg>
                  <span class="flex justify-center items-center -mt-0.5">{{ trans('messages.actions.delete') }}</span>
               </a>
               @endif
            </div>
      </li>
      @endforeach
      </section>
      @can('create', \Azuriom\Models\Comment::class)
      <div class="border rounded-2xl border-steel-200 w-full p-8 container mx-auto mt-10">
         
         <form action="{{ route('posts.comments.store', $post) }}" method="POST">
            @csrf
            <div>
               <label for="content" class="block mb-2 text-sm font-medium text-white">{{ trans('messages.comments.create') }}</label>
               <div class="mt-1">

               <label class="mt-5 flex relative w-full h-full py-4 px-2 border border-steel-200 hover:border-white rounded-xl transition duration-200">
                  <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('messages.comments.content') }}</span>
                  <textarea id="content" name="content" rows="4" class="@error('content') border-red-500 @enderror px-2 block w-full outline-none bg-transparent text-white placeholder-steel-200 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0" type="text" placeholder="{{ trans('messages.comments.content') }}" required></textarea>
                  </label>
                  
               </div>
            </div>
            @error('content')
               <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
            <div class="mt-6 grid">
               <button type="submit" class="py-4 px-4 inline-flex justify-center items-center gap-2 rounded-xl border border-transparent font-medium bg-steel-400 hover:bg-steel-200 text-sm text-white transition duration-200">{{ trans('messages.actions.comment') }}</button>
            </div>
         </form>
         
      </div>
      @endcan
      
   </div>
      <div id="confirm_delete_comment" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
         <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="relative flex flex-col bg-steel-400 border shadow-sm rounded-xl border-steel-200">
               <div class="absolute top-2 right-2">
                  <button type="button" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 text-sm transition-all rounded-full text-steel-100 hover:text-steel-50" data-hs-overlay="#confirm_delete_comment">
                     <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"/>
                     </svg>
                  </button>
               </div>
               <div class="p-4 sm:p-10 text-center overflow-y-auto">
                  <h1 class="text-center flex text-white text-2xl font-semibold  justify-center items-center">
                     <svg class="md:flex hidden my-auto h-9 w-9 fill-white mr-2.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6.52381C3 6.12932 3.32671 5.80952 3.72973 5.80952H8.51787C8.52437 4.9683 8.61554 3.81504 9.45037 3.01668C10.1074 2.38839 11.0081 2 12 2C12.9919 2 13.8926 2.38839 14.5496 3.01668C15.3844 3.81504 15.4756 4.9683 15.4821 5.80952H20.2703C20.6733 5.80952 21 6.12932 21 6.52381C21 6.9183 20.6733 7.2381 20.2703 7.2381H3.72973C3.32671 7.2381 3 6.9183 3 6.52381Z"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.5956 22H12.4044C15.1871 22 16.5785 22 17.4831 21.1141C18.3878 20.2281 18.4803 18.7749 18.6654 15.8685L18.9321 11.6806C19.0326 10.1036 19.0828 9.31511 18.6289 8.81545C18.1751 8.31579 17.4087 8.31579 15.876 8.31579H8.12404C6.59127 8.31579 5.82488 8.31579 5.37105 8.81545C4.91722 9.31511 4.96744 10.1036 5.06788 11.6806L5.33459 15.8685C5.5197 18.7749 5.61225 20.2281 6.51689 21.1141C7.42153 22 8.81289 22 11.5956 22ZM10.2463 12.1885C10.2051 11.7546 9.83753 11.4381 9.42537 11.4815C9.01321 11.5249 8.71251 11.9117 8.75372 12.3456L9.25372 17.6087C9.29494 18.0426 9.66247 18.3591 10.0746 18.3157C10.4868 18.2724 10.7875 17.8855 10.7463 17.4516L10.2463 12.1885ZM14.5746 11.4815C14.9868 11.5249 15.2875 11.9117 15.2463 12.3456L14.7463 17.6087C14.7051 18.0426 14.3375 18.3591 13.9254 18.3157C13.5132 18.2724 13.2125 17.8855 13.2537 17.4516L13.7537 12.1885C13.7949 11.7546 14.1625 11.4381 14.5746 11.4815Z"/>
                     </svg>
                     {{ trans('messages.comments.delete') }}
                  </h1>
                  <p class="mt-4 text-steel-50 text-sm font-medium">
                     {{ trans('messages.comments.delete_confirm') }}
                  </p>
                  <form class="mt-6 flex justify-center gap-x-4" id="confirmDeleteForm" method="POST">
                     @method('DELETE')
                     @csrf
                     <button class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md bg-red-500 transition duration-200 hover:bg-red-500/80 text-white shadow-sm align-middle text-sm font-medium" type="submit">
                     {{ trans('messages.actions.delete') }}
                     </button>
                     <button type="button" class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-medium bg-steel-100 hover:bg-steel-50 transition duration-200 text-white text-sm" data-hs-overlay="#confirm_delete_comment">
                     {{ trans('messages.actions.cancel') }}
                     </button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   

@endsection