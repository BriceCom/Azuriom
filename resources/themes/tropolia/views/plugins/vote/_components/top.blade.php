<div class="card" data-aos="fade-up" data-aos-delay="0">
    <div class="card-body">
        <hgroup>
            <h2 class="card-title mb-2">
                {{ theme_config('vote.topTitle') ?? trans('vote::messages.sections.top') }}
            </h2>
            @if(theme_config('vote.topText'))
                <p class="col-lg-12 mb-0">{{ theme_config('vote.topText') }}</p>
            @endif
        </hgroup>

        <div class="table-responsive overflow-y-hidden">
            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col" style="width: 84px;">Top</th>
                    <th scope="col">{{ trans('theme::theme.player') }}</th>
                    @if(theme_config('vote.rewards.on'))
                        <th scope="col">{{ theme_config('vote.rewards.text') ?? 'Lorem' }}</th>
                    @endif
                    <th scope="col" class="text-end">{{ trans('vote::messages.fields.votes') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($votes as $id => $vote)
                    <tr class="{{ $loop->iteration <= 3 ? "vote-top__row":"" }}" style="--di-vote-rgb: {{ color_rgb(theme_config('vote.rewards.topColor.'.$id)??'#1E1E1E') }}">
                        <th scope="row">
                            <div class="position-relative d-flex align-items-center">
                                @if($loop->iteration <= 3)
                                    <i class="position-absolute  bi bi-trophy-fill text-2xl"
                                       style="color: {{theme_config('vote.rewards.topColor.'.$id) ? theme_config('vote.rewards.topColor.'.$id) : ''}}"
                                    ></i>
                                @else
                                    #{{ $id }}
                                @endif
                            </div>
                        </th>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img aria-hidden="true" class="rounded-1" src="{{$vote->user->getAvatar(24)}}" width="24" alt="{{$vote->user->name}}">
                                <span>{{ $vote->user->name }}</span>
                            </div>
                        </td>
                        @if(theme_config('vote.rewards.on'))
                            <td>
                                <span class="badge text-dark py-1.5 px-2.5 text-sm fw-normal" style="background-color: {{theme_config('vote.rewards.topColor.'.$id) ? theme_config('vote.rewards.topColor.'.$id) : ''}};">
                                    {{theme_config('vote.rewards.top.'.$id) ? theme_config('vote.rewards.top.'.$id) : ''}}
                                </span>
                            </td>
                        @endif
                        <td class="text-end">{{ $vote->votes }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
