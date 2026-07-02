@extends('admin.layouts.admin')

@include('admin.elements.editor')

@section('title', trans('tasks::admin.tasks.edit'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.tasks.edit') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('tasks.admin.update', $task) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">{{ trans('tasks::admin.fields.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $task->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ trans('tasks::admin.fields.description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror html-editor" id="description" name="description" rows="5">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status_id" class="form-label">{{ trans('tasks::admin.fields.status') }}</label>
                            <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                                <option value="" disabled>{{ trans('messages.actions.select') }}</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @selected(old('status_id', $task->status_id) == $status->id)>{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tags" class="form-label">{{ trans('tasks::admin.fields.tags') }}</label>
                            <select class="form-select @error('tags') is-invalid @enderror" id="tags" name="tags[]" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" @selected(old('tags', $task->tags->pluck('id')->toArray()) && in_array($tag->id, old('tags', $task->tags->pluck('id')->toArray())))>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="started_at" class="form-label">{{ trans('tasks::admin.fields.started_at') }}</label>
                            <input type="date" class="form-control @error('started_at') is-invalid @enderror" id="started_at" name="started_at" value="{{ old('started_at', $task->started_at ? $task->started_at->format('Y-m-d') : '') }}">
                            @error('started_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="limited_at" class="form-label">{{ trans('tasks::admin.fields.limited_at') }}</label>
                            <input type="date" class="form-control @error('limited_at') is-invalid @enderror" id="limited_at" name="limited_at" value="{{ old('limited_at', $task->limited_at ? $task->limited_at->format('Y-m-d') : '') }}">
                            @error('limited_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label">{{ trans('tasks::admin.fields.priority') }} (0-100)</label>
                    <input type="number" min="0" max="100" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" value="{{ old('priority', $task->priority) }}">
                    <div class="form-text">{{ trans('tasks::admin.fields.priority_help') }}</div>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="assignees" class="form-label">{{ trans('tasks::admin.fields.assignees') }}</label>
                            <select class="form-select @error('assignees') is-invalid @enderror" id="assignees" name="assignees[]" multiple>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('assignees', $task->assignees->pluck('id')->toArray()) && in_array($user->id, old('assignees', $task->assignees->pluck('id')->toArray())))>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('assignees')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="related_tasks" class="form-label">{{ trans('tasks::admin.fields.related_tasks') }}</label>
                            <select class="form-select @error('related_tasks') is-invalid @enderror" id="related_tasks" name="related_tasks[]" multiple>
                                @foreach($relatedTasks as $relatedTask)
                                    <option value="{{ $relatedTask->id }}" @selected(old('related_tasks', $task->relatedTasks->pluck('id')->toArray()) && in_array($relatedTask->id, old('related_tasks', $task->relatedTasks->pluck('id')->toArray())))>{{ $relatedTask->title }}</option>
                                @endforeach
                            </select>
                            @error('related_tasks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ trans('tasks::admin.fields.visibility') }}</label>
                    @php($currentVisibility = old('visibility', $task->visibleToRoles->count() > 0 ? 'role' : ($task->is_private ? 'private' : 'public')))
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility" id="visibility_private" value="private" @checked($currentVisibility === 'private')>
                        <label class="form-check-label" for="visibility_private">
                            {{ trans('tasks::messages.visibility.private') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility" id="visibility_public" value="public" @checked($currentVisibility === 'public')>
                        <label class="form-check-label" for="visibility_public">
                            {{ trans('tasks::messages.visibility.public') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility" id="visibility_role" value="role" @checked($currentVisibility === 'role')>
                        <label class="form-check-label" for="visibility_role">
                            {{ trans('tasks::messages.visibility.role') }}
                        </label>
                    </div>
                    <div id="role_visibility_container" class="mt-2 @if($currentVisibility !== 'role') d-none @endif">
                        <select class="form-select @error('visibility_roles') is-invalid @enderror" id="visibility_roles" name="visibility_roles[]" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected(old('visibility_roles', $task->visibleToRoles->pluck('id')->toArray()) && in_array($role->id, old('visibility_roles', $task->visibleToRoles->pluck('id')->toArray())))>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('visibility_roles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <a href="{{ route('tasks.admin.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ trans('messages.actions.cancel') }}
                </a>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('input[name="visibility"]');
            const container = document.getElementById('role_visibility_container');
            function toggle() {
                const selected = document.querySelector('input[name="visibility"]:checked');
                if (selected && selected.value === 'role') {
                    container.classList.remove('d-none');
                } else {
                    container.classList.add('d-none');
                }
            }
            radios.forEach(r => r.addEventListener('change', toggle));
            toggle();
        });
    </script>

    <!-- Checklist Section -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.fields.checklist') }}</h6>
        </div>
        <div class="card-body">
            @if($task->checklistItems->isEmpty())
                <div class="alert alert-info">
                    {{ trans('tasks::admin.info.no_checklist') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">{{ trans('tasks::admin.fields.title') }}</th>
                                <th scope="col">{{ trans('messages.fields.status') }}</th>
                                <th scope="col">{{ trans('messages.fields.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($task->checklistItems as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        @if($item->completed)
                                            <span class="badge bg-success">{{ trans('tasks::messages.status.completed') }}</span>
                                            @if($item->completedByUser)
                                                <small class="text-muted">{{ trans('tasks::messages.by', ['name' => $item->completedByUser->name]) }}</small>
                                            @endif
                                        @else
                                            <span class="badge bg-warning">{{ trans('tasks::messages.status.pending') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('tasks.admin.checklist.update', [$task, $item]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="title" value="{{ $item->title }}">
                                            <input type="hidden" name="completed" value="{{ $item->completed ? '0' : '1' }}">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="bi {{ $item->completed ? 'bi-square' : 'bi-check-square' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('tasks.admin.checklist.destroy', [$task, $item]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <form action="{{ route('tasks.admin.checklist.store', $task) }}" method="POST" class="mt-3">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" name="title" placeholder="{{ trans('tasks::admin.tasks.add_checklist') }}" required>
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const visibilityRoleRadio = document.getElementById('visibility_role');
                const roleVisibilityContainer = document.getElementById('role_visibility_container');

                // Initial state
                if (visibilityRoleRadio.checked) {
                    roleVisibilityContainer.classList.remove('d-none');
                }

                // Add event listeners to all visibility radio buttons
                document.querySelectorAll('input[name="visibility"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        if (visibilityRoleRadio.checked) {
                            roleVisibilityContainer.classList.remove('d-none');
                        } else {
                            roleVisibilityContainer.classList.add('d-none');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
