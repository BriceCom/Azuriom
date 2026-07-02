@extends('admin.layouts.admin')

@section('title', trans('tasks::admin.index.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.index.title') }}</h6>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col">
                    <form class="form-inline" action="{{ route('tasks.admin.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-auto">
                                <select class="form-select" name="status">
                                    <option value="">{{ trans('tasks::admin.tasks.filter.status') }}</option>
                                    @foreach($statuses as $status)
                                        <option
                                            value="{{ $status->id }}" @selected(request('status') == $status->id)>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" name="tag">
                                    <option value="">{{ trans('tasks::admin.tasks.filter.tag') }}</option>
                                    @foreach($tags as $tag)
                                        <option
                                            value="{{ $tag->id }}" @selected(request('tag') == $tag->id)>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" name="assignee">
                                    <option value="">{{ trans('tasks::admin.tasks.filter.assignee') }}</option>
                                    @foreach($users as $user)
                                        <option
                                            value="{{ $user->id }}" @selected(request('assignee') == $user->id)>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" name="author">
                                    <option value="">{{ trans('tasks::admin.tasks.filter.author') }}</option>
                                    @foreach($users as $user)
                                        <option
                                            value="{{ $user->id }}" @selected(request('author') == $user->id)>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="archivedSwitch" name="archived" value="1" @checked($archived)>
                                    <label class="form-check-label" for="archivedSwitch">
                                        {{ trans('tasks::admin.tasks.filter.archived') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-filter"></i> {{ trans('tasks::admin.tasks.filter.apply') }}
                                </button>
                                <a href="{{ route('tasks.admin.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-lg"></i> {{ trans('tasks::admin.tasks.filter.clear') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                @can('tasks.create')
                    <div class="col-md-4 text-end">
                        <a href="{{ route('tasks.admin.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> {{ trans('tasks::admin.tasks.create') }}
                        </a>
                    </div>
                @endcan
            </div>

            @if($tasks->isEmpty())
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i> {{ trans('tasks::admin.info.no_tasks') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('tasks::admin.fields.title') }}</th>
                            <th scope="col">{{ trans('tasks::admin.fields.tags') }}</th>
                            <th scope="col">{{ trans('tasks::admin.fields.status') }}</th>
                            <th scope="col">{{ trans('tasks::admin.fields.priority') }}</th>
                            <th scope="col">{{ trans('tasks::admin.fields.author') }}</th>
                            <th scope="col">{{ trans('tasks::admin.fields.assignees') }}</th>
                            <th scope="col">{{ trans('tasks::admin.fields.limited_at') }}</th>
                            <th scope="col">{{ trans('tasks::admin.fields.created_at') }}</th>
                            <th scope="col">{{ trans('tasks::admin.fields.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <th scope="row">{{ $task->id }}</th>
                                <td>
                                    <a href="{{ route('tasks.admin.show', $task) }}">{{ $task->title }}</a>
                                </td>
                                <td>
                                    @if($task->tags->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($task->tags->take(3) as $tag)
                                                <span class="badge"
                                                      style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                                            @endforeach
                                            @if($task->tags->count() > 3)
                                                <span class="badge bg-secondary">+{{ $task->tags->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td style="min-width: 150px;">
                                    @can('tasks.update')
                                        <form action="{{ route('tasks.admin.status.update', $task) }}" method="POST"
                                              class="d-inline">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <select class="form-select form-select-sm" name="status_id"
                                                        onchange="this.form.submit()">
                                                    @foreach($statuses as $status)
                                                        <option
                                                            value="{{ $status->id }}" @selected($task->status_id == $status->id)>{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    @else
                                        <span class="badge"
                                              style="background-color: {{ $task->status->color }}">{{ $task->status->name }}</span>
                                    @endcan
                                </td>
                                <td>{{ $task->priority }}</td>
                                <td>{{ $task->author->name }}</td>
                                <td>
                                    @if($task->assignees->isEmpty())
                                        <span
                                            class="text-muted text-nowrap">{{ trans('tasks::admin.info.no_assignees') }}</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($task->assignees as $assignee)
                                                <span
                                                    class="badge bg-secondary text-nowrap">{{ $assignee->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($task->limited_at)
                                        <span class="{{ $task->isCompletedOnTime() ? 'text-success' : ($task->isOverdue() ? 'text-danger' : '') }} text-nowrap">
                                                {{ $task->limited_at->format('d/m/Y') }}
                                            </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td><span class="text-nowrap">{{ $task->created_at->format('d/m/Y H:i') }}</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('tasks.admin.show', $task) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @can('tasks.update')
                                            <a href="{{ route('tasks.admin.edit', $task) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('tasks.delete')
                                            @if($archived)
                                                <form action="{{ route('tasks.admin.restore', $task->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" title="{{ trans('tasks::admin.actions.restore') }}">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#forceDeleteModal-{{ $task->id }}" title="{{ trans('tasks::admin.actions.force_delete') }}">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal-{{ $task->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        @endcan
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal-{{ $task->id }}" tabindex="-1"
                                         aria-labelledby="deleteModalLabel-{{ $task->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="deleteModalLabel-{{ $task->id }}">{{ trans('tasks::messages.actions.confirm_deletion') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ trans('tasks::messages.actions.confirm_delete', ['item' => $task->title]) }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                                                    @can('tasks.delete')
                                                        <form action="{{ route('tasks.admin.destroy', $task) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-danger">{{ trans('messages.actions.delete') }}</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($archived)
                                    <!-- Force Delete Modal -->
                                    <div class="modal fade" id="forceDeleteModal-{{ $task->id }}" tabindex="-1"
                                         aria-labelledby="forceDeleteModalLabel-{{ $task->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="forceDeleteModalLabel-{{ $task->id }}">{{ trans('tasks::messages.actions.confirm_deletion') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-danger">
                                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                                        {{ trans('tasks::messages.actions.confirm_delete', ['item' => $task->title]) }}
                                                        <strong>{{ trans('tasks::messages.actions.irreversible') }}</strong>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                                                    @can('tasks.delete')
                                                        <form action="{{ route('tasks.admin.force-delete', $task->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-danger">{{ trans('tasks::admin.actions.force_delete') }}</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $tasks->withQueryString()->links() }}
            @endif
        </div>
    </div>
@endsection
