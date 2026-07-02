<div class="px-8 pt-8 pb-5 overflow-hidden bg-steel-300">
    <div class="container mx-auto">
        <div class="flex flex-wrap mb-10">
            <div class="w-full mr-auto xs:w-1/3 md:w-full lg:w-1/3">
                <h1 class="font-medium text-white text-md">
                    {{ setting('copyright') }}
                </h1>
                <p class="mt-4 text-sm font-medium leading-6 text-steel-50">{{ theme_config('desc_footer') }}</p>
            </div>
            <div class="flex flex-col w-full mt-10 lg:mt-0 lg:items-end lg:justify-end sm:w-1/3 lg:w-1/5">
                <div class=" text-start">
                    <h4 class="mb-4 font-semibold text-white">{{ theme_config('footer_link_title_1') }}</h4>
                    <ul>
                        @foreach (theme_config('footer_links_1') ?? [] as $link)
                            <li class="mb-2">
                                <a class="inline-block text-sm font-medium text-steel-50 hover:text-white"
                                    href="{{ $link['name'] }}">{{ $link['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="flex flex-col w-full mt-10 lg:mt-0 lg:items-end lg:justify-end sm:w-1/3 lg:w-1/5">
                <div class=" text-start">
                    <h4 class="mb-4 font-semibold text-white">{{ theme_config('footer_link_title_2') }}</h4>
                    <ul>
                        @foreach (theme_config('footer_links_2') ?? [] as $link)
                            <li class="mb-2">
                                <a class="inline-block text-sm font-medium text-steel-50 hover:text-white"
                                    href="{{ $link['name'] }}">{{ $link['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="flex flex-col w-full mt-10 lg:mt-0 lg:items-end lg:justify-end sm:w-1/3 lg:w-1/5">
                <div class=" text-start">
                    <h4 class="mb-4 font-semibold text-white">{{ theme_config('footer_link_title_3') }}</h4>
                    <ul>
                        @foreach (theme_config('footer_links_3') ?? [] as $link)
                            <li class="mb-2">
                                <a class="inline-block text-sm font-medium text-steel-50 hover:text-white"
                                    href="{{ $link['name'] }}">{{ $link['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="pb-4 mt-20 mb-5 border-b border-steel-200">
            <div class="flex flex-wrap -mx-4 -mb-2">
                @foreach (theme_config('footer_sublinks') ?? [] as $link)
                    <div class="px-4 mb-2">
                        <a class="inline-block text-xs font-medium text-white hover:text-steel-50"
                            href="{{ $link['link'] }}">{{ $link['name'] }}</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="md:justify-between md:flex">
            <div class="flex items-center gap-5">
                @foreach (social_links() as $link)
                    <a href="{{ $link->value }}" target="_blank" rel="noopener noreferrer"
                        class="text-[1.08rem] list-inline-item text-white" data-bs-toggle="tooltip"
                        title="{{ $link->title }}">
                        <i class="{{ $link->icon }} fs-2 mx-1 text-white"></i>
                    </a>
                @endforeach
            </div>
            <p class="flex pt-4 my-auto text-xs font-medium text-white md:pt-0">
                Propulsé par
                <a target="_blank" class="flex group hover:text-steel-50 hover:underline"
                    href="https://azuriom.com/fr/">
                    <svg class="h-4 mx-0.5 fill-white group-hover:fill-steel-50" xmlns="http://www.w3.org/2000/svg"
                        version="1.1" viewBox="0 0 500 500">
                        <polygon points="201.1,8.1 298.2,8.1 486.5,494.7 390,494.7"></polygon>
                        <polygon points="249.7,133.2 201.2,8.1 12.8,494.7 109.3,494.7"></polygon>
                        <polygon points="109.3,494.7 162.3,358.2 304.2,273.7 337.4,359.1"></polygon>
                    </svg>
                    Azuriom
                </a>
                .
                Theme par
                <a class="flex group hover:underline hover:text-steel-50" href="https://bento.me/afi">
                    <svg class="mx-1 w-[1rem] h-[1rem] fill-white group-hover:fill-steel-50" viewBox="0 0 23.758 23.758"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M 22.1 14.276 L 8.779 14.276 C 8.873 13.958 10.356 8.877 10.356 8.877 C 10.356 8.877 10.911 6.872 11.093 6.204 C 11.284 6.868 11.866 8.882 11.866 8.882 C 11.866 8.88 13.301 13.387 13.301 13.387 L 18.525 13.387 L 14.703 2.729 C 14.18 1.16 12.7 0.115 11.048 0.147 C 9.443 0.139 8.012 1.162 7.498 2.686 L 0.55 22.883 C 0.483 23.007 0.485 23.157 0.554 23.281 C 0.655 23.389 0.8 23.44 0.945 23.42 L 5.565 23.42 C 5.843 23.467 6.111 23.288 6.17 23.009 C 6.17 23.007 7.262 19.329 7.453 18.687 L 23.616 18.687 L 22.1 14.276 Z M 21.9 22.833 L 20.739 19.576 L 15.254 19.576 L 16.351 22.965 C 16.413 23.226 16.642 23.412 16.909 23.42 L 21.549 23.42 C 21.679 23.426 21.802 23.37 21.882 23.268 C 21.961 23.135 21.967 22.973 21.9 22.833" />
                    </svg>
                    Afi
                </a>
            </p>
        </div>
    </div>
</div>
