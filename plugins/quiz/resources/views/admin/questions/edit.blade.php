@extends('admin.layouts.admin')

@section('title', trans('quiz::admin.questions.edit'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('quiz::admin.questions.edit') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('quiz.admin.questions.update', $question) }}" method="POST">
                @method('PUT')
                @include('quiz::admin.questions._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ trans('messages.actions.delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ trans('messages.responses.delete') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.cancel') }}</button>
                    <form action="{{ route('quiz.admin.questions.destroy', $question) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ trans('messages.actions.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
