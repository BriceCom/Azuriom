@extends('layouts.app')
@section('content')
    <div class="grid place-content-center mx-auto">
        <section class="flex items-center h-full p-16">
            <div class="container flex flex-col items-center justify-center px-5 mx-auto my-8">
                <div class="max-w-md text-center text-white">
                    <h2 class="mb-8 font-semibold text-9xl">
                        @yield('code')
                    </h2>
                    <p class="text-2xl font-semibold md:text-3xl">@yield('title')</p>
                    <p class="mt-4 mb-12 text-steel-50">@yield('message')</p>
                    <a href="{{ route('home') }}"
                        class="whitespace-nowrap bg-steel-200 hover:bg-steel-100 py-3 px-5 inline-flex rounded-full items-center justify-center text-sm font-medium text-white transition ease-in-out duration-300 tracking-wide">
                        {{ trans('errors.home') }}
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
