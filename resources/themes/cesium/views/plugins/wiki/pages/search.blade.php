@extends('layouts.app')

@section('title', trans('wiki::messages.search.results'))

@section('content')
    @include('wiki::partials._header', ['title' => trans('wiki::messages.search.results')])

    <div id="wiki" class="mt-8 container mx-auto w-full col-span-12 flex flex-col">
        @forelse($pages as $page)
        <a class="mb-8" href="{{ route('wiki.pages.show', [$page->category, $page]) }}">
        <div class="flex flex-raw flex-shrink-0 items-center justify-between py-4 px-4  border-steel-200 border rounded-2xl overflow-hidden">
        <div class="flex justify-center items-center w-auto overflow-hidden">
            <div>
                
                <div class="h-10 w-10 flex justify-center items-center">
                <i class="text-white text-xl {{ $page->category->icon ?? 'bi bi-book' }}"></i>
                </div>
            </div>
            <div class="flex flex-col pl-4">
                
                    <div class="hs-tooltip inline-block [--trigger:hover] [--placement:bottom]">
                    <div class="hs-tooltip-toggle block text-left cursor-pointer">
                        <div class="font-semibold text-white truncate">
                            {{ $page->title }}
                            <span class="my-auto badge text-xs rounded px-1 py-0.5 bg-steel-200">{{ $page->category->name }}</span>
                        </div>
                    </div>
                    </div>
                    <ul class="text-xs text-steel-50">
                    <li class="inline-block relative last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-steel-50 before:rounded-full">
                    {{ Str::limit(strip_tags($page->content), 300) }}
                    </li>
                    </ul>
                
            </div>
        </div>
        </div>
        </a>


        @empty
                <div class="container mx-auto w-full col-span-12 flex flex-col">
                    <div class="container px-4 py-5 mx-auto border rounded-2xl border-steel-200 mb-8" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0 my-auto">
                                <svg class="fill-white h-6 my-auto flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM8.96963 8.96965C9.26252 8.67676 9.73739 8.67676 10.0303 8.96965L12 10.9393L13.9696 8.96967C14.2625 8.67678 14.7374 8.67678 15.0303 8.96967C15.3232 9.26256 15.3232 9.73744 15.0303 10.0303L13.0606 12L15.0303 13.9696C15.3232 14.2625 15.3232 14.7374 15.0303 15.0303C14.7374 15.3232 14.2625 15.3232 13.9696 15.0303L12 13.0607L10.0303 15.0303C9.73742 15.3232 9.26254 15.3232 8.96965 15.0303C8.67676 14.7374 8.67676 14.2625 8.96965 13.9697L10.9393 12L8.96963 10.0303C8.67673 9.73742 8.67673 9.26254 8.96963 8.96965Z"/>
                                </svg>
                            </div>
                            <div class="flex items-center justify-between flex-1 ml-4">
                                <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
                                {{ trans('wiki::messages.search.empty') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
        @endforelse
    </div>
@endsection
