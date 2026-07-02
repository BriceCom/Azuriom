<div class="card">
    <div class="card-body">
        <h2 class="card-title">
            {{ trans('hunt::messages.leaderboard') }}
        </h2>

        @if($leaderboard->isNotEmpty())
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('hunt::messages.player') }}</th>
                        <th scope="col">{{ trans('hunt::messages.total_claims') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leaderboard as $index => $entry)
                        <tr>
                            <th scope="row">
                                #{{ $index + 1 }}
                            </th>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <img src="{{ $entry->user->getAvatar(32) }}" alt="{{ $entry->user->name  }}"
                                         style="width: 32px; height: 32px;">
                                    {{ $entry->user->name  }}
                                </div>
                            </td>
                            <td>{{ $entry->claims_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @auth
                @if($userStats)
                    <p class="mt-3 mb-0">
                        {{ trans('hunt::messages.your_position', ['position' => 0]) }}
                    </p>
                @endif
            @endauth
        @else
            <div class="text-center py-5">
                <i class="bi bi-gift" style="font-size: 3rem; color: #6c757d;"></i>
                <h5 class="mt-3">{{ trans('hunt::messages.no_claims_yet') }}</h5>
                <p class="text-muted">{{ trans('hunt::messages.be_the_first') }}</p>
            </div>
        @endif
    </div>
</div>
