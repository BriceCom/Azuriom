<div id="plutonia_sidebar" class="d-flex flex-column gap-2">
    <hr>
    @guest
    <div>
        <h2 class="fs-5 text-uppercase fw-bold"><i class="bi bi-person-fill"></i> <u>Se connecter</u></h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-1">
                <input id="email" type="text" placeholder="{{ trans('auth.email') }}" class="form-control bg-white py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>

            <div>
                <input id="password" type="password" placeholder="{{ trans('auth.password') }}" class="form-control bg-white py-2 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>


            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column gy-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-secondary text-decoration-none">
                                {{ trans('auth.forgot_password') }}
                            </a>
                        @endif
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>

                                <label class="form-check-label" for="remember">
                                    {{ trans('auth.remember') }}
                                </label>
                            </div>
                </div>
                <button type="submit" class="btn btn-primary d-block py-1">
                    ME CONNECTER
                </button>
            </div>
        </form>
    </div>
    <hr>
    @endguest
    <div>
        <h2 class="fs-5 text-uppercase fw-bold"><i class="bi bi-share-fill"></i> <u>Réseaux Sociaux</u></h2>
        <ul class="d-flex flex-column gap-2 p-0 mb-0 list-unstyled">
            @foreach(social_links() as $link)
                <li>
                    <a id="reseau_{{$link->title}}" href="{{ $link->value }}" title="{{ $link->title }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary text-decoration-none w-100 text-uppercase fs-5">
                        <i class="{{ $link->icon }}"></i>
                        <span>{{ $link->title }}</span>
                    </a>
                </li>
                @push('styles')
                    <style>
                        #reseau_{{$link->title}}:hover{
                            background-color: {{$link->color}};
                            border-color: {{$link->color}};
                        }
                    </style>
                @endpush
            @endforeach
        </ul>
    </div>
    <hr>
    <div>
        <h2 class="fs-5 text-uppercase fw-bold"><i class="bi bi-star-fill"></i> <u>Top voteurs</u></h2>
        <ul class="list-unstyled my-2">

            @php
              $index = 0;
            @endphp

            @forelse(vote_leaderboard()->take(3) as $vote)

            @php
              $index+=1;
            @endphp

                <div class="vote">
                  <div class="avatar">
                    <img src="{{$vote->user->getAvatar()}}" alt="Avatar de {{$vote->user->name}}" height="32">
                  </div>
                  <div class="info">
                    <div class="username">
                      {{$vote->user->name}}
                    </div>
                    <div class="count">
                      {{$vote->votes}} vote{{ $vote->votes > 1 ? 's' : '' }}
                    </div>
                  </div>
                  <div class="gift">
                    <?php
                      $result = intval($vote->votes * 2.5, 10);
                      echo $result." crédits";
                    ?>
                  </div>
                  <div class="rank">
                    #@php echo $index; @endphp
                  </div>
                </div>
            @empty
                <li>Aucun voteur !</li>
            @endforelse
        </ul>
        <a href="{{ plugins()->enable('vote') ? route('vote.home'):'#'}}" class="text-uppercase text-decoration-none"><u>Accéder à la page de vote</u></a>
    </div>
    <hr>
    @php($users = \Azuriom\Models\User::all())
    <div>
        <h2 class="fs-5 text-uppercase fw-bold"><i class="bi bi-graph-up-arrow"></i> <u>Statistiques</u></h2>
        <ul class="list-unstyled my-2">
            <li>
                <span class="text-decoration-underline">Inscrit(s) aujourd'hui:</span> {{ \Azuriom\Models\User::whereDate('created_at',  \Carbon\Carbon   ::today())->get()->count() }}
            </li>
            <li>
                <span class="text-decoration-underline">Inscrit(s) au total:</span> {{$users->count()}}
            </li>
            <li>
                <span class="text-decoration-underline">Dernier inscrit:</span> {{$users->last()->name}}
            </li>
        </ul>
    </div>
    <hr>
</div>
