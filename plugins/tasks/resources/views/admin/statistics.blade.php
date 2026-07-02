@extends('admin.layouts.admin')

@section('title', trans('tasks::admin.statistics.title'))

@section('content')
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('tasks::admin.statistics.total_tasks') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-list-task"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalTasks) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-warning bg-opacity-10 border border-warning">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('tasks::admin.statistics.pending') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat bg-warning bg-opacity-10 text-warning h3">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($pendingTasks) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-info bg-opacity-10 border border-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('tasks::admin.statistics.in_progress') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat bg-info bg-opacity-10 text-info h3">
                                <i class="bi bi-gear"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($inProgressTasks) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-success bg-opacity-10 border border-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('tasks::admin.statistics.completed') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat bg-success bg-opacity-10 text-success h3">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($completedTasks) }}</h1>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Charts Row -->
        <div class="row col-xl-6">
            <!-- Monthly Activity Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.statistics.monthly_activity') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity and Top Tags -->
        <div class="col-xl-6">
            <div class="row g-3">
                <!-- Recent Activity -->
                <div>
                    <div class="card shadow mb-0">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.statistics.recent_activity') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 font-weight-bold text-primary">{{ number_format($recentTasks) }}</div>
                                        <div class="text-xs text-uppercase">{{ trans('tasks::admin.statistics.new_tasks') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 font-weight-bold text-success">{{ number_format($recentCompletedTasks) }}</div>
                                        <div class="text-xs text-uppercase">{{ trans('tasks::admin.statistics.completed_tasks') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Tags -->
                <div>
                    <div class="card shadow m-0">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.statistics.top_tags') }}</h6>
                        </div>
                        <div class="card-body">
                            @forelse($topTags as $tag)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>
                                        <span class="badge" style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                                    </span>
                                    <span class="badge bg-primary">{{ $tag->tasks_count }}</span>
                                </div>
                            @empty
                                <p class="text-muted">{{ trans('tasks::admin.statistics.no_tags') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks by Status -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.statistics.tasks_by_status') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('tasks::admin.statistics.status') }}</th>
                        <th>{{ trans('tasks::admin.statistics.color') }}</th>
                        <th>{{ trans('tasks::admin.statistics.task_count') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tasksByStatus as $status)
                        <tr>
                            <td>{{ $status->name }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $status->color }}">{{ $status->name }}</span>
                            </td>
                            <td>{{ $status->tasks_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">{{ trans('tasks::admin.statistics.no_statuses') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('footer-scripts')
    <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('admin/js/charts.js') }}"></script>
    <script>
        createMultiLineChart('monthlyChart', [
            {
                label: '{{ trans('tasks::admin.statistics.created_tasks') }}',
                data: @json($monthlyStats),
            },
            {
                label: '{{ trans('tasks::admin.statistics.completed_tasks') }}',
                data: @json($monthlyCompletedStats),
            },
        ]);
    </script>
@endpush
