@extends('admin.layouts.admin')

@section('title', trans('trackurl::admin.stats.title'))

@section('content')
    <div class="mb-3">
        <a href="{{ route('trackurl.admin.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> {{ trans('trackurl::admin.stats.back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ trans('trackurl::admin.stats.link_info') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>{{ trans('trackurl::admin.fields.name') }}:</strong> {{ $link->name }}</p>
                            <p><strong>{{ trans('trackurl::admin.fields.short_code') }}:</strong> {{ $link->short_code }}</p>
                            <p><strong>{{ trans('trackurl::admin.fields.urls') }}:</strong></p>
                            <div class="mb-3">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ trans('trackurl::messages.standard_url') }}</h6>
                                            <button type="button" class="btn btn-sm btn-outline-primary copy-btn"
                                                data-url="{{ route('trackurl.redirect', $link->short_code) }}">
                                                <i class="bi bi-clipboard"></i> {{ trans('trackurl::messages.copy') }}
                                            </button>
                                        </div>
                                        <p class="mb-1">
                                            <a href="{{ route('trackurl.redirect', $link->short_code) }}" target="_blank">
                                                {{ route('trackurl.redirect', $link->short_code) }}
                                            </a>
                                        </p>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ trans('trackurl::messages.pretty_url') }}</h6>
                                            <button type="button" class="btn btn-sm btn-outline-primary copy-btn"
                                                data-url="{{ url('/').'/?ref='.$link->short_code }}">
                                                <i class="bi bi-clipboard"></i> {{ trans('trackurl::messages.copy') }}
                                            </button>
                                        </div>
                                        <p class="mb-1">
                                            <a href="{{ url('/').'/?ref='.$link->short_code }}" target="_blank">
                                                {{ url('/').'/?ref='.$link->short_code }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p><strong>{{ trans('trackurl::admin.stats.created_by') }}:</strong> {{ $link->user->name }}</p>
                            <p><strong>{{ trans('trackurl::admin.stats.created_at') }}:</strong> {{ format_date($link->created_at) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>{{ trans('trackurl::admin.stats.status') }}:</strong>
                                @if($link->blocked)
                                    <span class="badge bg-danger">{{ trans('trackurl::admin.links.status.blocked') }}</span>
                                @else
                                    <span class="badge bg-success">{{ trans('trackurl::admin.links.status.active') }}</span>
                                @endif
                            </p>
                            <p><strong>{{ trans('trackurl::admin.fields.destination_url') }}:</strong>
                                <a href="{{ $link->destination_url }}" target="_blank">
                                    {{ $link->destination_url }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('trackurl::admin.stats.today') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $clicksToday}}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('trackurl::admin.stats.week') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-calendar-week"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $clicksThisWeek }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('trackurl::admin.stats.month') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-calendar-month"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $clicksThisMonth }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('trackurl::admin.stats.clicks') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-mouse2"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $totalClicks }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('trackurl::admin.stats.unique_visitors') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary h3">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $uniqueVisitors }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ trans('trackurl::admin.stats.daily_clicks') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="newClicksPerDaysChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ trans('trackurl::admin.stats.recent_clicks') }}</h6>
                </div>
                <div class="card-body">
                    @if($link->clicks->isEmpty())
                        <div class="alert alert-info" role="alert">
                            {{ trans('trackurl::admin.stats.no_clicks') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ trans('trackurl::admin.stats.session') }}</th>
                                    <th scope="col">{{ trans('trackurl::admin.stats.user_agent') }}</th>
                                    <th scope="col">{{ trans('trackurl::admin.stats.date') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($link->clicks->sortByDesc('created_at')->take(50) as $click)
                                    <tr>
                                        <th scope="row">{{ $click->id }}</th>
                                        <td>{{ $click->session_id }}</td>
                                        <td class="text-truncate" style="max-width: 300px;">{{ $click->user_agent }}</td>
                                        <td>{{ format_date($click->created_at, true) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')

    <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('admin/js/charts.js') }}"></script>
    <script>
        createLineChart('newClicksPerDaysChart', @json($dailyClicks), '{{ trans('trackurl::admin.stats.daily_clicks') }}');

        document.addEventListener('DOMContentLoaded', function() {
            // Get all copy buttons
            const copyButtons = document.querySelectorAll('.copy-btn');

            // Add click event listener to each button
            copyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the URL to copy
                    const url = this.getAttribute('data-url');

                    // Create a temporary input element
                    const tempInput = document.createElement('input');
                    tempInput.value = url;
                    document.body.appendChild(tempInput);

                    // Select and copy the text
                    tempInput.select();
                    document.execCommand('copy');

                    // Remove the temporary input
                    document.body.removeChild(tempInput);

                    // Change button text to show feedback
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-clipboard-check"></i> {{ trans('trackurl::messages.copied') }}';

                    // Reset button text after 2 seconds
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                    }, 2000);
                });
            });
        });
    </script>
@endpush
