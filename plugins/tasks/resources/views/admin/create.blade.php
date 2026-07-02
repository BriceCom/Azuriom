@extends('admin.layouts.admin')

@include('admin.elements.editor')

@section('title', trans('tasks::admin.tasks.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.tasks.create') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('tasks.admin.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">{{ trans('tasks::admin.fields.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ trans('tasks::admin.fields.description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror html-editor" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status_id" class="form-label">{{ trans('tasks::admin.fields.status') }}</label>
                            <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                                <option value="" disabled selected>{{ trans('tasks::messages.actions.select') }}</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @selected(old('status_id') == $status->id)>{{ $status->name }}</option>
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
                                    <option value="{{ $tag->id }}" @selected(old('tags') && in_array($tag->id, old('tags')))>{{ $tag->name }}</option>
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
                            <input type="date" class="form-control @error('started_at') is-invalid @enderror" id="started_at" name="started_at" value="{{ old('started_at') }}">
                            @error('started_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="limited_at" class="form-label">{{ trans('tasks::admin.fields.limited_at') }}</label>
                            <input type="date" class="form-control @error('limited_at') is-invalid @enderror" id="limited_at" name="limited_at" value="{{ old('limited_at') }}">
                            @error('limited_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label">{{ trans('tasks::admin.fields.priority') }} (0-100)</label>
                    <input type="number" min="0" max="100" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" value="{{ old('priority', 0) }}">
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
                                    <option value="{{ $user->id }}" @selected(old('assignees') && in_array($user->id, old('assignees')))>{{ $user->name }}</option>
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
                                    <option value="{{ $relatedTask->id }}" @selected(old('related_tasks') && in_array($relatedTask->id, old('related_tasks')))>{{ $relatedTask->title }}</option>
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
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility" id="visibility_private" value="private" checked>
                        <label class="form-check-label" for="visibility_private">
                            {{ trans('tasks::messages.visibility.private') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility" id="visibility_public" value="public">
                        <label class="form-check-label" for="visibility_public">
                            {{ trans('tasks::messages.visibility.public') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility" id="visibility_role" value="role">
                        <label class="form-check-label" for="visibility_role">
                            {{ trans('tasks::messages.visibility.role') }}
                        </label>
                    </div>
                    <div id="role_visibility_container" class="mt-2 d-none">
                        <select class="form-select @error('visibility_roles') is-invalid @enderror" id="visibility_roles" name="visibility_roles[]" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected(old('visibility_roles') && in_array($role->id, old('visibility_roles')))>{{ $role->name }}</option>
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
