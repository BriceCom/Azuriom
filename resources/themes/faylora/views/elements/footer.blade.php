<footer class="pb-8 pt-24 bg-steel-100 overflow-hidden mt-16 border-tertiary border-t-4">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap -mb-10">
            <div class="w-full md:w-1/3 lg:w-1/5 mb-10 ">
                <h4 class="font-semibold text-white mb-4 uppercase">ValorSky</h4>
                <ul>
                    <li class="mb-2"><a class="inline-block text-2xs text-steel-50 hover:text-white font-medium"
                            href="/news">Articles</a>
                    </li>
                    <li class="mb-2"><a class="inline-block text-2xs text-steel-50 hover:text-white font-medium"
                            href="/vote">Voter & Gagner</a></li>
                    <li class="mb-2"><a class="inline-block text-2xs text-steel-50 hover:text-white font-medium"
                            href="https:/discord.gg/nebulia" target="_blank">Support</a></li>
                </ul>
            </div>
            <div class="w-full md:w-1/3 lg:w-1/5 mb-10">
                <h4 class="font-semibold text-white mb-4 uppercase">Lien utiles</h4>
                <ul>
                    <li class="mb-2"><a class="inline-block text-2xs text-steel-50 hover:text-white font-medium"
                            href="/shop">Boutique</a></li>
                    <li class="mb-2"><a class="inline-block text-2xs text-steel-50 hover:text-white font-medium"
                            href="https:/discord.gg/nebulia" target="_blank">Support</a></li>
                    <li class="mb-2"><a class="inline-block text-2xs text-steel-50 hover:text-white font-medium"
                            href="/reglement">Règlement</a></li>
                </ul>
            </div>
            <div class="w-full md:w-1/3 lg:w-1/5 mb-10">
                <h4 class="font-semibold text-white mb-4 uppercase">Communauté</h4>
                <ul>
                    @foreach(social_links() as $link)
                    <li class="mb-2"><a class="inline-block text-2xs text-steel-50 hover:text-white font-medium"
                            href="{{ $link->value }}" title="{{ $link->title }}" target="_blank"
                            rel="noopener noreferrer">{{ $link->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="w-full xs:w-1/2 md:w-full lg:w-1/5 ml-auto">
                <a class="inline-block h-full justify-center items-center flex flex-col" href="{{ route('home') }}">
                    @if(setting('logo'))
                    <img class="w-64" src="{{ image_url(setting('logo')) }}" alt="{{ site_name() }}">
                    @endif
                    <p
                        class="mx-1 my-auto bg-steel-200/50 px-2.5 rounded-lg justify-center items-center py-1 text-white text-sm">
                        <span id="player-count-footer" class="inline-flex justify-center items-center my-auto">
                            @if($server && $server->isOnline()){{ $server->getOnlinePlayers() }}@else 0 @endif
                        </span>
                        Joueurs connectés
                    </p>
                </a>
            </div>
        </div>
        <div class="mt-20 mb-4 pb-3 border-b border-gray-500">
            <div class="flex flex-wrap -mx-4 -mb-2">
                <div class="px-4 mb-2"><a class="inline-block text-xs text-steel-50 hover:text-white font-medium"
                        href="/mentions-legales">Mentions légales</a></div>

            </div>
        </div>
        <div class="md:justify-between md:flex space-y-3">
            <p class="text-xs text-steel-50 font-medium">{{ setting('copyright') }}</p>
            <p class="text-xs text-steel-50 font-medium flex">
                Propulsé par
                <a target="_blank" class="group hover:text-white hover:underline flex" href="https://azuriom.com/fr/">
                    <svg class="h-4 mx-0.5 fill-steel-50 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg"
                        version="1.1" viewBox="0 0 500 500">
                        <polygon points="201.1,8.1 298.2,8.1 486.5,494.7 390,494.7" />
                        <polygon points="249.7,133.2 201.2,8.1 12.8,494.7 109.3,494.7" />
                        <polygon points="109.3,494.7 162.3,358.2 304.2,273.7 337.4,359.1" />
                    </svg>
                    Azuriom
                </a>
                . Theme Esus par <a href="https://twitter.com/dev_afi" target="_blank"
                    class="hover:text-white hover:underline mx-1">Afi</a>
                . Intégration par <a href="https://bryanm.fr/" target="_blank"
                    class="hover:text-white hover:underline mx-1">Bryan M.</a>
            </p>
        </div>
    </div>
</footer>
