@extends('admin.layouts.admin')

@section('title', trans('hunt::admin.rewards.title'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('hunt.admin.rewards.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ trans('hunt::admin.rewards.create') }}
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
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
                <div class="col-md-2">
                    <label for="status" class="form-label">{{ trans('hunt::admin.common.status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ trans('hunt::admin.common.all') }}</option>
                        <option value="enabled" {{ $status === 'enabled' ? 'selected' : '' }}>{{ trans('hunt::admin.rewards.enabled') }}</option>
                        <option value="disabled" {{ $status === 'disabled' ? 'selected' : '' }}>{{ trans('hunt::admin.rewards.disabled') }}</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> {{ trans('hunt::admin.buttons.filter') }}
                    </button>
                    <a href="{{ route('hunt.admin.rewards.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> {{ trans('hunt::admin.buttons.reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($rewards->isNotEmpty())
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="bulkToggleRewards('enable')">
                            <i class="bi bi-check-circle"></i> {{ trans('hunt::admin.common.enable_selected') }}
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkToggleRewards('disable')">
                            <i class="bi bi-x-circle"></i> {{ trans('hunt::admin.common.disable_selected') }}
                        </button>
                    </div>
                    <div>
                        <small class="text-muted">{{ $rewards->total() }} {{ trans('hunt::admin.rewards.title') }}</small>
                    </div>
                </div>

                <form id="bulk-form" method="POST" action="{{ route('hunt.admin.rewards.bulkToggle') }}">
                    @csrf
                    <input type="hidden" name="action" id="bulk-action">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="select-all">
                                    </th>
                                    <th>{{ trans('hunt::admin.common.name') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.hunts.title') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.rewards.fields.chance_percentage') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.rewards.fields.money') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.rewards.fields.commands') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.rewards.fields.roles') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.common.status') }}</th>
                                    <th class="text-center">{{ trans('hunt::admin.rewards.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rewards as $reward)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input reward-checkbox" name="rewards[]" value="{{ $reward->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($reward->hasImage())
                                                    <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" class="rounded me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $reward->name }}</div>
                                                    <small class="text-muted">{{ trans('hunt::admin.common.created_at') }}: {{ $reward->created_at?->format('M d, Y') ?? trans('hunt::admin.common.unknown') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($reward->hunts->isNotEmpty())
                                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                                    @foreach($reward->hunts as $hunt)
                                                        <a href="{{ route('hunt.admin.hunts.edit', $hunt) }}" class="text-decoration-none">
                                                            <span class="badge bg-secondary">{{ $hunt->name }}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">{{ trans('hunt::admin.rewards.no_hunt') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $reward->chances }}%</span>
                                        </td>
                                        <td class="text-center">
                                            @if($reward->money && $reward->money > 0)
                                                <span class="badge bg-success">{{ $reward->money }} {{ money_name() }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($reward->commands && count($reward->commands) > 0)
                                                <span class="badge bg-primary">{{ count($reward->commands) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($reward->roles->isNotEmpty())
                                                <span class="badge bg-warning text-dark" title="{{ $reward->roles->pluck('name')->join(', ') }}">
                                                    {{ $reward->roles->count() }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">{{ trans('hunt::admin.common.all') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('hunt.admin.rewards.toggleEnabled', $reward) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm @if($reward->is_enabled) text-success @else text-secondary @endif" title="{{ $reward->is_enabled ? trans('hunt::admin.rewards.enabled') : trans('hunt::admin.rewards.disabled') }}">
                                                    <i class="bi @if($reward->is_enabled) bi-check-circle @else bi-x-circle @endif"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('hunt.admin.rewards.edit', $reward) }}" class="btn btn-outline-primary btn-sm" title="{{ trans('hunt::admin.buttons.edit') }}">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-secondary btn-sm" title="{{ trans('hunt::admin.common.clone') }}" onclick="cloneReward({{ $reward->id }})">
                                                    <i class="bi bi-files"></i>
                                                </button>
                                                <form method="POST" action="{{ route('hunt.admin.rewards.destroy', $reward) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="{{ trans('hunt::admin.buttons.delete') }}" onclick="return confirm('{{ trans('hunt::admin.rewards.confirm_delete') }}')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

                {{ $rewards->withQueryString()->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-gift" style="font-size: 4rem; color: #6c757d;"></i>
                    <h4 class="mt-3">{{ trans('hunt::admin.rewards.no_rewards') }}</h4>
                    <a href="{{ route('hunt.admin.rewards.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> {{ trans('hunt::admin.rewards.create') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="cloneModal" tabindex="-1" aria-labelledby="cloneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cloneModalLabel">{{ trans('hunt::admin.common.clone') }} {{ trans('hunt::admin.rewards.title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('hunt::admin.common.close') }}"></button>
                </div>
                <form id="clone-form" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="target_hunt_id" class="form-label">{{ trans('hunt::admin.rewards.fields.hunt') }}</label>
                            <select class="form-select" id="target_hunt_id" name="target_hunt_id" required>
                                <option value="">{{ trans('hunt::admin.common.select') }}...</option>
                                @foreach($hunts as $hunt)
                                    <option value="{{ $hunt->id }}">{{ $hunt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('hunt::admin.buttons.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('hunt::admin.common.clone') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.reward-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        function bulkToggleRewards(action) {
            const selectedRewards = document.querySelectorAll('.reward-checkbox:checked');
            if (selectedRewards.length === 0) {
                alert('{{ trans('hunt::admin.common.select_items') }}');
                return;
            }

            document.getElementById('bulk-action').value = action;
            document.getElementById('bulk-form').submit();
        }

        function cloneReward(rewardId) {
            const modal = new bootstrap.Modal(document.getElementById('cloneModal'));
            const form = document.getElementById('clone-form');
            form.action = `{{ route('hunt.admin.rewards.index') }}/${rewardId}/clone`;
            modal.show();
        }

        document.querySelectorAll('.reward-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allCheckboxes = document.querySelectorAll('.reward-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.reward-checkbox:checked');
                const selectAll = document.getElementById('select-all');

                if (checkedCheckboxes.length === allCheckboxes.length) {
                    selectAll.checked = true;
                    selectAll.indeterminate = false;
                } else if (checkedCheckboxes.length > 0) {
                    selectAll.checked = false;
                    selectAll.indeterminate = true;
                } else {
                    selectAll.checked = false;
                    selectAll.indeterminate = false;
                }
            });
        });
    </script>
@endsection
