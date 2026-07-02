@extends('admin.layouts.admin')

@include('admin.elements.editor')

@section('title', $task->title)

@section('content')
 <div>

     <div class="card shadow mb-4">
         <div class="card-header">
             <div class="d-flex justify-content-between align-items-center">
                 <h6 class="m-0 font-weight-bold text-primary">
                     {{ $task->title }}
                     @if($task->trashed())
                         <span class="badge bg-secondary">{{ trans('tasks::admin.tasks.filter.archived') }}</span>
                     @endif
                 </h6>
                 <div>
                     <a href="{{ route('tasks.admin.index') }}" class="btn btn-secondary">
                         <i class="bi bi-arrow-left"></i> {{ trans('messages.actions.back') }}
                     </a>
                     @can('tasks.update')
                         <a href="{{ route('tasks.admin.edit', $task) }}" class="btn btn-primary">
                             <i class="bi bi-pencil"></i> {{ trans('messages.actions.edit') }}
                         </a>
                     @endcan
                     @can('tasks.delete')
                         @if($task->trashed())
                             <form action="{{ route('tasks.admin.restore', $task->id) }}" method="POST" class="d-inline">
                                 @csrf
                                 <button type="submit" class="btn btn-success">
                                     <i class="bi bi-arrow-counterclockwise"></i> {{ trans('tasks::admin.actions.restore') }}
                                 </button>
                             </form>
                             <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                     data-bs-target="#forceDeleteModal">
                                 <i class="bi bi-trash-fill"></i> {{ trans('tasks::admin.actions.force_delete') }}
                             </button>
                         @else
                             <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                     data-bs-target="#deleteModal">
                                 <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                             </button>
                         @endif
                     @endcan
                 </div>
             </div>
         </div>
     </div>


     <div class="row">
         <div class="col">
             <!-- Main Content -->
                 <div class="card shadow-sm mb-4">
                     <div class="card-header d-flex justify-content-between align-items-center">
                         <div class="d-flex align-items-center">
                             <form action="{{ route('tasks.admin.status.update', $task) }}" method="POST"
                                   class="me-2">
                                 @csrf
                                 <div class="input-group">
                                     <select class="form-select" name="status_id"
                                             onchange="this.form.submit()">
                                         @foreach($statuses as $status)
                                             <option
                                                 value="{{ $status->id }}" @selected($task->status_id == $status->id)>{{ $status->name }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             </form>
                             @if($task->isOverdue())
                                 <span class="badge bg-danger">{{ trans('tasks::messages.info.overdue') }}</span>
                             @elseif($task->limited_at && $task->limited_at->diffInDays(now()) <= 3)
                                 <span class="badge bg-warning">{{ trans('tasks::messages.info.due_soon') }}</span>
                             @endif
                         </div>
                     </div>
                     <div class="card-body">
                         <div class="mb-4">
                             {!! $task->description !!}
                         </div>

                         @if($task->tags->isNotEmpty())
                             <div class="mb-3">
                                 <h5>{{ trans('tasks::admin.fields.tags') }}</h5>
                                 <div class="d-flex flex-wrap gap-1">
                                     @foreach($task->tags as $tag)
                                         <span class="badge"
                                               style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                                     @endforeach
                                 </div>
                             </div>
                         @endif

                         @if($task->relatedTasks->isNotEmpty())
                             <div class="mb-3">
                                 <h5>{{ trans('tasks::admin.fields.related_tasks') }}</h5>
                                 <ul class="list-group">
                                     @foreach($task->relatedTasks as $relatedTask)
                                         <li class="list-group-item d-flex justify-content-between align-items-center">
                                             <a href="{{ route('tasks.admin.show', $relatedTask) }}"
                                                class="text-decoration-none">
                                                 {{ $relatedTask->title }}
                                             </a>
                                             <span class="badge bg-secondary">{{ $relatedTask->status->name }}</span>
                                         </li>
                                     @endforeach
                                 </ul>
                             </div>
                         @endif

                         <!-- Checklist Section -->
                         <div class="mb-3">
                             <h5>{{ trans('tasks::admin.fields.checklist') }}</h5>
                             @if($task->checklistItems->isEmpty())
                                 <div class="alert alert-info">
                                     {{ trans('tasks::admin.info.no_checklist') }}
                                 </div>
                             @else
                                 <div class="progress mb-3" role="progressbar" aria-label="Task completion">
                                     <div class="progress-bar"
                                          style="width: {{ $task->getCompletionPercentage() }}%">
                                         {{ trans('tasks::admin.info.completion', ['percent' => $task->getCompletionPercentage()]) }}
                                     </div>
                                 </div>
                                 <ul class="list-group mb-3">
                                     @foreach($task->checklistItems as $item)
                                         <li class="list-group-item d-flex justify-content-between align-items-center">
                                             <div class="form-check">
                                                 <form
                                                     action="{{ route('tasks.admin.checklist.update', [$task, $item]) }}"
                                                     method="POST">
                                                     @csrf
                                                     <input type="hidden" name="title" value="{{ $item->title }}">
                                                     <input type="hidden" name="completed"
                                                            value="{{ $item->completed ? '0' : '1' }}">
                                                     <div class="d-flex align-items-center">
                                                         <button type="submit" class="btn btn-link p-0 me-2">
                                                             <i class="bi {{ $item->completed ? 'bi-check-square' : 'bi-square' }}"></i>
                                                         </button>
                                                         <span
                                                             class="{{ $item->completed ? 'text-decoration-line-through' : '' }}">
                                                                {{ $item->title }}
                                                            </span>
                                                     </div>
                                                 </form>
                                             </div>
                                             <form
                                                 action="{{ route('tasks.admin.checklist.destroy', [$task, $item]) }}"
                                                 method="POST" class="d-inline">
                                                 @csrf
                                                 @method('DELETE')
                                                 <button type="submit" class="btn btn-sm btn-danger">
                                                     <i class="bi bi-trash"></i>
                                                 </button>
                                             </form>
                                         </li>
                                     @endforeach
                                 </ul>
                             @endif

                             <form action="{{ route('tasks.admin.checklist.store', $task) }}" method="POST"
                                   class="mt-3">
                                 @csrf
                                 <div class="input-group">
                                     <input type="text" class="form-control" name="title"
                                            placeholder="{{ trans('tasks::admin.tasks.add_checklist') }}" required>
                                     <button class="btn btn-primary" type="submit">
                                         <i class="bi bi-plus-lg"></i>
                                     </button>
                                 </div>
                             </form>
                         </div>
                     </div>
             </div>

             <!-- Comments Section -->
             <div class="card card-shadow mb-3">
                 <div class="card-body">
                     <h5>{{ trans('tasks::admin.fields.comments') }}</h5>
                     @if($task->comments->isEmpty())
                         <div class="alert alert-info">
                             {{ trans('tasks::admin.info.no_comments') }}
                         </div>
                     @else
                         <div class="list-group mb-3">
                             @foreach($task->comments as $comment)
                                 <div class="list-group-item">
                                     <div class="d-flex justify-content-between align-items-center mb-2">
                                         <div>
                                             <strong>{{ $comment->author->name }}</strong>
                                             <small class="text-muted ms-2">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                         </div>
                                         <div>
                                             @if($comment->author_id === Auth::id() || Auth::user()->isAdmin())
                                                 <div class="btn-group" role="group">
                                                     <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCommentModal-{{ $comment->id }}">
                                                         <i class="bi bi-pencil"></i>
                                                     </button>
                                                     <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCommentModal-{{ $comment->id }}">
                                                         <i class="bi bi-trash"></i>
                                                     </button>
                                                 </div>
                                             @endif
                                         </div>
                                     </div>
                                     <div class="wysiwyg-content">
                                         {!! $comment->content !!}
                                     </div>
                                 </div>

                                 <!-- Edit Comment Modal -->
                                 <div class="modal fade" id="editCommentModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="editCommentModalLabel-{{ $comment->id }}" aria-hidden="true">
                                     <div class="modal-dialog modal-lg">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h5 class="modal-title" id="editCommentModalLabel-{{ $comment->id }}">{{ trans('tasks::messages.actions.edit_comment') }}</h5>
                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                             </div>
                                             <form action="{{ route('tasks.admin.comment.update', [$task, $comment]) }}" method="POST">
                                                 @csrf
                                                 <div class="modal-body">
                                                     <div class="mb-3">
                                                         <label for="content-{{ $comment->id }}" class="form-label">{{ trans('tasks::messages.fields.content') }}</label>
                                                         <textarea class="form-control html-editor" id="content-{{ $comment->id }}" name="content" rows="5" required>{{ old('content', $comment->content) }}</textarea>
                                                     </div>
                                                 </div>
                                                 <div class="modal-footer">
                                                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                                                     <button type="submit" class="btn btn-primary">{{ trans('messages.actions.save') }}</button>
                                                 </div>
                                             </form>
                                         </div>
                                     </div>
                                 </div>

                                 <!-- Delete Comment Modal -->
                                 <div class="modal fade" id="deleteCommentModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="deleteCommentModalLabel-{{ $comment->id }}" aria-hidden="true">
                                     <div class="modal-dialog">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h5 class="modal-title" id="deleteCommentModalLabel-{{ $comment->id }}">{{ trans('tasks::messages.actions.confirm_deletion') }}</h5>
                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                             </div>
                                             <div class="modal-body">
                                                 {{ trans('tasks::messages.actions.confirm_delete', ['item' => trans('tasks::messages.fields.content')]) }}
                                             </div>
                                             <div class="modal-footer">
                                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                                                 <form action="{{ route('tasks.admin.comment.destroy', [$task, $comment]) }}" method="POST">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="submit" class="btn btn-danger">{{ trans('messages.actions.delete') }}</button>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     @endif

                     <form action="{{ route('tasks.admin.comment.store', $task) }}" method="POST" class="mt-3">
                         @csrf
                         <div class="mb-3">
                             <label for="content" class="form-label">{{ trans('tasks::admin.tasks.add_comment') }}</label>
                             <textarea class="form-control html-editor @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content') }}</textarea>
                             @error('content')
                             <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>
                         <button type="submit" class="btn btn-primary">
                             <i class="bi bi-plus-lg"></i> {{ trans('tasks::messages.actions.add_comment') }}
                         </button>
                     </form>
                 </div>
             </div>
         </div>


         <!-- Sidebar -->
         <div class="col-lg-4">
             <!-- Task Info Card -->
             <div class="card shadow-sm mb-4">
                 <div class="card-header">
                     <i class="bi bi-info-circle"></i> {{ trans('tasks::messages.fields.informations') }}
                 </div>
                 <div class="card-body">
                     <ul class="list-group list-group-flush">
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                             <span>{{ trans('messages.fields.author') }}</span>
                             <span>{{ $task->author->name }}</span>
                         </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                             <span>{{ trans('tasks::admin.fields.created_at') }}</span>
                             <span>{{ $task->created_at->format('d/m/Y H:i') }}</span>
                         </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                             <span>{{ trans('tasks::admin.fields.priority') }}</span>
                             <span>{{ $task->priority }}</span>
                         </li>
                         @if($task->started_at)
                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                 <span>{{ trans('tasks::admin.fields.started_at') }}</span>
                                 <span>{{ $task->started_at->format('d/m/Y') }}</span>
                             </li>
                         @endif
                         @if($task->limited_at)
                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                 <span>{{ trans('tasks::admin.fields.limited_at') }}</span>
                                 <span class="{{ $task->isOverdue() ? 'text-danger' : '' }}">
                                            {{ $task->limited_at->format('d/m/Y') }}
                                        </span>
                             </li>
                         @endif
                     </ul>
                 </div>
             </div>

             <!-- Assignees Card -->
             <div class="card shadow-sm mb-4">
                 <div class="card-header">
                     <i class="bi bi-people"></i> {{ trans('tasks::admin.fields.assignees') }}
                 </div>
                 <div class="card-body">
                     @if($task->assignees->isEmpty())
                         <div class="alert alert-info">
                             {{ trans('tasks::admin.info.no_assignees') }}
                         </div>
                     @else
                         <ul class="list-group">
                             @foreach($task->assignees as $assignee)
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                     {{ $assignee->name }}
                                     <form
                                         action="{{ route('tasks.admin.assignee.remove', [$task, $assignee]) }}"
                                         method="POST">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn btn-sm btn-danger">
                                             <i class="bi bi-x-lg"></i>
                                         </button>
                                     </form>
                                 </li>
                             @endforeach
                         </ul>
                     @endif

                     <form action="{{ route('tasks.admin.assignee.add', $task) }}" method="POST" class="mt-3">
                         @csrf
                         <div class="input-group">
                             <select class="form-select" name="user_id" required>
                                 <option value="" disabled
                                         selected>{{ trans('tasks::admin.tasks.add_assignee') }}</option>
                                 @foreach(\Azuriom\Models\User::all() as $user)
                                     @if(!$task->assignees->contains($user))
                                         <option value="{{ $user->id }}">{{ $user->name }}</option>
                                     @endif
                                 @endforeach
                             </select>
                             <button class="btn btn-primary" type="submit">
                                 <i class="bi bi-plus-lg"></i>
                             </button>
                         </div>
                     </form>
                 </div>
             </div>


             <!-- Task Logs Card -->
             <div class="card shadow-sm mb-4">
                 <div class="card-header">
                     <i class="bi bi-clock-history"></i> {{ trans('tasks::admin.fields.logs') }}
                 </div>
                 <div class="card-body">
                     @if($task->logs->isEmpty())
                         <div class="alert alert-info">
                             {{ trans('tasks::admin.info.no_logs') }}
                         </div>
                     @else
                         <ul class="list-group">
                             @foreach($task->logs->sortByDesc('created_at')->take(10) as $log)
                                 <li class="list-group-item">
                                     <div class="d-flex justify-content-between">
                                         <span>{{ trans('tasks::admin.logs.' . $log->action) }}</span>
                                         <small
                                             class="text-muted">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                                     </div>
                                     @if($log->user)
                                         <small
                                             class="text-muted">{{ trans('tasks::messages.by', ['name' => $log->user->name]) }}</small>
                                     @endif
                                 </li>
                             @endforeach
                         </ul>
                     @endif
                 </div>
             </div>
         </div>
     </div>

 </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ trans('tasks::messages.actions.confirm_deletion') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ trans('tasks::messages.actions.confirm_delete', ['item' => $task->title]) }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                    <form action="{{ route('tasks.admin.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ trans('messages.actions.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Force Delete Modal -->
    @if($task->trashed())
    <div class="modal fade" id="forceDeleteModal" tabindex="-1" aria-labelledby="forceDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forceDeleteModalLabel">{{ trans('tasks::messages.actions.confirm_deletion') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <form action="{{ route('tasks.admin.force-delete', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ trans('tasks::admin.actions.force_delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
