@extends('admin.layouts.admin')

@section('title', trans('webhook-manager::admin.services.title'))

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <a href="{{ route('webhook-manager.admin.services.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ trans('webhook-manager::admin.services.create') }}
        </a>

        <a href="{{ route('webhook-manager.admin.webhooks.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-broadcast-pin"></i> {{ trans('webhook-manager::admin.nav.webhooks') }}
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($services->isEmpty())
                <div class="alert alert-info mb-0" role="alert">
                    <i class="bi bi-info-circle"></i> {{ trans('webhook-manager::admin.services.empty') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                        <tr>
                            <th>{{ trans('webhook-manager::admin.services.fields.name') }}</th>
                            <th>{{ trans('webhook-manager::admin.services.fields.type') }}</th>
                            <th>{{ trans('webhook-manager::admin.services.fields.url') }}</th>
                            <th>{{ trans('webhook-manager::admin.services.fields.bot_name') }}</th>
                            <th>{{ trans('webhook-manager::admin.services.fields.default_color') }}</th>
                            <th>{{ trans('webhook-manager::admin.services.webhooks_count') }}</th>
                            <th class="text-end">{{ trans('messages.fields.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td class="fw-semibold">{{ $service->name }}</td>
                                <td>{{ $types[$service->type] ?? $service->type }}</td>
                                <td class="small">{{ $service->url }}</td>
                                <td>{{ $service->bot_name ?? '-' }}</td>
                                <td>
                                    @if($service->default_color)
                                        <span class="badge" style="background-color: {{ $service->default_color }};">
                                            {{ $service->default_color }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $service->webhooks_count }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <a href="{{ route('webhook-manager.admin.services.edit', $service) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="{{ trans('messages.actions.edit') }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="{{ route('webhook-manager.admin.services.destroy', $service) }}"
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
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
