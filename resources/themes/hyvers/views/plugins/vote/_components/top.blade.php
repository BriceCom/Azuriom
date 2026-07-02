<div class="card mb-15">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between gap-3">
            <hgroup class="@if($goalEnabled) col-lg-7 @endif">
                <h2 class="card-title mb-2">
                    {{ theme_config('vote.topTitle') ?? trans('vote::messages.sections.top') }}
                </h2>
                @if(theme_config('vote.topText'))
                    <p class="mb-0">{{ theme_config('vote.topText') }}</p>
                @endif
            </hgroup>

            @include("plugins.vote._components.goal")
        </div>


        <div class="table-responsive">
            <table id="vote-top-table" class="table mb-0">
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
                                @if($loop->iteration <= 3)
                                    <i class="bi bi-trophy-fill text-lg"
                                       style="color: {{$loop->iteration === 1 ? "#F8D32E": ($loop->iteration === 2 ? "#D5D4D0":"#B57B3E")}}"
                                    ></i>
                                @else
                                    #{{ $id }}
                                @endif
                            </div>
                        </th>
                        <td>
                            <div class="text-nowrap">
                                <span>
                                <img aria-hidden="true" class="rounded-1" src="{{$vote->user->getAvatar(24)}}" width="24" alt="{{$vote->user->name}}">
                            </span>
                                <span class="ms-2">{{ $vote->user->name }}</span>
                            </div>
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
        </div>

        @include('vote::_components.user-position')
    </div>
</div>
