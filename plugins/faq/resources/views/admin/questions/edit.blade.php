@extends('admin.layouts.admin')

@section('title', trans('faq::admin.questions.edit', ['question' => $question->id]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('faq.admin.questions.update', $question) }}" method="POST">
                @method('PUT')

                @include('admin.elements.editor', ['imagesUploadUrl' => route('faq.admin.questions.attachments.store', $question)])

                @include('faq::admin.questions._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('faq.admin.questions.destroy', $question) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
