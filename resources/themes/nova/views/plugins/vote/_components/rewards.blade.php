@if($displayRewards)
    <div class="col-lg-6">
        <div class="card" data-aos="fade-up" data-aos-delay="0">
            <div class="card-body gap-4.5">
                <hgroup class="mb-3">
                    <h2 class="card-title mb-2">
                        {{ theme_config('vote.index.rewardTitle') ?? trans('vote::messages.sections.rewards') }}
                    </h2>
                    @if(theme_config('vote.index.rewardText'))
                        <p class="mb-0 opacity-75">{{ theme_config('vote.index.rewardText') }}</p>
                    @endif
                </hgroup>

                <div class="row gx-3 gy-3">
                    @foreach($rewards as $reward)
                        <div class="col-xl-6">
                           <div class="d-flex align-items-center gap-3 rounded-3 p-3 bg-body">
                               @if($reward->image)
                                   <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" width="45">
                               @endif

                               <div>
                                   <p class="mb-0">
                                       {{ $reward->name }}
                                   </p>
                                   <span class="badge border {{$reward->chances >= 50 ? 'text-bg-success text-success' : 'text-bg-warning text-warning'}} text-xs py-1.5 px-1.5" style="--di-badge-color: {{ $reward->chances >= 50 ? 'var(--di-success)' : 'var(--di-warning)' }}">
                                    {{ $reward->chances }}% {{trans('vote::messages.fields.chances')}}
                                </span>
                               </div>
                           </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
