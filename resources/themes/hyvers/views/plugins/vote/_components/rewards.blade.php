@if($displayRewards)
    <div class="card mt-4">
        <div class="card-body d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-4">
            <hgroup>
                <h2 class="card-title mb-2">
                    {{ theme_config('vote.rewardTitle') ?? trans('vote::messages.sections.rewards') }}
                </h2>
                @if(theme_config('vote.rewardText'))
                    <p class="col-lg-12 mb-0">{{ theme_config('vote.rewardText') }}</p>
                @endif
            </hgroup>

            <div class="d-flex flex-column gap-2">
                @foreach($rewards as $reward)
                    <div class="d-flex align-items-center gap-2 py-2 px-2 rounded bg-light">
                        @if($reward->image)
                            <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" width="32">
                        @endif
                        <p class="text-xl mb-0 ff-main text-uppercase">{{ $reward->name }}</p>
{{--                        <small class="vote-reward__badge badge text-xs" style="--}}
{{--                            background-color: {{ round($reward->chances) >= 50 ? "var(--di-quaternary)":"var(--di-tertiary)" }}--}}
{{--                        ">{{ round($reward->chances) }} %</small>--}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
