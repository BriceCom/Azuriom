@extends('admin.layouts.admin')

@section('title', trans('hunt::admin.logs.title'))

@section('content')
    @if(isset($stats))
        <div class="row mb-4">
            @include('hunt::admin.components._stats_card', [
                'title' => trans('hunt::admin.logs.stats.total_claims'),
                'icon' => 'bi bi-list-ul',
                'value' => $stats['total_logs'] ?? 0
            ])

            @include('hunt::admin.components._stats_card', [
                'title' => trans('hunt::admin.logs.stats.total_money'),
                'icon' => 'bi bi-currency-dollar',
                'value' => number_format($stats['total_money'] ?? 0, 2) . ' ' . money_name()
            ])

            @include('hunt::admin.components._stats_card', [
                'title' => trans('hunt::admin.logs.stats.unique_players'),
                'icon' => 'bi bi-people',
                'value' => $stats['unique_users'] ?? 0
            ])

            @include('hunt::admin.components._stats_card', [
                'title' => trans('hunt::admin.hunts.title'),
                'icon' => 'bi bi-gift',
                'value' => $stats['unique_hunts'] ?? 0
            ])
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-funnel"></i> {{ trans('hunt::admin.buttons.filter') }}
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">{{ trans('hunt::admin.common.search') }}</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="{{ trans('hunt::admin.logs.search_placeholder') }}">
                </div>
                <div class="col-md-4">
                    <label for="hunt_id" class="form-label">{{ trans('hunt::admin.logs.filter_hunt') }}</label>
                    <select class="form-select" id="hunt_id" name="hunt_id">
                        <option value="">{{ trans('hunt::admin.logs.all_hunts') }}</option>
                        @foreach($hunts as $hunt)
                            <option value="{{ $hunt->id }}" {{ $hunt_id == $hunt->id ? 'selected' : '' }}>{{ $hunt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="user_id" class="form-label">{{ trans('hunt::admin.logs.user') }}</label>
                    <select class="form-select" id="user_id" name="user_id">
                        <option value="">{{ trans('hunt::admin.common.all') }}</option>
                        @foreach($recentUsers as $user)
                            <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="date_from" class="form-label">{{ trans('hunt::admin.common.date_from') }}</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $date_from }}">
                </div>
                <div class="col-md-6">
                    <label for="date_to" class="form-label">{{ trans('hunt::admin.common.date_to') }}</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $date_to }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> {{ trans('hunt::admin.buttons.filter') }}
                    </button>
                    <a href="{{ route('hunt.admin.logs.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> {{ trans('hunt::admin.buttons.reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($logs->isNotEmpty())
                <div class="mb-3">
                    <small class="text-muted">{{ $logs->total() }} {{ trans('hunt::admin.logs.title') }}</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('hunt::admin.logs.user') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.logs.hunt') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.logs.reward') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.logs.money_earned') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.logs.commands_executed') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.logs.session_id') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.logs.claimed_at') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $log->user->getAvatar() }}" alt="{{ $log->user->name }}" class="rounded-circle me-2" width="24" height="24">
                                            <div>
                                                <div class="fw-bold">{{ $log->user->name }}</div>
                                                <small class="text-muted">ID: {{ $log->user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('hunt.admin.hunts.edit', $log->hunt) }}" class="text-decoration-none">
                                            <span class="badge bg-secondary">{{ $log->hunt->name }}</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if($log->reward)
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="badge bg-success">{{ $log->reward->name }}</span>
                                                <small class="text-muted">{{ $log->reward->chances }}%</small>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">{{ trans('hunt::admin.logs.no_reward') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($log->money_received > 0)
                                            <span class="badge bg-success">{{ $log->money_received }} {{ money_name() }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($log->commands_executed && count($log->commands_executed) > 0)
                                            <span class="badge bg-primary" title="{{ implode(', ', $log->commands_executed) }}">
                                                {{ count($log->commands_executed) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($log->session_id)
                                            <code class="small">{{ $log->session_id }}</code>
                                            <button type="button" class="btn btn-sm" onclick="copyToClipboard('{{ $log->session_id }}')" title="{{ trans('hunt::admin.common.copy') }}">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span>{{ $log->created_at->format('M d, Y') }}</span>
                                            <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('hunt.admin.logs.show', $log) }}" class="btn btn-outline-info btn-sm" title="{{ trans('hunt::admin.dashboard.view_all') }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($log->reward)
                                                <a href="{{ route('hunt.admin.rewards.edit', $log->reward) }}" class="btn btn-outline-primary btn-sm" title="{{ trans('hunt::admin.buttons.edit') }} {{ trans('hunt::admin.rewards.title') }}">
                                                    <i class="bi bi-gift"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $logs->withQueryString()->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-list-ul" style="font-size: 4rem; color: #6c757d;"></i>
                    <h4 class="mt-3">{{ trans('hunt::admin.logs.no_logs') }}</h4>
                    <p class="text-muted mb-4">{{ trans('hunt::admin.dashboard.no_recent_claims') }}</p>
                    <a href="{{ route('hunt.admin.hunts.index') }}" class="btn btn-primary">
                        <i class="bi bi-gift"></i> {{ trans('hunt::admin.hunts.title') }}
                    </a>
                </div>
            @endif
        </div>
    </div>


    <div class="modal fade" id="statisticsModal" tabindex="-1" aria-labelledby="statisticsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statisticsModalLabel">{{ trans('hunt::admin.logs.stats.title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('hunt::admin.common.close') }}"></button>
                </div>
                <div class="modal-body">
                    <div id="statistics-content">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('hunt::admin.common.close') }}</button>
                </div>
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

        function loadStatistics(period = 7) {
            fetch(`{{ route('hunt.admin.logs.statistics') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    const content = document.getElementById('statistics-content');
                    content.innerHTML = `
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-primary">${data.stats.total_claims}</h4>
                                    <small>{{ trans('hunt::admin.logs.stats.total_claims') }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-success">${data.stats.total_money.toFixed(2)} {{ money_name() }}</h4>
                                    <small>{{ trans('hunt::admin.logs.stats.total_money') }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-info">${data.stats.unique_users}</h4>
                                    <small>{{ trans('hunt::admin.logs.stats.unique_players') }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-warning">${data.stats.active_hunts}</h4>
                                    <small>Active {{ trans('hunt::admin.hunts.title') }}</small>
                                </div>
                            </div>
                        </div>
                        <h6>{{ trans('hunt::admin.dashboard.top_hunters') }}</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ trans('hunt::admin.common.player') }}</th>
                                        <th class="text-center">{{ trans('hunt::admin.common.total_claims') }}</th>
                                        <th class="text-center">{{ trans('hunt::admin.common.money_earned') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.top_users.map(user => `
                                        <tr>
                                            <td>${user.user.name}</td>
                                            <td class="text-center">${user.claims}</td>
                                            <td class="text-center">${user.money.toFixed(2)} {{ money_name() }}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;

                    const modal = new bootstrap.Modal(document.getElementById('statisticsModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error loading statistics:', error);
                    alert('{{ trans('messages.error_occurred') }}');
                });
        }

        document.getElementById('date_from').addEventListener('change', function() {
            const dateFrom = this.value;
            const dateTo = document.getElementById('date_to');

            if (dateFrom && !dateTo.value) {
                dateTo.value = dateFrom;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('.d-flex.justify-content-between.align-items-center.mb-3');
            if (header && !document.querySelector('#statistics-btn')) {
                const btnGroup = header.querySelector('div');
                const statsBtn = document.createElement('button');
                statsBtn.id = 'statistics-btn';
                statsBtn.className = 'btn btn-outline-info me-2';
                statsBtn.innerHTML = '<i class="bi bi-graph-up"></i> {{ trans('hunt::admin.logs.stats.title') }}';
                statsBtn.onclick = () => loadStatistics();
                btnGroup.insertBefore(statsBtn, btnGroup.firstChild);
            }
        });
    </script>
@endsection
