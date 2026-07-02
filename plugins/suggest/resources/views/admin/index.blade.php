@extends('admin.layouts.admin')

@section('title', trans('suggest::admin.suggestions.title'))

@include('admin.elements.editor')

@section('content')
    <div class="col-12 mb-3 d-flex flex-column gap-2">
        <ul class="list-unstyled d-flex flex-wrap gap-2">
            <li>
                <a href="https://discord.gg/Gh2yBxUWvV" target="_blank"
                   class="btn btn-primary fw-bold rounded-4 text-uppercase px-3"><i
                        class="bi bi-discord me-1"></i>{{trans('suggest::admin.support')}}</a>
            </li>
            <li>
                <a href="https://www.serveurliste.com" target="_blank"
                   class="btn btn-warning fw-bold rounded-4 text-uppercase px-3"><i
                        class="bi bi-search-heart-fill me-1"></i>{{trans('suggest::admin.serveurliste')}}</a>
            </li>
        </ul>
        <hr>
    </div>

    <!-- Filter Controls -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="mb-0">
                        @if(isset($isArchive) && $isArchive)
                            {{ trans('suggest::admin.suggestions.archive_title') }}
                        @else
                            {{ trans('suggest::admin.suggestions.active_title') }}
                        @endif
                        <span class="badge bg-secondary ms-2">{{ $suggestions->total() }}</span>
                    </h6>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group" role="group">
                        <a href="{{ route('suggest.admin.index') }}"
                           class="btn btn-sm {{ !isset($isArchive) ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-hourglass-split"></i> {{ trans('suggest::messages.status.pending') }}
                        </a>
                        <a href="{{ route('suggest.admin.archive') }}"
                           class="btn btn-sm {{ isset($isArchive) ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-archive"></i> {{ trans('suggest::admin.suggestions.archived') }}
                        </a>
                    </div>
                    @if(isset($isArchive) && $isArchive)
                        <div class="btn-group ms-2" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                {{ trans('messages.fields.status') }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item {{ $currentStatus === 'archived' ? 'active' : '' }}"
                                   href="{{ route('suggest.admin.archive') }}">
                                    {{ trans('suggest::admin.suggestions.all_archived') }}
                                </a>
                                <a class="dropdown-item {{ $currentStatus === 'approved' ? 'active' : '' }}"
                                   href="{{ route('suggest.admin.archive', ['status' => 'approved']) }}">
                                    {{ trans('suggest::messages.status.approved') }}
                                </a>
                                <a class="dropdown-item {{ $currentStatus === 'rejected' ? 'active' : '' }}"
                                   href="{{ route('suggest.admin.archive', ['status' => 'rejected']) }}">
                                    {{ trans('suggest::messages.status.rejected') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('messages.fields.title') }}</th>
                        <th scope="col">{{ trans('messages.fields.author') }}</th>
                        <th scope="col">{{ trans('suggest::messages.fields.category') }}</th>
                        <th scope="col">{{ trans('messages.fields.status') }}</th>
                        <th scope="col">{{ trans('messages.fields.date') }}</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($suggestions as $suggestion)
                        <tr>
                            <th scope="row">{{ $suggestion->id }}</th>
                            <td>{{ $suggestion->title }}</td>
                            <td>{{ $suggestion->user->name }}</td>
                            <td>
                                <span class="badge"
                                      style="background-color: {{$suggestion->category->color}}; color: {{color_contrast($suggestion->category->color)}};">
                                    {{  $suggestion->category->name }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $suggestion->status === 'approved' ? 'success' : ($suggestion->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ trans('suggest::messages.status.' . $suggestion->status) }}
                                </span>
                            </td>
                            <td>{{ format_date($suggestion->created_at) }}</td>
                            <td>
                                <a href="{{ route('suggest.admin.edit', $suggestion) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil"></i> {{ trans('messages.actions.edit') }}
                                </a>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ trans('messages.fields.status') }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <form action="{{ route('suggest.admin.status.update', $suggestion) }}"
                                              method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="dropdown-item">
                                                {{ trans('suggest::messages.status.pending') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('suggest.admin.status.update', $suggestion) }}"
                                              method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="dropdown-item">
                                                {{ trans('suggest::messages.status.approved') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('suggest.admin.status.update', $suggestion) }}"
                                              method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#refusalModal{{ $suggestion->id }}">
                                                {{ trans('suggest::messages.status.rejected') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <a href="{{ route('suggest.admin.destroy', $suggestion) }}" class=" btn btn-danger btn-sm" data-confirm="delete">
                                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                                </a>
                            </td>
                        </tr>

                        <!-- Refusal Modal -->
                        <div class="modal fade" id="refusalModal{{ $suggestion->id }}" tabindex="-1" aria-labelledby="refusalModalLabel{{ $suggestion->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="refusalModalLabel{{ $suggestion->id }}">{{ trans('suggest::admin.suggestions.refuse_title') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('suggest.admin.status.update', $suggestion) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="status" value="rejected">
                                            <div class="mb-3">
                                                <label for="refusal_reason{{ $suggestion->id }}" class="form-label">{{ trans('suggest::admin.suggestions.refusal_reason') }}</label>
                                                <textarea class="form-control html-editor" id="refusal_reason{{ $suggestion->id }}" name="refusal_reason" rows="3">{{ $suggestion->refusal_reason }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                                            <button type="submit" class="btn btn-danger">{{ trans('suggest::messages.status.rejected') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $suggestions->links() }}
        </div>
    </div>
@endsection
