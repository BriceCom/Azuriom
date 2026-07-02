@extends('admin.layouts.admin')

@section('title', trans('quiz::admin.questions.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('quiz::admin.questions.create') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('quiz.admin.questions.store') }}" method="POST">
                @include('quiz::admin.questions._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
