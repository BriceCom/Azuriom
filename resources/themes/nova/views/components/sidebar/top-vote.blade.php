@if(!theme_config('sidebar.vote.off'))
    @if(plugins()->isEnabled('vote'))
        <div class="card">
            <div class="card-body">
                <h2 class="h3">{{ theme_config('sidebar.vote.title') ?? trans('theme::theme.top_voters')}}</h2>

                <ul class="list-unstyled d-flex flex-wrap gap-2">

                    @forelse(vote_leaderboard()->take(5) as $vote)
                        <li>
                            <img src="{{ $vote->user->getAvatar(64) }}"
                                 alt="{{$vote->user->name}}"
                                 class="rounded-1"
                                 width="38"
                                 height="38"
                                 title="{{$vote->user->name}}">
                        </li>
                    @empty
                        @for($i = 0; $i < 5; $i++)
                            <li>
                                <div class="bg-secondary bg-opacity-25 rounded-1" style="width: 38px; height: 38px"></div>
                            </li>
                        @endfor
                    @endforelse
                </ul>

                <a href="{{ route('vote.home') }}"
                   class="btn btn-primary">{{ trans('vote::messages.sections.vote')}}</a>
            </div>
        </div>
    @endif
@endif

