@if(request()->routeIs('vote.home'))
    @php
        $voteRows = $votes ?? [];
        $currentUserVotes = (int) ($userVotes ?? 0);
    @endphp

    <div class="card">
        <div class="card-body">
            <h2 class="card-title">
                {{ trans('vote::messages.sections.top') }}
            </h2>

            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                    <th scope="col">{{ trans('vote::messages.fields.votes') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($voteRows as $id => $vote)
                    <tr>
                        <th scope="row">#{{ $id }}</th>
                        <td>{{ $vote->user->name }}</td>
                        <td>{{ $vote->votes }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            @auth
                <p class="mt-3 mb-0">{{ trans_choice('vote::messages.votes', $currentUserVotes) }}</p>
            @endauth
        </div>
    </div>
@else
    <div class="alert alert-warning mb-0">
        {{ trans('theme::pagebuilder.page_component_unavailable', ['component' => trans('theme::pagebuilder.page_vote_top')]) }}
    </div>
@endif
