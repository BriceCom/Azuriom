@extends('admin.layouts.admin')

@section('title', trans('faq::admin.questions.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('faq.admin.questions.store') }}" method="POST">
                <input type="hidden" name="pending_id" value="{{ $pendingId }}">

                @include('admin.elements.editor', ['imagesUploadUrl' => route('faq.admin.questions.attachments.pending', $pendingId)])

                @include('faq::admin.questions._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
