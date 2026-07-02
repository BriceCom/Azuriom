@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')

   <div class="vote__select d-flex flex-column flex-lg-row align-items-start">
       <div class="vote__sites">
           <hgroup>
               <h1 class="mb-5">{{ trans('vote::messages.sections.vote') }}</h1>
               <p>Votez dès maintenant et gagnez des récompenses en jeu !</p>
           </hgroup>

           <div id="vote-card" class="position-relative">
               <div class="spinner-parent h-100">
                   <div class="spinner-border text-white" role="status"></div>
               </div>

               <div class="@auth d-none @endauth" data-vote-step="1">
                   <form action="{{ route('vote.verify-user', '') }}" id="voteNameForm">
                       <div>
                           <div class="mb-3">
                               <label for="stepNameInput" class="form-label">Votre Pseudo</label>
                               <input type="text" id="stepNameInput" name="name" class="form-control mb-6"
                                      value="{{ $name }}" required>
                           </div>

                           <button type="submit" class="btn btn-tertiary">
                               {{ trans('messages.actions.continue') }}
                               <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                           </button>
                       </div>
                   </form>
               </div>

               <div class="d-flex flex-wrap gap-4 @guest d-none @endguest h-100" data-vote-step="2">
                   @forelse($sites as $site)
                       @php
                           $hours = intdiv($site->vote_delay, 60); // Récupère le nombre d'heures entières
                           $minutes = $site->vote_delay % 60;
                       @endphp
                       <a class="vote__site" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                          data-vote-id="{{ $site->id }}"
                          data-vote-url="{{ route('vote.vote', $site) }}"
                          @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth>
                           <span class="vote__site-name">{{ $site->name }}</span>
                           <span class="vote__site-time">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M8.9998 16.1998C12.9763 16.1998 16.1998 12.9763 16.1998 8.9998C16.1998 5.02335 12.9763 1.7998 8.9998 1.7998C5.02335 1.7998 1.7998 5.02335 1.7998 8.9998C1.7998 12.9763 5.02335 16.1998 8.9998 16.1998ZM9.7498 4.4998C9.7498 4.08559 9.41402 3.7498 8.9998 3.7498C8.58559 3.7498 8.2498 4.08559 8.2498 4.4998V8.9998C8.2498 9.41402 8.58559 9.7498 8.9998 9.7498H12.5998C13.014 9.7498 13.3498 9.41402 13.3498 8.9998C13.3498 8.58559 13.014 8.2498 12.5998 8.2498H9.7498V4.4998Z"
                                      fill="#9CA3AF"/>
                            </svg>
                               <span class="vote-timer">{{Carbon\CarbonInterval::hours($hours)->minutes($minutes)->format('%hh %Imin')}}</span>
                        </span>
                       </a>
                   @empty
                       <div class="alert alert-warning" role="alert">
                           {{ trans('vote::messages.errors.site') }}
                       </div>
                   @endforelse
               </div>

               <div class="d-none" data-vote-step="3">
                   <p id="vote-result"></p>
               </div>
           </div>
       </div>

       @if($displayRewards)
               <div class="vote__rewards card bg-body-secondary border-0">
                   <h2 class="h4 card-title text-center">
                       {{ trans('vote::messages.sections.rewards') }}
                   </h2>


                   <div class="vote__rewards-items d-flex flex-wrap">
                       @foreach($rewards as $reward)
                           <div class="d-flex flex-column gap-3">
                               <div class="flex-grow-1">
                                   @if($reward->image)
                                       <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" height="155">
                                   @endif
                               </div>
                               <span>{{ $reward->name }}</span>
                           </div>
                       @endforeach
                   </div>
               </div>
       @endif
   </div>

    <div class="vote__classement">
        <hgroup>
            <h2 class="mb-5">
                Classement du mois
            </h2>
            <p class="m-0">Montez en haut du classement pour recevoir des récompenses uniques.</p>
        </hgroup>

        <table class="table mb-0">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('messages.fields.name') }}</th>
                <th scope="col">Récompenses</th>
                <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($votes as $id => $vote)
                <tr class="vote__reward-{{$loop->iteration}}">
                    <th scope="row"><b>#{{ $id }}</b></th>
                    <td>
                        <div>
                            <img class="rounded-3 me-3" src="{{ $vote->user?->getAvatar() != null ? $vote->user->getAvatar(48):'https://mc-heads.net/avatar/'.($vote->user_name??'').'/48.png' }}"
                                 alt="Avatar de {{ $vote->user->name ?? ($vote->user_name??'')}}">
                            {{ $vote->user->name ?? ($vote->user_name??'')}}
                        </div>
                    </td>
                    <td><span class="vote__reward d-flex align-items-center">{{theme_config('vote.index.reward.'.$loop->iteration) ?? '500'}}  <img aria-hidden="true" src="{{ theme_config('vote.index.rewardImg') ? image_url(theme_config('vote.index.rewardImg')):theme_asset('images/reward.png') }}" alt="Illustration d'une récompense" height="24" width="24"></span></td>
                    <td><b>{{ $vote->votes }}</b></td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
    @if($ipv6compatibility)
        <script src="https://cdn.ipv6-adapter.com/v1/api.js" async defer></script>
    @endif

    <script src="{{ theme_asset('js/vote.js') }}" defer></script>
    @auth
        <script>
            window.username = '{{ $user->name }}';
        </script>
    @endauth
@endpush

@push('styles')
    <style>
        #vote-card .spinner-parent {
            display: none;
        }

        #vote-card.voting .spinner-parent {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(70, 70, 70, 0.6);
            z-index: 10;
        }
    </style>
@endpush
