@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <div style="font-size-adjust: {{theme_config('vote.index.fontSize') != 0 ?  theme_config('vote.index.fontSize'):"unset"}};">
        <hgroup>
            <h1 class="title-bl wow fadeIn text-center" data-wow-duration="2s">
                <div class="color-white">
                    {{ theme_config('vote.index.vote.title') ?? trans('vote::messages.sections.vote') }}
                </div>
                <div class="subtitle">
                    {{ theme_config('vote.index.vote.title') ?? trans('vote::messages.sections.vote') }}
                </div>
            </h1>

            <div class="title-description mt30 fweight-300 text-center mt-0 wow fadeIn" data-wow-duration="3s">
                {!! theme_config('vote.index.vote.text') ?? "Texte à définir" !!}
            </div>
        </hgroup>

        <div class="mb-15">
            <div class="position-relative" id="vote-card">
                <div class="spinner-parent h-100">
                    <div class="spinner-border text-white" role="status"></div>
                </div>

                <div class="@auth d-none @endauth" data-vote-step="1">
                    <form class="row justify-content-center" action="{{ route('vote.verify-user', '/') }}" id="voteNameForm">
                        <div class="col-md-6 col-lg-4">
                            <div class="d-flex gap-3 mb-3">
                                <input type="text" id="stepNameInput" name="name" class="form-control"
                                       value="{{ $name }}"
                                       placeholder="{{ trans('messages.fields.name') }}" required>
                                <button type="submit" class="btn btn-primary rounded-2">
                                    {{ trans('messages.actions.continue') }}
                                    <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="@guest d-none @endguest h-100 text-center" data-vote-step="2">
                    @forelse($sites as $site)
                        <a class="btn btn-primary m-1 wow fadeIn" data-wow-duration="{{$loop->iteration/2}}s" href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                           data-vote-id="{{ $site->id }}"
                           data-vote-url="{{ route('vote.vote', $site) }}"
                           @auth data-vote-time="{{ $site->getNextVoteTime($user, $request)?->valueOf() }}" @endauth>
                            <span class="badge bg-secondary text-white vote-timer"></span> {{ $site->name }}
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

        <div class="row gy-15 gx-8">
            <div class="@if($displayRewards) col-lg-9 @else col-lg-12 @endif">
                <div>
                    <hgroup>
                        <h2 class="title-bl wow fadeIn" data-wow-duration="2s">
                            <div class="color-white">
                                {{ theme_config('vote.index.top.title') ?? trans('vote::messages.sections.top') }}
                            </div>
                            <div class="subtitle">
                                {{ theme_config('vote.index.top.title') ?? trans('vote::messages.sections.top') }}
                            </div>
                        </h2>

                        <div class="title-description mt30 fweight-300 mt-0 wow fadeIn" data-wow-duration="3s">
                            {!! theme_config('vote.index.top.text') ?? "Texte à définir" !!}
                        </div>
                    </hgroup>

                    <table class="table mb-0">
                        <thead class="table-dark">
                        <tr class="wow fadeIn" data-wow-duration="1s">
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('messages.fields.name') }}</th>
                            <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($votes as $id => $vote)
                            <tr class="align-middle wow fadeInUp" data-wow-duration="1s">
                                <th scope="row">
                                    @if($loop->iteration === 1 || $loop->iteration === 2 || $loop->iteration === 3)
                                        <i class="bi bi-trophy-fill fs-{{$id+2}}"
                                           style="color: {{ $loop->iteration === 1 ? "#dcb62c":($loop->iteration === 2 ? "#efeeec":"#cb8227") }}"
                                        ></i>
                                    @else
                                        #{{ $id }}
                                    @endif
                                </th>
                                <td><div class="d-flex align-items-center gap-3">
                                        <img src="{{ $vote->user->getAvatar(32) }}" alt="Avatar de {{ $vote->user->name }}" class="rounded-pill">
                                        {{ $vote->user->name }}
                                    </div></td>
                                <td>{{ $vote->votes }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    @auth
                        <div class="text-end wow fadeIn" data-wow-duration="1s">
                            <p class="mt-3 mb-0 badge bg-primary text-dark">{{ trans_choice('vote::messages.votes', $userVotes) }}</p>
                        </div>
                    @endauth
                </div>
            </div>

            @if($displayRewards)
                <div class="col-lg-3">
                    <div>
                        <hgroup>
                            <h3 class="title-bl wow fadeIn fs-1" data-wow-duration="2s">
                                <div class="color-white">
                                    {{ trans('vote::messages.sections.rewards') }}
                                </div>
                                {{--                            <div class="subtitle">--}}
                                {{--                                {{ trans('vote::messages.sections.rewards') }}--}}
                                {{--                            </div>--}}
                            </h3>
                        </hgroup>

                        <ul class="wow fadeIn" data-wow-duration="2s">
                            @foreach($rewards as $reward)
                                <li class="reward-item d-flex align-items-center gap-4 p-2">
                                    @if($reward->image)
                                        <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" width="45">
                                    @endif
                                    <div class="d-flex align-items-center gap-2">
                                        {{ $reward->name }}
                                        <span class="badge bg-{{ $reward->chances > 60 ? "success":($reward->chances > 30 ? "warning text-dark":"danger")}}">{{ $reward->chances }} %</span>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    @if($ipv6compatibility)
        <script src="https://cdn.ipv6-adapter.com/v1/api.js" async defer></script>
    @endif

    <script src="{{ plugin_asset('vote', 'js/vote.js') }}" defer></script>
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
