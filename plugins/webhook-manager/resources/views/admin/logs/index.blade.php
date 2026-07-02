@extends('admin.layouts.admin')

@section('title', trans('webhook-manager::admin.logs.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('webhook-manager.admin.logs.index') }}" class="row g-3 align-items-end mb-4">
                <div class="col-md-4">
                    <label class="form-label" for="webhookSelect">{{ trans('webhook-manager::admin.logs.filters.webhook') }}</label>
                    <select id="webhookSelect" class="form-select" name="webhook_id">
                        <option value="">{{ trans('webhook-manager::admin.logs.filters.all') }}</option>
                        @foreach($webhooks as $webhook)
                            <option value="{{ $webhook->id }}" @selected($selectedWebhookId === $webhook->id)>
                                {{ $webhook->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="eventSelect">{{ trans('webhook-manager::admin.logs.filters.event') }}</label>
                    <select id="eventSelect" class="form-select" name="event">
                        <option value="">{{ trans('webhook-manager::admin.logs.filters.all') }}</option>
                        @foreach($events as $event => $metadata)
                            <option value="{{ $event }}" @selected($selectedEvent === $event)>
                                {{ $metadata['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> {{ trans('messages.actions.search') }}
                    </button>
                    <a href="{{ route('webhook-manager.admin.logs.index') }}" class="btn btn-outline-secondary">
                        {{ trans('messages.actions.refresh') }}
                    </a>
                </div>
            </form>

            @if($logs->isEmpty())
                <div class="alert alert-info mb-0" role="alert">
                    <i class="bi bi-info-circle"></i> {{ trans('webhook-manager::admin.logs.empty') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                        <tr>
                            <th>{{ trans('webhook-manager::admin.logs.columns.sent_at') }}</th>
                            <th>{{ trans('webhook-manager::admin.logs.columns.webhook') }}</th>
                            <th>{{ trans('webhook-manager::admin.logs.columns.service') }}</th>
                            <th>{{ trans('webhook-manager::admin.logs.columns.event') }}</th>
                            <th>{{ trans('webhook-manager::admin.logs.columns.status') }}</th>
                            <th>{{ trans('webhook-manager::admin.logs.columns.payload') }}</th>
                            <th>{{ trans('webhook-manager::admin.logs.columns.headers') }}</th>
                            <th>{{ trans('webhook-manager::admin.logs.columns.response') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            @php($status = $log->response_status)
                            <tr>
                                <td>{{ $log->sent_at?->translatedFormat('Y-m-d H:i:s') }}</td>
                                <td>{{ $log->webhook?->name ?? 'N/A' }}</td>
                                <td>{{ $log->webhook?->service?->name ?? 'N/A' }}</td>
                                <td>{{ $events[$log->event]['label'] ?? $log->event }}</td>
                                <td>
                                    @if($status === null)
                                        <span class="badge text-bg-secondary">N/A</span>
                                    @elseif($status >= 200 && $status < 300)
                                        <span class="badge text-bg-success">{{ $status }}</span>
                                    @elseif($status === 0)
                                        <span class="badge text-bg-danger">ERROR</span>
                                    @else
                                        <span class="badge text-bg-danger">{{ $status }}</span>
                                    @endif
                                </td>
                                <td class="small">
                                    <details>
                                        <summary>{{ trans('webhook-manager::admin.logs.view') }}</summary>
                                        <pre class="mb-0">{{ json_encode($log->payload_sent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </details>
                                </td>
                                <td class="small">
                                    <details>
                                        <summary>{{ trans('webhook-manager::admin.logs.view') }}</summary>
                                        <pre class="mb-0">{{ json_encode($log->headers_sent ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </details>
                                </td>
                                <td class="small">
                                    <details>
                                        <summary>{{ trans('webhook-manager::admin.logs.view') }}</summary>
                                        <pre class="mb-0">{{ $log->response_body ?: '-' }}</pre>
                                    </details>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
