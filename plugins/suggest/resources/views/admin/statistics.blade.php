@extends('admin.layouts.admin')

@section('title', trans('suggest::admin.statistics.title'))

@section('content')
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('suggest::admin.statistics.total_suggestions') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-lightbulb"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalSuggestions) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-warning bg-opacity-10 border border-warning">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('suggest::admin.statistics.pending') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat bg-warning bg-opacity-10 text-warning h3">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($pendingSuggestions) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-success bg-opacity-10 border border-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('suggest::admin.statistics.accepted') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat bg-success bg-opacity-10 text-success h3">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($acceptedSuggestions) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card bg-danger bg-opacity-10 border border-danger">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('suggest::admin.statistics.refused') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat bg-danger bg-opacity-10 text-danger h3">
                                <i class="bi bi-x-circle"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($refusedSuggestions) }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('suggest::admin.statistics.total_votes') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-envelope-paper"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalVotes) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('suggest::admin.statistics.upvotes') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-hand-thumbs-up"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalUpvotes) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('suggest::admin.statistics.downvotes') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-hand-thumbs-down"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalDownvotes) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('suggest::admin.statistics.comments') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-chat-left-text"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ number_format($totalComments) }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Charts Row -->
        <div class="row col-md-6">
            <!-- Monthly Activity Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ trans('suggest::admin.statistics.monthly_activity') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity and Top Categories -->
        <div class="col-md-6">
            <div class="row g-3">
                <!-- Recent Activity -->
                <div>
                    <div class="card shadow mb-0">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ trans('suggest::admin.statistics.recent_activity') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 font-weight-bold text-primary">{{ number_format($recentSuggestions) }}</div>
                                        <div class="text-xs text-uppercase">{{ trans('suggest::admin.statistics.new_suggestions') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h4 font-weight-bold text-info">{{ number_format($recentVotes) }}</div>
                                        <div class="text-xs text-uppercase">{{ trans('suggest::admin.statistics.new_votes') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Categories -->
                <div>
                    <div class="card shadow m-0">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ trans('suggest::admin.statistics.top_categories') }}</h6>
                        </div>
                        <div class="card-body">
                            @forelse($topCategories as $category)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $category->name }}</span>
                                    <span class="badge badge-primary">{{ $category->suggestions_count }}</span>
                                </div>
                            @empty
                                <p class="text-muted">{{ trans('suggest::admin.statistics.no_categories') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Most Voted Suggestions -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('suggest::admin.statistics.most_voted_suggestions') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('suggest::admin.statistics.table_title') }}</th>
                        <th>{{ trans('suggest::admin.statistics.author') }}</th>
                        <th>{{ trans('suggest::admin.statistics.category') }}</th>
                        <th>{{ trans('suggest::admin.statistics.status') }}</th>
                        <th>{{ trans('suggest::admin.statistics.upvotes') }}</th>
                        <th>{{ trans('suggest::admin.statistics.downvotes') }}</th>
                        <th>{{ trans('suggest::admin.statistics.net_score') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($mostVotedSuggestions as $suggestion)
                        <tr>
                            <td>{{ Str::limit($suggestion->title, 50) }}</td>
                            <td>{{ $suggestion->user->name }}</td>
                            <td>{{ $suggestion->category->name ?? trans('suggest::admin.statistics.none') }}</td>
                            <td>
                                 <span
                                     class="badge bg-{{ $suggestion->status === 'approved' ? 'success' : ($suggestion->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ trans('suggest::messages.status.' . $suggestion->status) }}
                                </span>
                            </td>
                            <td class="text-success">{{ $suggestion->upvotes_count }}</td>
                            <td class="text-danger">{{ $suggestion->downvotes_count }}</td>
                            <td class="font-weight-bold">{{ $suggestion->upvotes_count - $suggestion->downvotes_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">{{ trans('suggest::admin.statistics.no_suggestions') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
        </div>
    </div>
@endsection

@push('footer-scripts')
        <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
        <script src="{{ asset('admin/js/charts.js') }}"></script>
        <script>
            createMultiLineChart('monthlyChart', [
                {
                    label: '{{ trans('suggest::admin.statistics.total_suggestions') }}',
                    data: @json($monthlyStats),
                },
                {
                    label: '{{ trans('suggest::admin.statistics.total_votes') }}',
                    data: @json($monthlyUpVotes),

                },
                {
                    label: '{{ trans('suggest::admin.statistics.upvotes') }}',
                    data: @json($monthlyVotes),

                },
                {
                    label: '{{ trans('suggest::admin.statistics.downvotes') }}',
                    data: @json($monthlyDownVotes),
                },
            ]);
        </script>
@endpush
