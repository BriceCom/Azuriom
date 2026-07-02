<div class="d-grid gap-2 mt-3 mb-5">
    <div class="card">
       <div class="card-body">
           @auth
               <div class="d-flex justify-content-between align-items-center">
                   <div class="d-flex gap-4">
                       <img src="{{Auth::user()->getAvatar(64)}}" alt="{{Auth::user()->name}}" class="object-fit-contain" width="64" height="64"/>

                       <div class="d-flex flex-column align-items-start gap-2">
                           <span class="d-block badge text-m" style="background-color: {{Auth::user()->role->color}};">{{Auth::user()->role->name}}</span>
                           @if(use_site_money())
                               <p class="m-0 text-m">{{Auth::user()->money}} {{money_name()}} (<a href="{{ route('shop.offers.select') }}" class="text-warning">{{ trans('shop::messages.cart.credit') }}</a>)</p>
                           @endif
                       </div>
                   </div>

                   <div class="d-flex @if(!use_site_money()) align-items-center justify-content-center @endif flex-column">
                       <a href="{{ route('shop.cart.index') }}" class="btn btn-primary btn-block">
                           <i class="bi bi-cart"></i> {{ trans('shop::messages.cart.title') }}
                       </a>
                   </div>
               </div>

           @else
               <div class="d-flex justify-content-between align-items-center">
                   <hgroup class="col-md-6">
                       <h3 class="h5">{{theme_config('shop.title') ?? "Lorem ipsum dolor sit amet"}}</h3>
                       <p class="mb-0">{{ theme_config('shop.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis eos facilis natus nesciunt quisquam sed."}}</p>
                   </hgroup>
                  <ul class="list-unstyled">
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
</div>

