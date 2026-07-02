@extends('layouts.base')
@section('title', trans('messages.home'))
@section('app')
    <main class="h-full px-8 pt-10">
        @if ($message)
            <div class="container px-4 py-3.5 mx-auto mb-10 border rounded-2xl border-steel-200">
                <div class="flex">
                    <div class="flex-shrink-0 my-auto">
                        <svg class="flex w-7 h-7 fill-white" xmlns="http://www.w3.org/2000/svg" width="33" height="33"
                             viewBox="0 0 33 33" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M10.7842 5.2279C13.5737 3.57596 14.9685 2.75 16.5 2.75C18.0315 2.75 19.4263 3.57596 22.2157 5.2279L23.1593 5.78663C25.9487 7.43857 27.3435 8.26453 28.1093 9.625C28.875 10.9855 28.875 12.6374 28.875 15.9413V17.0587C28.875 20.3626 28.875 22.0146 28.1093 23.375C27.3435 24.7354 25.9487 25.5614 23.1593 27.2133L22.2157 27.7721C19.4263 29.424 18.0315 30.25 16.5 30.25C14.9685 30.25 13.5737 29.424 10.7842 27.7721L9.84076 27.2133C7.05128 25.5614 5.65653 24.7354 4.89077 23.375C4.125 22.0146 4.125 20.3626 4.125 17.0587V15.9413C4.125 12.6374 4.125 10.9855 4.89077 9.625C5.65653 8.26453 7.05128 7.43857 9.84076 5.78663L10.7842 5.2279ZM17.875 22C17.875 22.7594 17.2594 23.375 16.5 23.375C15.7406 23.375 15.125 22.7594 15.125 22C15.125 21.2406 15.7406 20.625 16.5 20.625C17.2594 20.625 17.875 21.2406 17.875 22ZM16.5 8.59375C17.0695 8.59375 17.5312 9.05546 17.5312 9.625V17.875C17.5312 18.4445 17.0695 18.9062 16.5 18.9062C15.9305 18.9062 15.4688 18.4445 15.4688 17.875V9.625C15.4688 9.05546 15.9305 8.59375 16.5 8.59375Z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between flex-1 ml-4">
                        <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
                            {{ $message }}
                        </p>
                        <p class="my-auto text-sm md:mt-0 md:ml-6">
                            <a class="flex px-4 py-2.5 text-xs font-medium text-white rounded-xl bg-steel-200 hover:bg-steel-100 transition duration-200"
                               href="{{ route('login') }}">
                                <svg class="w-5 h-5 my-auto mr-2 fill-white" width="21" height="21"
                                     viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M19.25 7.25676C19.25 10.298 16.7744 12.7635 13.7206 12.7635C13.1634 12.7635 11.8947 12.6354 11.2774 12.1232L10.5059 12.8916C10.0523 13.3434 10.1748 13.4764 10.3765 13.6955C10.4607 13.7869 10.5588 13.8933 10.6345 14.0442C10.6345 14.0442 11.2774 14.9406 10.6345 15.8371C10.2487 16.3493 9.16851 17.0664 7.9341 15.8371L7.67692 16.0932C7.67692 16.0932 8.44846 16.9896 7.80551 17.8861C7.41974 18.3984 6.39103 18.9106 5.4909 18.0142L4.59078 18.9106C3.97354 19.5253 3.21917 19.1667 2.91914 18.9106L2.14761 18.1422C1.4275 17.425 1.84756 16.6481 2.14761 16.3493L8.83426 9.69001C8.83426 9.69001 8.19131 8.66546 8.19131 7.25676C8.19131 4.21546 10.6669 1.75 13.7206 1.75C16.7744 1.75 19.25 4.21546 19.25 7.25676ZM13.7209 9.17779C14.7861 9.17779 15.6496 8.31776 15.6496 7.25684C15.6496 6.19592 14.7861 5.33587 13.7209 5.33587C12.6556 5.33587 11.792 6.19592 11.792 7.25684C11.792 8.31776 12.6556 9.17779 13.7209 9.17779Z">
                                    </path>
                                </svg>
                                <span class="my-auto tracking-wide">Connexion</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
        <div class="container grid grid-cols-1 gap-14 mt-14 md:gap-20 md:mt-20 lg:gap-48 lg:mt-48 mx-auto">
            <?php

            use Azuriom\Models\User;

            $users = User::count();

            ?>

            <div
                class="flex flex-col md:flex-row md:items-center  justify-between text-white p-4 py-8 md:px-12 md:py-12 bg-gradient-to-r from-[#5066AF]/80 to-[#5066AF] rounded-2xl"
                style="
                    --tw-gradient-from: {{theme_config("home.section1_color")}};
                    --tw-gradient-to: {{theme_config("home.section1_color")}}C8
                "
            >
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">{{theme_config("home.section1_title") ?? "La lune se lève, l'aventure commence..."}}</h2>
                    <p>Rejoins les {{$users}} joueurs en ligne.</p>
                </div>
                <div class="hidden md:flex h-[1px] w-[200px] items-center justify-center -translate-y-[17px]">
                    <img class="max-w-none object-fit-contain"
                         height="350"
                         width="{{theme_config("home.section1_img_size") ?? 400}}"
                         src="{{ theme_config("home.section1_img") ? image_url(theme_config("home.section1_img")) : theme_asset('static/logo.png') }}"
                         alt="Logo">
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-white mb-8">Annonces et articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($posts->sortByDesc('is_pinned')->take(3) as $post)
                        <div class="h-[300px] relative overflow-hidden w-full border rounded-2xl border-steel-200">

                            <div class="p-8">
                                <div class="z-2 absolute bottom-0 left-0 mb-6 space-y-3">
                                    <h2 class="text-xl font-bold text-white break-all md:text-2xl line-clamp-2 px-2">
                                        {{ $post->title }}</h2>
                                </div>
                                @if ($post->hasImage())
                                    <img class="z-[-1] absolute inset-0 object-cover0" src="{{ $post->imageUrl() }}">
                                @endif

                                <div class="absolute top-4 right-4">
                                    <div class="flex gap-2">
                                        <button id="like" type="button" @guest disabled @endguest
                                        data-like-url="{{ route('posts.like', $post) }}"
                                                class="w-[40px] h-[40px] rounded-xl flex items-center justify-center shadow-sm @guest cursor-not-allowed @endguest bg-steel-400 hover:bg-steel-200 hs-tooltip-toggle font-medium @if ($post->isLiked()) active @endif align-middle transition duration-200 text-sm text-white">
                                            <svg class="w-4 h-4  fill-white" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z">
                                                </path>
                                            </svg>
                                        </button>

                                        <div
                                            class="w-fit relative flex items-center justify-center flex-auto text-sm font-medium text-white align-middle transition-all rounded-lg hs-dropdown">
                                            <button type="button" id="blog-article-share-dropdown"
                                                    class="w-[40px] h-[40px] inline-flex items-center justify-center text-sm font-medium text-white transition duration-200 shadow-sm hover:bg-steel-200 hs-dropdown-toggle rounded-xl bg-steel-400 p-0">
                                                <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                          d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z"/>
                                                </svg>
                                            </button>
                                            <div
                                                class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mb-1 z-50 bg-steel-200 shadow-2xl rounded-xl p-2"
                                                aria-labelledby="blog-article-share-dropdown">
                                                <input id="link_share_{{ $post->slug }}" class="hidden"
                                                       value="{{ request()->getHost() }}/news/{{ $post->slug }}">
                                                <button
                                                    onclick="document.getElementById('link_share_{{ $post->slug }}').select();document.getElementById('link_share_{{ $post->slug }}').setSelectionRange(0, 99999);document.execCommand('copy');navigator.clipboard.writeText(document.getElementById('link_share_{{ $post->slug }}').value);"
                                                    class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100">
                                                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M1.25 9C1.25 5.27208 4.27208 2.25 8 2.25H12C15.7279 2.25 18.75 5.27208 18.75 9C18.75 12.7279 15.7279 15.75 12 15.75H10C9.58579 15.75 9.25 15.4142 9.25 15C9.25 14.5858 9.58579 14.25 10 14.25H12C14.8995 14.25 17.25 11.8995 17.25 9C17.25 6.10051 14.8995 3.75 12 3.75H8C5.10051 3.75 2.75 6.10051 2.75 9C2.75 10.3451 3.25487 11.5705 4.08664 12.4998C4.36288 12.8085 4.33662 13.2826 4.02797 13.5589C3.71933 13.8351 3.24518 13.8088 2.96894 13.5002C1.90054 12.3065 1.25 10.7283 1.25 9ZM12 9.75C9.10051 9.75 6.75 12.1005 6.75 15C6.75 17.8995 9.10051 20.25 12 20.25H16C18.8995 20.25 21.25 17.8995 21.25 15C21.25 13.6549 20.7451 12.4295 19.9134 11.5002C19.6371 11.1915 19.6634 10.7174 19.972 10.4411C20.2807 10.1649 20.7548 10.1912 21.0311 10.4998C22.0995 11.6935 22.75 13.2717 22.75 15C22.75 18.7279 19.7279 21.75 16 21.75H12C8.27208 21.75 5.25 18.7279 5.25 15C5.25 11.2721 8.27208 8.25 12 8.25H14C14.4142 8.25 14.75 8.58579 14.75 9C14.75 9.41421 14.4142 9.75 14 9.75H12Z"/>
                                                    </svg>
                                                    Copier le lien
                                                </button>
                                                <a target="_blank"
                                                   class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100"
                                                   href="http://twitter.com/share?text={{ theme_config('twitter_share_message') }}&url=https://{{ request()->getHost() }}/news/{{ $post->slug }}&hashtags={{ site_name() }}">
                                                    <svg class="w-4 h-4 fill-white hover:fill-steel-50"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         class="flex-none w-4 h-4 transition fill-white group-hover:fill-steel-50"
                                                         viewBox="0 0 512 512">
                                                        <path
                                                            d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z">
                                                        </path>
                                                    </svg>
                                                    Partager sur X
                                                </a>
                                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100"
                                                   href="mailto:[Adresse e-mail]?subject={{ $post->title }}&body=https://{{ request()->getHost() }}/news/{{ $post->slug }}">
                                                    <svg class="w-4 h-4 fill-white hover:fill-steel-50"
                                                         viewBox="0 0 24 24"
                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M22 6C22 7.65685 20.6569 9 19 9C17.3431 9 16 7.65685 16 6C16 4.34315 17.3431 3 19 3C20.6569 3 22 4.34315 22 6Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M14 5H10C6.22876 5 4.34315 5 3.17157 6.17157C2 7.34315 2 9.22876 2 13C2 16.7712 2 18.6569 3.17157 19.8284C4.34315 21 6.22876 21 10 21H14C17.7712 21 19.6569 21 20.8284 19.8284C22 18.6569 22 16.7712 22 13C22 11.5466 22 10.3733 21.9329 9.413C21.1453 10.0905 20.1205 10.5 19 10.5C18.5213 10.5 18.0601 10.4253 17.6274 10.2868L16.2837 11.4066C15.3973 12.1452 14.6789 12.7439 14.0448 13.1517C13.3843 13.5765 12.7411 13.8449 12 13.8449C11.2589 13.8449 10.6157 13.5765 9.95518 13.1517C9.32112 12.7439 8.60271 12.1452 7.71636 11.4066L5.51986 9.57617C5.20165 9.31099 5.15866 8.83807 5.42383 8.51986C5.68901 8.20165 6.16193 8.15866 6.48014 8.42383L8.63903 10.2229C9.57199 11.0004 10.2197 11.5384 10.7666 11.8901C11.2959 12.2306 11.6549 12.3449 12 12.3449C12.3451 12.3449 12.7041 12.2306 13.2334 11.8901C13.7803 11.5384 14.428 11.0004 15.361 10.2229L16.2004 9.52335C15.1643 8.69893 14.5 7.42704 14.5 6C14.5 5.65638 14.5385 5.32175 14.6115 5.0002C14.4133 5 14.2096 5 14 5Z"/>
                                                    </svg>
                                                    Envoyer par Mail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="w-fit flex items-center justify-center text-sm font-medium text-white align-middle transition duration-200 shadow-sm hover:bg-steel-200 rounded-xl bg-steel-400 ms-auto mt-8"
                   href="/news">
                    <svg class="w-4 h-4 mr-2 fill-white hover:fill-steel-50" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M1.25 21C1.25 20.5858 1.58579 20.25 2 20.25L22 20.25C22.4142 20.25 22.75 20.5858 22.75 21C22.75 21.4142 22.4142 21.75 22 21.75L2 21.75C1.58579 21.75 1.25 21.4142 1.25 21ZM1.25 3C1.25 2.58579 1.58579 2.25 2 2.25L22 2.25C22.4142 2.25 22.75 2.58579 22.75 3C22.75 3.41421 22.4142 3.75 22 3.75L2 3.75C1.58579 3.75 1.25 3.41421 1.25 3Z"/>
                        <path
                            d="M4 12C4 13.8856 4 14.8284 4.58579 15.4142C5.17157 16 6.11438 16 8 16L16 16C17.8856 16 18.8284 16 19.4142 15.4142C20 14.8284 20 13.8856 20 12C20 10.1144 20 9.17157 19.4142 8.58579C18.8284 8 17.8856 8 16 8H8C6.11438 8 5.17157 8 4.58579 8.58579C4 9.17158 4 10.1144 4 12Z"/>
                    </svg>
                    Lire plus d'articles
                </a>
            </div>


            <div
                class="flex flex-col md:flex-row-reverse md:items-center  justify-between text-white p-4 py-8 md:px-12 md:py-12 bg-gradient-to-r from-[#5066AF]/80 to-[#5066AF] rounded-2xl"
                style="
                    --tw-gradient-from: {{theme_config("home.section2_color")}};
                    --tw-gradient-to: {{theme_config("home.section2_color")}}C8
                "
            >
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">{{theme_config("home.section2_title") ?? "La lune se lève, l'aventure commence..."}}</h2>
                    <p>{{theme_config("home.section2_text") ?? "La lune se lève, l'aventure commence..."}}</p>
                </div>
                <div class="hidden md:flex h-[1px] w-[200px] items-center justify-center -translate-y-[17px]">
                    <img class="max-w-none object-fit-contain"
                         height="350"
                         width="{{theme_config("home.section2_img_size") ?? 400}}"
                         src="{{ theme_config("home.section2_img") ? image_url(theme_config("home.section2_img")) : theme_asset('static/logo.png') }}"
                         alt="Logo">
                </div>
            </div>
        </div>
    </main>
@endsection
