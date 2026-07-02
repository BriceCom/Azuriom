@extends('admin.layouts.admin')

@section('title', trans('tasks::admin.tags.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.tags.title') }}</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8">
                    <p>{{ trans('tasks::admin.tags.description') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    @can('tasks.tags.create')
                        <a href="{{ route('tasks.admin.tags.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> {{ trans('tasks::admin.tags.create') }}
                        </a>
                    @endcan
                </div>
            </div>

            @if($tags->isEmpty())
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i> {{ trans('tasks::admin.info.no_tags') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ trans('tasks::admin.fields.name') }}</th>
                                <th scope="col">{{ trans('tasks::admin.fields.color') }}</th>
                                <th scope="col">{{ trans('tasks::admin.fields.created_at') }}</th>
                                <th scope="col">{{ trans('tasks::admin.fields.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <th scope="row">{{ $tag->id }}</th>
                                    <td>{{ $tag->name }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $tag->color }}; border-radius: 3px;"></div>
                                            <span>{{ $tag->color }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $tag->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('tasks.update')
                                                <a href="{{ route('tasks.admin.tags.edit', $tag) }}" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('tasks.delete')
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $tag->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endcan
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal-{{ $tag->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $tag->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel-{{ $tag->id }}">{{ trans('tasks::messages.actions.confirm_deletion') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ trans('tasks::messages.actions.confirm_delete', ['item' => $tag->name]) }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                                                        @can('tasks.delete')
                                                            <form action="{{ route('tasks.admin.tags.destroy', $tag) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ trans('messages.actions.delete') }}</button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $tags->links() }}
            @endif
        </div>
    </div>
@endsection
