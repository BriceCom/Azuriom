@extends('admin.layouts.admin')

@section('title', trans('daily-reward::admin.claims.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ trans('daily-reward::admin.claims.title') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('daily-reward.admin.claims.index') }}" method="GET" class="row gx-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="{{ trans('daily-reward::admin.claims.search_placeholder') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> {{ trans('messages.actions.search') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>{{ trans('messages.fields.user') }}</th>
                        <th>{{ trans('daily-reward::messages.fields.day') }}</th>
                        <th>{{ trans('daily-reward::messages.fields.streak') }}</th>
                        <th>{{ trans('daily-reward::admin.claims.fields.rewards') }}</th>
                        <th>{{ trans('messages.fields.date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($claims as $claim)
                        <tr>
                            <td>{{ $claim->user->name ?? trans('messages.unknown') }}</td>
                            <td>#{{ $claim->day_number }}</td>
                            <td>{{ $claim->streak_before }} -> {{ $claim->streak_after }}</td>
                            <td>{{ count($claim->rewards_snapshot['rewards'] ?? []) }}</td>
                            <td>{{ format_date_compact($claim->claimed_at) }}</td>
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

        {{ $claims->withQueryString()->links() }}
    </div>
@endsection
