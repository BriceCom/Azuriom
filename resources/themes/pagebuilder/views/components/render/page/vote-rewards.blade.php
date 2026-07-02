@if(request()->routeIs('vote.home'))
    @php
        $shouldDisplayRewards = (bool) ($displayRewards ?? false);
        $voteRewards = $rewards ?? [];
    @endphp

    @if($shouldDisplayRewards)
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">
                    {{ trans('vote::messages.sections.rewards') }}
                </h2>

                <table class="table mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">{{ trans('messages.fields.name') }}</th>
                        <th scope="col">{{ trans('vote::messages.fields.chances') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($voteRewards as $reward)
                        <tr>
                            <th scope="row">
                                @if($reward->image)
                                    <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" width="45">
                                @endif
                                {{ $reward->name }}
                            </th>
                            <td>{{ $reward->chances }} %</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endif
@else
    <div class="alert alert-warning mb-0">
        {{ trans('theme::pagebuilder.page_component_unavailable', ['component' => trans('theme::pagebuilder.page_vote_rewards')]) }}
    </div>
@endif
