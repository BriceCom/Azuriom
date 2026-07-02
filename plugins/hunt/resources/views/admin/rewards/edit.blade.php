@extends('admin.layouts.admin')

@section('title', trans('hunt::admin.rewards.edit', ['reward' => $reward->name]))

@section('content')
    <a href="{{ route('hunt.admin.rewards.index') }}" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left"></i> {{ trans('hunt::admin.buttons.back') }}
    </a>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('hunt.admin.rewards.update', $reward) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('hunt::admin.rewards._form')

                        <div class="col-md-12 mt-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-lg"></i> {{ trans('hunt::admin.buttons.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-graph-up"></i> {{ trans('hunt::admin.logs.stats.title') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2">
                                <h5 class="text-primary mb-1">{{ $reward->logs()->count() }}</h5>
                                <small class="text-muted">{{ trans('hunt::admin.hunts.total_claims') }}</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2">
                                <h5 class="text-success mb-1">{{ number_format($reward->logs()->sum('money_received'), 2) }} {{ money_name() }}</h5>
                                <small class="text-muted">{{ trans('hunt::messages.money_earned') }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <h5 class="text-info mb-1">{{ $reward->logs()->distinct('user_id')->count() }}</h5>
                                <small class="text-muted">{{ trans('hunt::admin.hunts.total_players') }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <h5 class="text-warning mb-1">{{ $reward->logs()->whereDate('created_at', today())->count() }}</h5>
                                <small class="text-muted">{{ trans('hunt::admin.logs.stats.today') }}</small>
                            </div>
                        </div>
                    </div>

                    @if($reward->logs()->count() > 0)
                        <div class="mt-3">
                            <small class="text-muted">{{ trans('hunt::admin.common.last_claimed') }}: {{ $reward->logs()->latest()->first()->created_at->diffForHumans() }}</small>
                        </div>
                    @endif
                </div>
            </div>

            @include('hunt::admin.rewards._sidebar')

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning"></i> {{ trans('hunt::admin.common.actions') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($reward->hunts->isNotEmpty())
                            @foreach($reward->hunts as $hunt)
                                <a href="{{ route('hunt.admin.hunts.edit', $hunt) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil"></i> {{ trans('hunt::admin.buttons.edit') }} {{ $hunt->name }}
                                </a>
                                <a href="{{ route('hunt.admin.logs.index', ['hunt_id' => $hunt->id, 'reward_id' => $reward->id]) }}" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-list-ul"></i> {{ trans('hunt::admin.logs.title') }} - {{ $hunt->name }}
                                </a>
                            @endforeach
                        @endif
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cloneReward()">
                            <i class="bi bi-files"></i> {{ trans('hunt::admin.common.clone') }}
                        </button>
                        <form method="POST" action="{{ route('hunt.admin.rewards.toggleEnabled', $reward) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm w-100 @if($reward->is_enabled) btn-outline-warning @else btn-outline-success @endif">
                                @if($reward->is_enabled)
                                    <i class="bi bi-x-circle"></i> {{ trans('hunt::admin.common.disabled') }}
                                @else
                                    <i class="bi bi-check-circle"></i> {{ trans('hunt::admin.common.enable') }}
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cloneModal" tabindex="-1" aria-labelledby="cloneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cloneModalLabel">{{ trans('hunt::admin.common.clone') }} {{ trans('hunt::admin.rewards.title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('hunt::admin.common.close') }}"></button>
                </div>
                <form id="clone-form" method="POST" action="{{ route('hunt.admin.rewards.clone', $reward) }}">
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
        function cloneReward() {
            const modal = new bootstrap.Modal(document.getElementById('cloneModal'));
            modal.show();
        }
    </script>
@endsection
