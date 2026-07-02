    <div class="card mb-3">
       <div class="card-body">
           @auth
               <div class="d-flex flex-column gap-4">
                   <div class="d-flex gap-3">
                       <img src="{{Auth::user()->getAvatar(64)}}" alt="{{Auth::user()->name}}" class="object-fit-contain" width="64" height="64"/>

                       <div class="d-flex flex-column align-items-start gap-2">
                               <span class="d-block badge text-m" style="background-color: {{Auth::user()->role->color}};">{{Auth::user()->role->name}}</span>
                           <span class="fw-bold">{{Auth::user()->name}}</span>

                       </div>
                   </div>

                   @if(use_site_money())
                       <p class="m-0 text-m">Vous avez {{Auth::user()->money}} {{money_name()}}</p>
                   @endif

                   <div class="d-flex align-items-start gap-2 flex-wrap @if(use_site_money()) flex-lg-row @endif">
                       <a href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block">
                           {{ trans('shop::messages.cart.title') }}
                       </a>
                       @if(use_site_money())
                           <a href="{{ route('shop.offers.select') }}" class="btn btn-secondary btn-block">
                               Créditer
                           </a>
                       @endif
                   </div>
               </div>

           @else
               <div class="d-flex flex-column justify-content-between gap-4">
                   <hgroup>
                       <h3 class="h5">{{theme_config('shop.title') ?? "Lorem ipsum dolor sit amet"}}</h3>
                       <p class="mb-0">{{ theme_config('shop.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis eos facilis natus nesciunt quisquam sed."}}</p>
                   </hgroup>

                  <ul class="d-flex align-items-center gap-3 list-unstyled m-0">
                      <li>
                          <a class="btn btn-primary" href="{{ route('login') }}">
                              {{ trans('auth.login') }}
                          </a>
                      </li>

                      @if(Route::has('register'))
                          <li class="text-end mt-2">
                              <a href="{{ route('register') }}">
                                  {{ trans('auth.register') }}
                              </a>
                          </li>
                      @endif
                  </ul>
               </div>
           @endauth
       </div>
    </div>

