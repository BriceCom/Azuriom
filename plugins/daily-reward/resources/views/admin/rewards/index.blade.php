@extends('admin.layouts.admin')

@section('title', trans('daily-reward::admin.rewards.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ trans('daily-reward::admin.rewards.title') }}</h5>
            <a href="{{ route('daily-reward.admin.rewards.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>{{ trans('messages.fields.name') }}</th>
                        <th>{{ trans('daily-reward::messages.fields.day') }}</th>
                        <th>{{ trans('messages.fields.type') }}</th>
                        <th>{{ trans('messages.fields.status') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($rewards as $reward)
                        <tr>
                            <td>{{ $reward->name }}</td>
                            <td>#{{ $reward->day?->day_number ?? '-' }}</td>
                            <td>
                                @if($reward->type === \Azuriom\Plugin\DailyReward\Models\DailyRewardReward::TYPE_MONEY)
                                    {{ trans('daily-reward::admin.rewards.types.money') }}
                                @else
                                    {{ trans('daily-reward::admin.rewards.types.command') }}
                                @endif
                            </td>
                            <td>
                                @if($reward->is_enabled)
                                    <span class="badge bg-success">{{ trans('messages.enabled') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ trans('messages.disabled') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('daily-reward.admin.rewards.edit', $reward) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                <a href="{{ route('daily-reward.admin.rewards.destroy', $reward) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
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

        {{ $rewards->links() }}
    </div>
@endsection
