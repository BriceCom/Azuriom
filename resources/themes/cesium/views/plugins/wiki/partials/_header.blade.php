
   <div class="container mx-auto w-full col-span-12 flex flex-col">
      <div class="flex flex-raw flex-shrink-0 items-center justify-between py-4 px-4  border-steel-200 border rounded-2xl overflow-hidden">
         <form class="mt-1" action="{{ route('wiki.search') }}" method="GET" role="search">
            <label for="email" class="flex relative w-full h-12 border border-steel-200 hover:border-white rounded-xl">
            <input type="search" id="searchInput" name="q" value="{{ $search ?? '' }}" class="px-5 h-full block w-full outline-none bg-transparent text-xs text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis" placeholder="{{ trans('messages.actions.search') }}" required="">
            <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('messages.actions.search') }}</span>
            </label>
         </form>
      </div>
   </div>

