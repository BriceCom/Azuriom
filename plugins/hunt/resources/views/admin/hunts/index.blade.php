@extends('admin.layouts.admin')

@section('title', trans('hunt::admin.hunts.title'))

@push('footer-scripts')
    <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('admin/js/charts.js') }}"></script>
    @if(isset($claimsPerMonths) && isset($claimsPerDays))
        <script>
            createLineChart('claimsPerMonths', {!! $claimsPerMonths !!}, '{{ trans('hunt::admin.logs.stats.this_month') }}');
            createLineChart('claimsPerDays', {!! $claimsPerDays !!}, '{{ trans('hunt::admin.logs.stats.this_week') }}');
        </script>
    @endif
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('hunt.admin.hunts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ trans('hunt::admin.hunts.create') }}
        </a>
    </div>

    <div class="row mb-4">
        @include('hunt::admin.components._stats_card', [
            'title' => trans('hunt::admin.hunts.title'),
            'icon' => 'bi bi-gift',
            'value' => $huntsCount ?? 0
        ])

        @include('hunt::admin.components._stats_card', [
            'title' => trans('hunt::admin.hunts.active'),
            'icon' => 'bi bi-play-circle',
            'value' => $activeHuntsCount ?? 0
        ])

        @include('hunt::admin.components._stats_card', [
            'title' => trans('hunt::admin.hunts.total_claims'),
            'icon' => 'bi bi-cursor-fill',
            'value' => $totalClaims ?? 0
        ])

        @include('hunt::admin.components._stats_card', [
            'title' => trans('hunt::admin.logs.stats.today'),
            'icon' => 'bi bi-calendar-day',
            'value' => $totalClaimsDay ?? 0
        ])
    </div>

    @if($currentHunt)
        <div class="alert alert-success mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-gift-fill me-3" style="font-size: 1.5rem;"></i>
                <div class="flex-grow-1">
                    <h5 class="mb-1">{{ trans('hunt::admin.hunts.current') }}: {{ $currentHunt->name }}</h5>
                    <p class="mb-1">{{ $currentHunt->description }}</p>
                    <small class="text-muted">
                        {{ trans('hunt::admin.hunts.priority') }}: {{ $currentHunt->priority }} |
                        {{ trans('hunt::admin.hunts.total_claims') }}: {{ $currentHunt->logs()->count() }}
                        @if($currentHunt->global_cap)
                            / {{ $currentHunt->global_cap }}
                        @endif
                    </small>
                </div>
                <div>
                    <a href="{{ route('hunt.admin.hunts.edit', $currentHunt) }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="bi bi-pencil"></i> {{ trans('hunt::admin.buttons.edit') }}
                    </a>
                    <a href="{{ route('hunt.admin.hunts.show', $currentHunt) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-eye"></i> {{ trans('hunt::admin.common.view') }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-8">
                    <label for="search" class="form-label">{{ trans('hunt::admin.common.search') }}</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ is_array($search) ? '' : $search }}" placeholder="{{ trans('hunt::admin.logs.search_placeholder') }}">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">{{ trans('hunt::admin.common.status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ trans('hunt::admin.common.all') }}</option>
                        <option value="active" {{ $status === 'active' ? 'selected' : '' }}>{{ trans('hunt::admin.hunts.active') }}</option>
                        <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>{{ trans('hunt::admin.hunts.inactive') }}</option>
                        <option value="archived" {{ $status === 'archived' ? 'selected' : '' }}>{{ trans('hunt::admin.hunts.archived') }}</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> {{ trans('hunt::admin.buttons.filter') }}
                    </button>
                    <a href="{{ route('hunt.admin.hunts.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> {{ trans('hunt::admin.buttons.reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($hunts->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('hunt::admin.common.name') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.hunts.priority') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.common.status') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.hunts.total_claims') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.hunts.fields.max_per_day') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.common.date') }}</th>
                                <th class="text-center">{{ trans('hunt::admin.hunts.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hunts as $hunt)
                                <tr @if($hunt->id === $currentHunt?->id) class="table-active" @endif>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($hunt->hasImage())
                                                <img src="{{ $hunt->imageUrl() }}" alt="{{ $hunt->name }}" class="rounded me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $hunt->name }}</div>
                                                @if($hunt->description)
                                                    <small class="text-muted">{{ Str::limit($hunt->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $hunt->priority }}</span>
                                        @if($hunt->id === $currentHunt?->id)
                                            <br><small class="text-success">{{ trans('hunt::admin.hunts.current') }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($hunt->is_archived)
                                            <span class="badge bg-dark">{{ trans('hunt::admin.hunts.archived') }}</span>
                                        @elseif($hunt->is_active && $hunt->isCurrentlyActive())
                                            <span class="badge bg-success">{{ trans('hunt::admin.hunts.active') }}</span>
                                        @elseif($hunt->is_active && $hunt->end_date < now())
                                            <span class="badge bg-warning">{{ trans('hunt::admin.common.finalized') }}</span>
                                        @elseif($hunt->is_active)
                                            <span class="badge bg-info">{{ trans('hunt::admin.common.scheduled') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ trans('hunt::admin.hunts.inactive') }}</span>
                                        @endif

                                        @if($hunt->hasReachedGlobalCap())
                                            <br><span class="badge bg-warning text-dark">{{ trans('hunt::admin.hunts.cap_reached') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ $hunt->logs()->count() }}</strong>
                                        @if($hunt->global_cap)
                                            / {{ $hunt->global_cap }}
                                            <div class="progress mt-1" style="height: 4px;">
                                                @php
                                                    $percentage = min(100, ($hunt->logs()->count() / $hunt->global_cap) * 100);
                                                @endphp
                                                <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $hunt->max_per_day }}</td>
                                    <td class="text-center">
                                        <small>
                                            <div>{{ trans('hunt::admin.common.start') }}: {{ $hunt->start_date->format('M d, Y') }}</div>
                                            <div>{{ trans('hunt::admin.common.end') }}: {{ $hunt->end_date->format('M d, Y') }}</div>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('hunt.admin.hunts.edit', $hunt) }}" class="btn btn-outline-primary btn-sm" title="{{ trans('hunt::admin.buttons.edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('hunt.admin.hunts.show', $hunt) }}" class="btn btn-outline-info btn-sm" title="{{ trans('hunt::admin.dashboard.view_all') }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($hunt->is_archived)
                                                <form method="POST" action="{{ route('hunt.admin.hunts.restore', $hunt) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" title="{{ trans('hunt::admin.hunts.restore') }}">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('hunt.admin.hunts.archive', $hunt) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-warning btn-sm" title="{{ trans('hunt::admin.hunts.archive') }}" onclick="return confirm('{{ trans('hunt::admin.hunts.confirm_archive') }}')">
                                                        <i class="bi bi-archive"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('hunt.admin.hunts.destroy', $hunt) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="{{ trans('hunt::admin.buttons.delete') }}" onclick="return confirm('{{ trans('hunt::admin.hunts.confirm_delete') }}')">
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

                {{ $hunts->withQueryString()->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-gift" style="font-size: 4rem; color: #6c757d;"></i>
                    <h4 class="mt-3">{{ trans('hunt::admin.hunts.no_hunts') }}</h4>
                    <a href="{{ route('hunt.admin.hunts.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> {{ trans('hunt::admin.hunts.create') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if(isset($claimsPerMonths) && isset($claimsPerDays))
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ trans('hunt::admin.logs.stats.this_month') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="claimsPerMonths" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ trans('hunt::admin.logs.stats.this_week') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="claimsPerDays" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection
