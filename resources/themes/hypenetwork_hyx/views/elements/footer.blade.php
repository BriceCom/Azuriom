<footer class="bg-body-secondary py-7">
   <div class="container">
       <div class="d-flex flex-column align-items-start gap-2">
           <a href="/" title="Page d'accueil de {{ site_name() }}" class="d-flex align-items-center gap-3 logo"><img src="{{theme_asset('images/hypestudio.webp')}}" alt="Logo de {{site_name()}}" height="31"> <b>HypeStudio</b></a>
           <p data-bs-toggle="tooltip" title="{{ setting('copyright') ?? "Tous droit réservés - HypeStudios" }}. Crée par Dixept.fr et Itsme.to, propulsé par Azuriom.com" class="d-inline-block w-fit mt-2 text-muted">{{ setting('copyright') ?? "Tous droit réservés - HypeStudios" }}</p>
       </div>

       <div class="d-flex justify-content-between flex-column flex-lg-row align-items-md-end gap-lg-6 gap-3">
           <ul class="text-sm d-flex flex-column gap-3 list-unstyled my-5 mb-lg-0 mt-lg-2">
               @if(theme_config('footer.index.linksLeft'))
                   @foreach(theme_config('footer.index.linksLeft') as $link)
                       @if(!empty($link['text']))
                           <li><a href="{{ $link['url'] }}" class="fw-semibold text-decoration-none">{{ $link['text'] }}</a></li>
                       @endif
                   @endforeach
{{--               @else--}}
{{--                   <li><a href="/mentions-legales" class="fw-semibold text-decoration-none">Mentions Légales</a></li>--}}
{{--                   <li><a href="/cgu-cgv" class="fw-semibold text-decoration-none">Conditions générales d’utilisation et de vente</a></li>--}}
               @endif
           </ul>

           <div class="d-flex flex-column flex-lg-row align-items-center gap-4 gap-lg-6">
               <ul class="d-flex flex-wrap justify-content-center justify-content-lg-start align-items-lg-center gap-5 gap-lg-6 list-unstyled mb-0">
                   @foreach(social_links() as $link)
                       <li>
                           <a href="{{ $link->value }}" target="_blank" rel="noopener noreferrer" class="social text-uppercase fw-semibold text-decoration-none" style="--social-color: {{ $link->color }}">
                               {{ $link->title }}
                           </a>
                       </li>
                   @endforeach
               </ul>

               @include('components.join-button', ['btn' => 'tertiary'])
           </div>

       </div>
   </div>

</footer>
