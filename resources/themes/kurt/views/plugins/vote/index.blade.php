@extends('layouts.app')

@section('title', trans('vote::messages.title'))

@section('content')
    <hgroup>
        <h1>{{ theme_config('vote.title') ?? trans('vote::messages.sections.vote') }}</h1>
        @if(theme_config('vote.text'))
            <p class="col-lg-6 text-muted">{{ theme_config('vote.text') }}</p>
        @endif
    </hgroup>

    <div class="row gy-4 mb-15">
        <div class="col-lg-7">
            <div class="d-flex flex-column gap-4">
                @include('plugins.vote.sites')

                @include("plugins.vote._components.goal")
            </div>

        </div>
        <div class="col">
            <div class="d-flex flex-column gap-4">
                @include('plugins.vote.rewards')
            </div>
        </div>
    </div>


    <h2 class="mb-3">
                {{ trans('vote::messages.sections.top') }}
        </h2>

    <div class="card mb-15">
        <div class="card-body">
            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Top</th>
                    <th scope="col">{{ trans('theme::theme.player') }}</th>
                    @if(theme_config('vote.rewards.on'))
                        <th scope="col">{{ theme_config('vote.rewards.text') ?? 'Lorem' }}</th>
                    @else
                        <th scope="col">
                            Reward
                        </th>
                    @endif
                    <th scope="col" class="text-end">{{ trans('vote::messages.fields.votes') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($votes as $id => $vote)
                    <tr>
                        <th scope="row">
                            <div>
                                #{{ $id }}
                            </div>
                        </th>
                        <td>
                            <span>
                                <img aria-hidden="true" class="rounded" src="{{$vote->user->getAvatar(32)}}" width="32" alt="{{$vote->user->name}}">
                            </span>
                            <span class="ms-2">{{ $vote->user->name }}</span>
                        </td>
                        @if(theme_config('vote.rewards.on'))
                            <td>
                                <span class="badge text-dark py-2.5 px-2.5" style="background-color: {{theme_config('vote.rewards.topColor.'.$id) ? theme_config('vote.rewards.topColor.'.$id) : '#282828'}};">
                                    {{theme_config('vote.rewards.top.'.$id) ? theme_config('vote.rewards.top.'.$id) : ''}}
                                </span>
                            </td>
                        @else
                            <td>
                                <span class="badge py-2.5 px-2.5 text-white" style="background-color: #282828">
                                    1000 gems
                                </span>
                            </td>
                        @endif
                        <td class="text-end">{{ $vote->votes }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            @auth
                <p class="mt-3 mb-0">{{ trans_choice('vote::messages.votes', $userVotes) }}</p>
            @endauth
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
            window.username  = '{{ $user->name }}';
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
