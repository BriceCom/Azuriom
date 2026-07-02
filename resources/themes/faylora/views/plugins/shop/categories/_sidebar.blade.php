<div class="col-span-12 xl:col-span-3">
    @auth
    <div class="rounded-2xl bg-steel-100">
        <div class="flex flex-col py-8 px-8 bg-steel-200 rounded-2xl overflow-hidden gap-8">
            <div class="flex flex-raw items-center justify-between w-full">
                <div class="flex justify-center items-center w-auto overflow-hidden">
                    <div>
                        <img class="absolute h-10 rounded-lg shadow-xl mx-auto z-50"
                            src="{{ auth()->user()->getAvatar(150) }}">
                        <div class="h-10 w-10 bg-steel-300 flex justify-center items-center rounded-lg">
                            <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-full mr-4 text-ellipsis truncate">
                        <h4 class="text-white font-semibold text-xs truncate">{{ auth()->user()->name }}</h4>
                    </div>
                </div>
                @if(use_site_money())
                <div>
                    <div
                        class="flex flex-raw justify-center items-center rounded-xl bg-steel-300 h-12 pl-5 pr-3 text-white">
                        <p class="text-white text-sm font-semibold mr-2 ml-3">{{ auth()->user()->money }}</p>
                        <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2 mr-3">
                    </div>
                </div>
                @endif
            </div>
            @if(use_site_money())
            <a class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-100 text-white font-semibold transition-all text-xs truncate"
                href="{{ route('shop.offers.select') }}" data-ripple-dark="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                    <path
                        d="M95.5 104h320a87.73 87.73 0 0111.18.71 66 66 0 00-77.51-55.56L86 94.08h-.3a66 66 0 00-41.07 26.13A87.57 87.57 0 0195.5 104zM415.5 128h-320a64.07 64.07 0 00-64 64v192a64.07 64.07 0 0064 64h320a64.07 64.07 0 0064-64V192a64.07 64.07 0 00-64-64zM368 320a32 32 0 1132-32 32 32 0 01-32 32z" />
                    <path
                        d="M32 259.5V160c0-21.67 12-58 53.65-65.87C121 87.5 156 87.5 156 87.5s23 16 4 16-18.5 24.5 0 24.5 0 23.5 0 23.5L85.5 236z" />
                </svg>
                {{ trans('shop::messages.cart.credit') }}
            </a>
            @endif
            <a class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-100 text-white font-semibold transition-all text-xs truncate"
                href="{{ route('shop.cart.index') }}" data-ripple-dark="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-6 w-6 mr-0.5" viewBox="0 0 512 512">
                    <path xmlns="http://www.w3.org/2000/svg"
                        d="M424.11 192H360L268.8 70.4a16 16 0 00-25.6 0L152 192H87.89a32.57 32.57 0 00-32.62 32.44 30.3 30.3 0 001.31 9l46.27 163.14a50.72 50.72 0 0048.84 36.91h208.62a51.21 51.21 0 0049-36.86l46.33-163.36a15.62 15.62 0 00.46-2.36l.53-4.93a13.3 13.3 0 00.09-1.55A32.57 32.57 0 00424.11 192zM256 106.67L320 192H192zm0 245a37.7 37.7 0 1137.88-37.7A37.87 37.87 0 01256 351.63z" />
                </svg>
                {{ trans('shop::messages.cart.title') }}
            </a>
        </div>
    </div>
    @endauth
    @if(isset($sales))
    @foreach ($sales as $sale)
    @if($sale->is_enabled)
    <div class="rounded-2xl bg-steel-100 @auth mt-10 @endauth">
        <div
            class="flex flex-col items-center justify-between pr-6 py-8 bg-steel-200 rounded-2xl overflow-hidden gap-5 select-none">
            <a
                class="flex flex-raw bg-steel-300 w-full rounded-r-xl space-x-8 group hover:bg-steel-100 transition duration-300 cursor-pointer">
                <div class="relative w-24 group-hover:scale-110 transition duration-200">
                    <div class="z-0 absolute h-10 w-10 bg-[#e7c123] blur-xl mx-8 my-4"></div>
                    <img class="absolute h-20 w-20 top-0 mx-4" src="{{ theme_asset('img/coin.png') }}">
                </div>
                <div class="flex flex-col my-auto pt-3 pb-3 truncate">
                    <h4 class="text-white font-semibold text-sm">Coins</h4>
                    <p class="text-white text-xs truncate py-1"><span
                            class="bg-primary px-1 py-0.5 rounded-md mr-1 text-white font-medium">-{{ $sale->discount
                            }}%</span> avec le
                        code <span class="font-bold">{{
                            $sale->code }}</span></p>
                </div>
            </a>
        </div>
    </div>
    @endif
    @endforeach
    @endif
    @if($topCustomer !== null)
    <div class="rounded-2xl bg-steel-100 mt-10">
        <div
            class="flex flex-raw items-center justify-between md:justify-start py-6 px-8 bg-steel-200 rounded-2xl overflow-hidden h-24">
            <div class="relative w-20 h-full">
                <img class="z-20 absolute shadow-xl shadow-2xl -top-10 w-16 mt-6"
                    src="https://api.mineatar.io/body/full/{{ $topCustomer->user->name }}"
                    alt="{{ $topCustomer->user->name }}">
                <div class="z-0 absolute h-16 w-16 bg-steel-50 blur-2xl"></div>
            </div>
            <div class="flex flex-col md:pl-6 pl-0 md:pr-0 pr-2">
                <h1 class="text-white text-lg font-semibold">{{ $topCustomer->user->name }}</h1>
                <p class="text-white text-xs font-medium">{{ trans('shop::messages.top.title') }}</p>
            </div>
        </div>
    </div>
    @endif
    @if($goal !== false)
    <div class="rounded-2xl bg-steel-100 mt-10">
        <div class="flex flex-col px-6 bg-steel-200 rounded-2xl overflow-hidden h-28">
            <div class="my-auto">
                <div class="flex justify-between">
                    <h1 class="text-sm text-white font-semibold my-auto">{{ trans('shop::messages.goal.title') }}</h1>
                    <p class="text-sm text-primary font-semibold my-auto">{{ min($goal, 100) }}%</p>
                </div>
                <div class="mt-3 flex flex-col justify-start w-full">
                    <div class="relative h-2 bg-steel-100 rounded w-full">
                        <div class="absolute top-0 left-0 h-2 bg-primary rounded" style="width: {{ min($goal, 100) }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(config('theme.current-offer'))
    @forelse($category->packages as $id => $package)
    @if($package->id == config('theme.current-offer'))
    <div class="rounded-2xl bg-steel-100 mt-10 cursor-pointer" id="widget_current_offer"
        data-hs-overlay="#dmodal-{{ $package->id - 1 }}" data-ripple-dark="true">
        <div class="flex justify-between px-8 pt-8">
            <p class="text-white my-auto text-sm font-semibold truncate mr-4 ">
                Offre du moment
            </p>
        </div>
        @if($package->hasImage())
        <div class="flex flex-raw justify-center items-end my-auto mx-auto overflow-hidden">
            <img class="h-48" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
        </div>
        @endif
        <div class="grid md:grid-cols-2 grid-cols-1 gap-8 px-8 pb-8">
            <div class="flex text-white font-medium tracking-tighter overflow-hidden my-auto">
                <span class="text-2xl font-bold truncate">{{ $package->name }}</span>
            </div>
            <div
                class="py-2 px-4 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-200 text-white font-semibold transition-all text-xs truncate">
                <p class="text-white text-sm font-semibold mr-2 ml-3">
                    @if($package->isDiscounted())
                    <del class="text-xs text-danger">{{ $package->getOriginalPrice() }}</del>
                    @endif
                    {{ $package->getPrice() }}
                </p>
                <img src="{{ theme_asset('img/credit.png') }}" class="h-9 w-9 -mt-2 mr-3">
            </div>
        </div>
    </div>
    @endif
    @empty
    <div>Null</div>
    @endforelse
    @endif
</div>