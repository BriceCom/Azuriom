<footer class=" bg-steel-400 py-14 mt-32 lg:mt-64 text-white">
   <div class="container mx-auto px-8 lg:px-0">
       <a href="/" title="Page d'accueil de {{ site_name() }}" class="flex items-center gap-3 text-2xl"><img src="{{theme_asset('static/hypestudio.webp')}}" alt="Logo de {{site_name()}}" height="31" width="27"> <b>HypeStudio</b></a>
       <p class="my-6 opacity-75 font-light">{{ setting('copyright') ?? "Tous droit réservés - HypeStudios" }}</p>

       <div class="flex flex-col lg:flex-row gap-4 justify-between">
           <ul class="flex flex-col gap-2 text-sm">
               @foreach (theme_config('footer_sublinks') ?? [] as $link)
                   <li><a href="{{ $link['name'] }}">{{ $link['name'] }}</a></li>
               @endforeach
           </ul>

           <div class="flex flex-col lg:flex-row gap-6">
               <ul class="flex items-center flex-wrap gap-6">
                   @foreach(social_links() as $link)
                       <li>
                           <a href="{{ $link->value }}" target="_blank" rel="noopener noreferrer" class="uppercase font-semibold">
                               {{ $link->title }}
                           </a>
                       </li>
                   @endforeach
               </ul>

               @include('components.join-button')
           </div>

       </div>
   </div>

</footer>
