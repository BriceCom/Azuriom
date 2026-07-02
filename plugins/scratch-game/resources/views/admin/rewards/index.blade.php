@extends('admin.layouts.admin')

@section('title', trans('scratch-game::admin.rewards.title'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('scratch-game.admin.rewards.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ trans('scratch-game::admin.rewards.create') }}
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-8">
                    <label for="search" class="form-label">{{ trans('scratch-game::admin.common.search') }}</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="{{ trans('scratch-game::admin.rewards.search_placeholder') }}">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">{{ trans('scratch-game::admin.common.status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ trans('scratch-game::admin.common.all') }}</option>
                        <option value="enabled" @selected($status === 'enabled')>{{ trans('scratch-game::admin.common.enabled') }}</option>
                        <option value="disabled" @selected($status === 'disabled')>{{ trans('scratch-game::admin.common.disabled') }}</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> {{ trans('scratch-game::admin.buttons.filter') }}
                    </button>
                    <a href="{{ route('scratch-game.admin.rewards.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> {{ trans('scratch-game::admin.buttons.reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($rewards->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('scratch-game::admin.common.name') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.rewards.fields.chance') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.rewards.fields.money') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.rewards.fields.commands') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.rewards.fields.used_in_cards') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.common.status') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rewards as $reward)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($reward->hasImage())
                                                <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" class="rounded" style="width: 36px; height: 36px; object-fit: cover;">
                                            @endif
                                            <span class="fw-bold">{{ $reward->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ number_format((float) $reward->chance, 2) }}%</span>
                                    </td>
                                    <td class="text-center">
                                        @if($reward->money)
                                            <span class="badge bg-success">{{ number_format((float) $reward->money, 2) }} {{ money_name() }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php($commandsCount = is_array($reward->commands) ? count($reward->commands) : 0)
                                        @if($commandsCount > 0)
                                            <span class="badge bg-primary">{{ $commandsCount }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $reward->cards->count() }}</span>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('scratch-game.admin.rewards.toggleEnabled', $reward) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $reward->is_enabled ? 'text-success' : 'text-secondary' }}" title="{{ $reward->is_enabled ? trans('scratch-game::admin.common.enabled') : trans('scratch-game::admin.common.disabled') }}">
                                                <i class="bi {{ $reward->is_enabled ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('scratch-game.admin.rewards.edit', $reward) }}" class="btn btn-outline-primary btn-sm" title="{{ trans('scratch-game::admin.buttons.edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('scratch-game.admin.rewards.destroy', $reward) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="{{ trans('scratch-game::admin.buttons.delete') }}" onclick="return confirm('{{ trans('scratch-game::admin.rewards.confirm_delete') }}')">
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

                {{ $rewards->withQueryString()->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-gift" style="font-size: 4rem; color: #6c757d;"></i>
                    <h4 class="mt-3">{{ trans('scratch-game::admin.rewards.no_rewards') }}</h4>
                    <a href="{{ route('scratch-game.admin.rewards.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-lg"></i> {{ trans('scratch-game::admin.rewards.create') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
