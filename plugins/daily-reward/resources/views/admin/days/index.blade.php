@extends('admin.layouts.admin')

@section('title', trans('daily-reward::admin.days.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ trans('daily-reward::admin.days.title') }}</h5>
            <a href="{{ route('daily-reward.admin.days.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>{{ trans('daily-reward::messages.fields.day') }}</th>
                        <th>{{ trans('daily-reward::messages.fields.label') }}</th>
                        <th>{{ trans('daily-reward::messages.fields.rewards') }}</th>
                        <th>{{ trans('messages.fields.status') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($days as $day)
                        <tr>
                            <td>{{ $day->day_number }}</td>
                            <td>{{ $day->label ?? trans('messages.none') }}</td>
                            <td>{{ $day->rewards_count }}</td>
                            <td>
                                @if($day->is_enabled)
                                    <span class="badge bg-success">{{ trans('messages.enabled') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ trans('messages.disabled') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('daily-reward.admin.days.edit', $day) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                <a href="{{ route('daily-reward.admin.days.destroy', $day) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted text-center py-3">{{ trans('messages.none') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $days->links() }}
    </div>
@endsection
