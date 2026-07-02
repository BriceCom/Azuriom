

            @extends('layouts.app')

@section('title', $page->title)

@section('content')
    @include('wiki::partials._header', ['title' => $page->category->name])

    <div class="mt-8 container mx-auto w-full col-span-12 flex flex-col" id="wiki">
        
            @if(! $page->category->categories->isEmpty())
                <div class="list-group mb-3" role="tablist">
                    @foreach($page->category->categories as $subCategory)
                        @can('view', $subCategory)
                            <a href="{{ route('wiki.show', [$subCategory]) }}" class="list-group-item">
                                <i class="{{ $subCategory->icon ?? 'bi bi-book' }}"></i> {{ $subCategory->name }}
                            </a>
                        @endcan
                    @endforeach
                </div>
            @endif

        
        

       















<!-- Blog Article -->

  <div class="grid lg:grid-cols-3 gap-y-8 lg:gap-y-0 lg:gap-x-6 ">
    <!-- Content -->
    <div class="lg:col-span-2">
      <div class="p-8 border-steel-200 border rounded-2xl">
        <div class="space-y-4">
          @if($page->category->parent !== null)
                <a href="{{ route('wiki.show', $page->category->parent) }}" class="inline-flex items-center gap-x-1.5 text-sm text-white decoration-2 hover:underline" href="#">
                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    {{ trans('wiki::messages.back') }}
                </a>
            @else
                <a href="{{ route('wiki.index') }}" class="inline-flex items-center gap-x-1.5 text-sm text-white decoration-2 hover:underline" href="#">
                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    {{ trans('wiki::messages.back') }}
                </a>
            @endif


            @foreach($page->category->pages as $catPage)
                <div aria-labelledby="card-type-tab-item-{{ $catPage->id }}" id="card-type-tab-{{ $catPage->id }}" role="tabpanel" aria-labelledby="nav-home-tab" class="flex flex-col space-y-6 @if($page->is($catPage)) block @else hidden @endif">

                <h2 class="text-xl font-bold lg:text-3xl text-white">{{ $catPage->title }}</h2>

                    <div class="flex items-center gap-x-5">
                        <p class="text-xs sm:text-sm text-steel-50">{{ $catPage->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="article text-sm text-white leading-5 break-all space-y-5">
                    {!! $catPage->content !!}
                    </div>

                    <div class="hs-dropdown relative flex-auto w-28 rounded-xl flex items-center justify-center font-medium align-middle transition-all text-xs text-white">
               <button type="button" id="blog-article-share-dropdown" class="w-full hover:bg-steel-200 hs-dropdown-toggle p-2 inline-flex justify-center items-center rounded-lg shadow-sm font-medium bg-steel-400 transition duration-200 text-white text-sm ">
                  <svg class="w-4 h-4 fill-white mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z"></path>
                  </svg>
                  Partager
               </button>
               <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 mb-1 z-50 bg-steel-200 shadow-2xl rounded-xl p-2 hidden" aria-labelledby="blog-article-share-dropdown" style="">
                  <input id="link_share_{{ $catPage->id }}" class="hidden" value="{{ route('wiki.pages.show', [$page->category, $page]) }}">
                  <button onclick="document.getElementById('link_share_{{ $catPage->id }}').select();document.getElementById('link_share_{{ $catPage->id }}').setSelectionRange(0, 99999);document.execCommand('copy');navigator.clipboard.writeText(document.getElementById('link_share_{{ $catPage->id }}').value);" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-white hover:bg-steel-100">
                     <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.25 9C1.25 5.27208 4.27208 2.25 8 2.25H12C15.7279 2.25 18.75 5.27208 18.75 9C18.75 12.7279 15.7279 15.75 12 15.75H10C9.58579 15.75 9.25 15.4142 9.25 15C9.25 14.5858 9.58579 14.25 10 14.25H12C14.8995 14.25 17.25 11.8995 17.25 9C17.25 6.10051 14.8995 3.75 12 3.75H8C5.10051 3.75 2.75 6.10051 2.75 9C2.75 10.3451 3.25487 11.5705 4.08664 12.4998C4.36288 12.8085 4.33662 13.2826 4.02797 13.5589C3.71933 13.8351 3.24518 13.8088 2.96894 13.5002C1.90054 12.3065 1.25 10.7283 1.25 9ZM12 9.75C9.10051 9.75 6.75 12.1005 6.75 15C6.75 17.8995 9.10051 20.25 12 20.25H16C18.8995 20.25 21.25 17.8995 21.25 15C21.25 13.6549 20.7451 12.4295 19.9134 11.5002C19.6371 11.1915 19.6634 10.7174 19.972 10.4411C20.2807 10.1649 20.7548 10.1912 21.0311 10.4998C22.0995 11.6935 22.75 13.2717 22.75 15C22.75 18.7279 19.7279 21.75 16 21.75H12C8.27208 21.75 5.25 18.7279 5.25 15C5.25 11.2721 8.27208 8.25 12 8.25H14C14.4142 8.25 14.75 8.58579 14.75 9C14.75 9.41421 14.4142 9.75 14 9.75H12Z"></path>
                     </svg>
                     Copier le lien
                  </button>
               </div>
            </div>

                </div>
            @endforeach
        

        </div>
      </div>
    </div>

    <div class="lg:col-span-1 lg:h-full lg:w-full  flex flex-col border-steel-200 border rounded-2xl p-8">
      <div class="sticky top-0 start-0 py-8 border-l border-steel-400 ">
        <h1 class="text-white font-semibold mb-3 ps-4">{{ $page->category->name }}</h1>
      <ul class="space-y-2">
      
      @foreach($page->category->pages as $catPage)

            <li class="list-group" >
                    <a href="{{ route('wiki.pages.show', [$page->category, $catPage]) }}" class="block py-1 ps-4 -ms-px border-s-2 border-transparent text-sm text-steel-50 hover:border-steel-100 hover:text-white"
                       title="{{ $catPage->title }}"
                       onclick="selectWikiPage(this); location.reload();"
                       data-bs-toggle="tab" data-bs-target="#page-{{ $catPage->id }}" role="tab"
                       aria-controls="page-{{ $catPage->id }}" aria-selected="{{ $page->is($catPage) ? 'true' : 'false' }}">
                        {{ $catPage->title }}
                    </a>
    

             </li>
              @endforeach
            </ul>

      </div>
    </div>

  </div>


    </div>
@endsection

@push('scripts')
    <script>
        let currentTitle = '{{ $page->title }}';

        function selectWikiPage(element, replaceState = false) {
            const tab = bootstrap.Tab.getOrCreateInstance(element);
            tab.show();

            if (replaceState) {
                window.history.replaceState({}, '', element.href);
            } else {
                window.history.pushState({}, '', element.href);
            }

            document.title = document.title.replace(currentTitle, element.title);
            currentTitle = element.title;
        }

        window.onpopstate = function(e) {
            const target = document.querySelector('[href="' + e.target.location.href + '"]');

            if (target) {
                selectWikiPage(target, true);
            }
        };
    </script>
@endpush





