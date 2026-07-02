@extends('admin.layouts.admin')

@section('title', trans('achievement::admin.objectives.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('messages.fields.name') }}</th>
                            <th scope="col">{{ trans('achievement::admin.objectives.fields.hook') }}</th>
                            <th scope="col">{{ trans('achievement::admin.objectives.fields.trigger') }}</th>
                            <th scope="col">{{ trans('achievement::admin.objectives.fields.amount') }}</th>
                            <th scope="col">{{ trans('achievement::admin.objectives.fields.visibility') }}</th>
                            <th scope="col">{{ trans('messages.fields.enabled') }}</th>
                            <th scope="col">{{ trans('messages.fields.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($objectives as $objective)
                            <tr>
                                <th scope="row">{{ $objective->id }}</th>
                                <td>{{ $objective->name }}</td>
                                <td>{{ $objective->hook }}</td>
                                <td>{{ $objective->trigger }}</td>
                                <td>{{ $objective->amount }}</td>
                                <td>
                                    @if($objective->visibility === 'public')
                                        <span class="badge bg-success">
                                            {{ trans('achievement::admin.objectives.visibility.public') }}
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            {{ trans('achievement::admin.objectives.visibility.role') }}
                                        </span>
                                        @if($objective->roles->isNotEmpty())
                                            <br><small class="text-muted">
                                                {{ $objective->roles->pluck('name')->join(', ') }}
                                            </small>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $objective->is_enabled ? 'success' : 'danger' }}">
                                        {{ trans_bool($objective->is_enabled) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('achievement.admin.objectives.edit', $objective) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> {{ trans('messages.actions.edit') }}
                                    </a>

                                    <a href="{{ route('achievement.admin.objectives.destroy', $objective) }}" class="btn btn-danger btn-sm" data-confirm="delete">
                                        <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $objectives->links() }}

            <a class="btn btn-primary" href="{{ route('achievement.admin.objectives.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
