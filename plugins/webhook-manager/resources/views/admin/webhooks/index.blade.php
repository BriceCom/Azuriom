@extends('admin.layouts.admin')

@section('title', trans('webhook-manager::admin.webhooks.title'))

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('webhook-manager.admin.services.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-plug"></i> {{ trans('webhook-manager::admin.nav.services') }}
            </a>

            <a href="{{ route('webhook-manager.admin.webhooks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ trans('webhook-manager::admin.webhooks.create') }}
            </a>
        </div>

        <a href="{{ route('webhook-manager.admin.logs.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-clock-history"></i> {{ trans('webhook-manager::admin.nav.logs') }}
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($webhooks->isEmpty())
                <div class="alert alert-info mb-0" role="alert">
                    <i class="bi bi-info-circle"></i> {{ trans('webhook-manager::admin.webhooks.empty') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                        <tr>
                            <th>{{ trans('webhook-manager::admin.webhooks.fields.name') }}</th>
                            <th>{{ trans('webhook-manager::admin.webhooks.fields.service') }}</th>
                            <th>{{ trans('webhook-manager::admin.webhooks.fields.event') }}</th>
                            <th>{{ trans('webhook-manager::admin.webhooks.last_status') }}</th>
                            <th>{{ trans('webhook-manager::admin.webhooks.fields.timeout') }}</th>
                            <th>{{ trans('webhook-manager::admin.webhooks.fields.status') }}</th>
                            <th class="text-end">{{ trans('messages.fields.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($webhooks as $webhook)
                            @php($latestLog = $webhook->latestLog)
                            @php($status = $latestLog?->response_status)
                            <tr>
                                <td class="fw-semibold">{{ $webhook->name }}</td>
                                <td>{{ $webhook->service?->name ?? 'N/A' }}</td>
                                <td>{{ $events[$webhook->event]['label'] ?? $webhook->event }}</td>
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
                                <td>{{ $webhook->timeout }}s</td>
                                <td>
                                    @if($webhook->is_active)
                                        <span class="badge text-bg-success">{{ trans('webhook-manager::admin.webhooks.statuses.active') }}</span>
                                    @else
                                        <span class="badge text-bg-secondary">{{ trans('webhook-manager::admin.webhooks.statuses.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <form action="{{ route('webhook-manager.admin.webhooks.test', $webhook) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="{{ trans('webhook-manager::admin.webhooks.test') }}">
                                                <i class="bi bi-send"></i>
                                            </button>
                                        </form>

                                        <a href="{{ route('webhook-manager.admin.webhooks.edit', $webhook) }}" class="btn btn-sm btn-outline-primary" title="{{ trans('messages.actions.edit') }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="{{ route('webhook-manager.admin.webhooks.destroy', $webhook) }}"
                                           class="btn btn-sm btn-outline-danger"
                                           data-confirm="delete"
                                           title="{{ trans('messages.actions.delete') }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $webhooks->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
