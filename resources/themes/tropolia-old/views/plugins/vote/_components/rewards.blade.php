@if($displayRewards)
    <div class="card">
        <div class="card-body gap-4.5">
            <hgroup>
                <h2 class="card-title mb-2">
                    {{ theme_config('vote.rewardTitle') ?? trans('vote::messages.sections.rewards') }}
                </h2>
                @if(theme_config('vote.rewardText'))
                    <p class="col-lg-12 mb-0">{{ theme_config('vote.rewardText') }}</p>
                @endif
            </hgroup>

            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                    <th scope="col">{{ trans('vote::messages.fields.chances') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($rewards as $reward)
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
