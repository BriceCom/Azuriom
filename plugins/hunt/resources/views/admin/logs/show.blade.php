@extends('admin.layouts.admin')

@section('title', trans('hunt::admin.common.log_details') . ' #' . $log->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('hunt.admin.logs.index', ['hunt_id' => $log->hunt_id]) }}"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> {{ trans('hunt::admin.buttons.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i> {{ trans('hunt::admin.common.claim_details') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6>{{ trans('hunt::admin.logs.user') }}</h6>
                            <div class="d-flex align-items-center">
                                <img src="{{ $log->user->getAvatar() }}" alt="{{ $log->user->name }}"
                                     class="rounded-circle me-3" width="48" height="48">
                                <div>
                                    <div class="fw-bold">{{ $log->user->name }}</div>
                                    <small class="text-muted">ID: {{ $log->user->id }}</small>
                                    <div>
                                        <a href="{{ route('admin.users.edit', $log->user) }}"
                                           class="btn btn-outline-primary btn-sm mt-1">
                                            <i class="bi bi-person"></i> {{ trans('hunt::admin.common.view_profile') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6>{{ trans('hunt::admin.logs.hunt') }}</h6>
                            <div class="d-flex align-items-center">
                                @if($log->hunt->hasImage())
                                    <img src="{{ $log->hunt->imageUrl() }}" alt="{{ $log->hunt->name }}"
                                         class="rounded me-3" style="width: 48px; height: 48px; object-fit: cover;">
                                @endif
                                <div>
                                    <div class="fw-bold">{{ $log->hunt->name }}</div>
                                    <small class="text-muted">{{ trans('hunt::admin.hunts.fields.priority') }}
                                        : {{ $log->hunt->priority }}</small>
                                    <div>
                                        <a href="{{ route('hunt.admin.hunts.edit', $log->hunt) }}"
                                           class="btn btn-outline-secondary btn-sm mt-1">
                                            <i class="bi bi-gift"></i> {{ trans('hunt::admin.common.view_hunt') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6>{{ trans('hunt::admin.logs.reward') }}</h6>
                        @if($log->reward)
                            <div class="border rounded p-3">
                                <div class="fw-bold">{{ $log->reward->name }}</div>
                                <small class="text-muted">{{ trans('hunt::admin.rewards.fields.chance_percentage') }}
                                    : {{ $log->reward->chances }}%</small>
                                <div class="mt-2">
                                    <a href="{{ route('hunt.admin.rewards.edit', $log->reward) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-gift"></i> {{ trans('hunt::admin.common.view_reward') }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="border rounded p-3 text-center">
                                <i class="bi bi-x-circle text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0 mt-2">{{ trans('hunt::admin.logs.no_reward') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-12 mb-3">
                        <h6>{{ trans('hunt::admin.logs.money_earned') }}</h6>
                        <div class="border rounded p-3 text-center">
                            @if($log->money_received > 0)
                                <div
                                    class="display-6 text-success">{{ number_format($log->money_received, 2) }} {{ money_name() }}</div>
                            @else
                                <i class="bi bi-dash-circle text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0 mt-2">{{ trans('hunt::admin.common.no_money_reward') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <h6>{{ trans('hunt::admin.logs.commands_executed') }}</h6>
                        @if($log->commands_executed && count($log->commands_executed) > 0)
                            <div class="border rounded p-3">
                                @foreach($log->commands_executed as $index => $command)
                                    <div
                                        class="d-flex align-items-center mb-2 @if($index < count($log->commands_executed) - 1) border-bottom pb-2 @endif">
                                        <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                        <code class="flex-grow-1">{{ $command }}</code>
                                        <button type="button" class="btn btn-outline-secondary btn-sm ms-2"
                                                onclick="copyToClipboard('{{ $command }}')"
                                                title="{{ trans('hunt::admin.common.copy') }}">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border rounded p-3 text-center">
                                <i class="bi bi-terminal text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0 mt-2">{{ trans('hunt::admin.common.no_commands_executed') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <h6>{{ trans('hunt::admin.common.technical_information') }}</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted">{{ trans('hunt::admin.logs.session_id') }}</h6>
                                    @if($log->session_id)
                                        <code>{{ $log->session_id }}</code>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                                    onclick="copyToClipboard('{{ $log->session_id }}')"
                                                    title="{{ trans('hunt::admin.common.copy') }}">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted">{{ trans('hunt::admin.logs.claimed_at') }}</h6>
                                    <div>{{ $log->created_at->format('M d, Y') }}</div>
                                    <div class="fw-bold">{{ $log->created_at->format('H:i:s') }}</div>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted">{{ trans('hunt::admin.common.log_id') }}</h6>
                                    <div class="fw-bold">#{{ $log->id }}</div>
                                    <small class="text-muted">{{ trans('hunt::admin.common.database_id') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($log->user_agent)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-browser-chrome"></i> {{ trans('hunt::admin.logs.user_agent') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <code class="d-block p-2 bg-light rounded">{{ $log->user_agent }}</code>
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="copyToClipboard('{{ $log->user_agent }}')"
                                    title="{{ trans('hunt::admin.common.copy') }}">
                                <i class="bi bi-clipboard"></i> {{ trans('hunt::admin.common.copy') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if($userHuntLogs->isNotEmpty())
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clock-history"></i> {{ trans('hunt::admin.common.recent_claims_by_user') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>{{ trans('hunt::admin.common.date') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.logs.reward') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.logs.money_earned') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.logs.commands_executed') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.common.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userHuntLogs as $userLog)
                                    <tr>
                                        <td>
                                            <div>{{ $userLog->created_at->format('M d, H:i') }}</div>
                                            <small
                                                class="text-muted">{{ $userLog->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if($userLog->reward)
                                                <span class="badge bg-success">{{ $userLog->reward->name }}</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary">{{ trans('hunt::admin.logs.no_reward') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($userLog->money_received > 0)
                                                <span
                                                    class="badge bg-success">{{ $userLog->money_received }} {{ money_name() }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($userLog->commands_executed && count($userLog->commands_executed) > 0)
                                                <span
                                                    class="badge bg-primary">{{ count($userLog->commands_executed) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('hunt.admin.logs.show', $userLog) }}"
                                               class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col">
            <div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-check"></i> {{ trans('hunt::admin.common.user_hunt_stats') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h5 class="text-primary mb-1">{{ $userStats['total_claims'] ?? 0 }}</h5>
                                    <small class="text-muted">{{ trans('hunt::admin.hunts.total_claims') }}</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h5 class="text-success mb-1">{{ number_format($userStats['total_money'] ?? 0, 2) }} {{ money_name() }}</h5>
                                    <small class="text-muted">{{ trans('hunt::messages.total_earned') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <h5 class="text-info mb-1">{{ $userStats['today_claims'] ?? 0 }}</h5>
                                    <small class="text-muted">{{ trans('hunt::admin.logs.stats.today') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <h5 class="text-warning mb-1">{{ number_format($userStats['today_money'] ?? 0, 2) }} {{ money_name() }}</h5>
                                    <small class="text-muted">{{ trans('hunt::messages.earned_today') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-lightning"></i> {{ trans('hunt::admin.common.actions') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.users.edit', $log->user) }}" class="btn btn-outline-primary">
                                <i class="bi bi-person"></i> {{ trans('hunt::admin.common.view_user') }}
                            </a>
                            <a href="{{ route('hunt.admin.hunts.edit', $log->hunt) }}"
                               class="btn btn-outline-secondary">
                                <i class="bi bi-gift"></i> {{ trans('hunt::admin.common.view_hunt') }}
                            </a>
                            @if($log->reward)
                                <a href="{{ route('hunt.admin.rewards.edit', $log->reward) }}"
                                   class="btn btn-outline-success">
                                    <i class="bi bi-gift"></i> {{ trans('hunt::admin.common.view_reward') }}
                                </a>
                            @endif
                            <a href="{{ route('hunt.admin.logs.index', ['hunt_id' => $log->hunt_id, 'user_id' => $log->user_id]) }}"
                               class="btn btn-outline-info">
                                <i class="bi bi-list-ul"></i> {{ trans('hunt::admin.common.user_hunt_logs') }}
                            </a>
                            <a href="{{ route('hunt.show', $log->hunt) }}" class="btn btn-outline-warning"
                               target="_blank">
                                <i class="bi bi-eye"></i> {{ trans('hunt::admin.common.view') }} {{ trans('hunt::admin.common.public') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @if($log->reward && $log->reward->servers->isNotEmpty())
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-server"></i> {{ trans('hunt::admin.common.reward_servers') }}
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($log->reward->servers as $server)
                        <div
                            class="d-flex justify-content-between align-items-center mb-2 @if(!$loop->last) border-bottom pb-2 @endif">
                            <div>
                                <div class="fw-bold">{{ $server->name }}</div>
                                <small class="text-muted">{{ $server->type }}</small>
                            </div>
                            <span class="badge bg-info">{{ $server->type }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($log->reward && $log->reward->roles->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people"></i> {{ trans('hunt::admin.common.eligible_roles') }}
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($log->reward->roles as $role)
                        <div
                            class="d-flex justify-content-between align-items-center mb-2 @if(!$loop->last) border-bottom pb-2 @endif">
                            <div>{{ $role->name }}</div>
                            @if($role->color)
                                <span class="badge" style="background-color: {{ $role->color }};">&nbsp;</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    </div>
    </div>

    <script>
        function copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    alert('{{ trans('hunt::admin.common.copied_to_clipboard') }}');
                });
            } else {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('{{ trans('hunt::admin.common.copied_to_clipboard') }}');
            }
        }
    </script>
@endsection
