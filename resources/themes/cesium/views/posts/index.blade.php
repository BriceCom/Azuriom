@extends('layouts.app')
@section('title', trans('messages.posts.posts'))
@section('content')
<div class="container grid lg:grid-cols-2 mx-auto w-full gap-10">
@foreach($posts as $post)
   <div class="border rounded-2xl border-steel-200 w-full p-8 col-span-1">
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
                                       <img class="absolute z-10 h-6 mx-auto text-transparent rounded-full shadow-xl" src="{{ $post->author->getAvatar() }}" alt="{{ $post->author->name }}">
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
                                       <div class="bg-steel-100 px-1.5 py-0.5 my-auto ml-1.5 text-xs text-white rounded font-semibold">
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
      <div class="aspect-w-12 aspect-h-7">
         <img class="rounded-2xl object-cover bg-steel-200" src="{{ $post->imageUrl() }}">
      </div>
      @endif
      <div class="flex-col mt-8 space-y-5 text-white text-sm flex break-all leading-5 article max-h-32 overflow-hidden">
         {!! $post->content !!}
      </div>
      <div class="mt-5 grid lg:flex lg:justify-between lg:items-center gap-y-5 lg:gap-y-0">
      <div class="flex flex-wrap gap-4 leading-6">
   <button id="like" type="button" @guest disabled @endguest data-like-url="{{ route('posts.like', $post) }}" class="p-4 flex-auto w-56 rounded-xl flex items-center justify-center shadow-sm @guest cursor-not-allowed @endguest btn bg-steel-200 hover:bg-steel-100 hs-tooltip-toggle font-medium @if($post->isLiked()) active @endif align-middle transition duration-200 text-sm text-white">
               <svg class="w-4 h-4 fill-white mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z"></path>
               </svg>
               <span class="likes-count">{{ $post->likes->count() }}</span>
               <span class="d-none spinner-border spinner-border-sm load-spinner hidden" role="status"></span>
   </button>

   <a href="http://{{ request()->getHost(); }}/news/{{ $post->slug }}" class="hover:bg-steel-200 p-4 flex-auto w-56 rounded-xl flex items-center justify-center bg-steel-400 shadow-sm font-medium align-middle transition duration-200 text-sm text-white">
   <svg class="w-4 h-4 fill-white mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 22C17.5228 22 22 17.5228 22 12C22 11.094 21.8795 10.2162 21.6537 9.38161C21.5684 9.06633 21.1987 8.94083 20.9028 9.0791C20.3248 9.34916 19.68 9.5 19 9.5C16.5147 9.5 14.5 7.48528 14.5 5C14.5 4.31996 14.6508 3.67516 14.9209 3.09722C15.0592 2.80131 14.9337 2.4316 14.6184 2.3463C13.7838 2.12048 12.906 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22Z"/>
                  <circle cx="19" cy="5" r="3"/>
               </svg>
               {{ $post->comments->count() }}
   </a>

   <div class="hs-dropdown relative flex-auto w-56 rounded-lg flex items-center justify-center font-medium align-middle transition-all text-sm text-white">
               <button type="button" id="blog-article-share-dropdown" class="w-full hover:bg-steel-200 hs-dropdown-toggle p-4 inline-flex justify-center items-center rounded-xl font-medium bg-steel-400 transition duration-200 text-white text-sm shadow-sm ">
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
            <a href="http://{{ request()->getHost(); }}/news/{{ $post->slug }}" class="hover:bg-steel-200 hs-collapse-toggle hs-collapse-open:hidden p-4 flex-auto w-56 rounded-xl flex items-center justify-center bg-steel-400 shadow-sm font-medium align-middle transition duration-200 text-sm text-white">
   <svg class="w-4 h-4 my-auto mr-2 fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
   <path d="M9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 13.6394 2.42496 14.1915 3.27489 15.2957C4.97196 17.5004 7.81811 20 12 20C16.1819 20 19.028 17.5004 20.7251 15.2957C21.575 14.1915 22 13.6394 22 12C22 10.3606 21.575 9.80853 20.7251 8.70433C19.028 6.49956 16.1819 4 12 4C7.81811 4 4.97196 6.49956 3.27489 8.70433C2.42496 9.80853 2 10.3606 2 12ZM12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25Z"/>
                  </svg>
                  <span class="my-auto tracking-wide">Afficher l'article</span>
</a>

</div>
      </div>
   </div>
@endforeach
</div>
@endsection
