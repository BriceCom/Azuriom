@extends('admin.layouts.admin')

@section('title', trans('quiz::admin.questions.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('quiz::admin.questions.title') }}</h6>
            <a href="{{ route('quiz.admin.questions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ trans('quiz::admin.questions.create') }}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('quiz::admin.fields.question') }}</th>
                        <th scope="col">{{ trans('quiz::admin.fields.activation_date') }}</th>
                        <th scope="col">{{ trans('quiz::admin.fields.difficulty') }}</th>
                        <th scope="col">{{ trans('quiz::admin.fields.time_limit') }}</th>
                        <th scope="col">{{ trans('quiz::admin.fields.reward') }}</th>
                        <th scope="col">{{ trans('quiz::admin.questions.status') }}</th>
                        <th scope="col">{{ trans('quiz::admin.fields.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <th scope="row">{{ $question->id }}</th>
                            <td>{{ $question->question }}</td>
                            <td>{{ $question->activation_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $question->difficulty === 'hard' ? 'danger' : ($question->difficulty === 'medium' ? 'warning text-dark' : 'success') }}">
                                    {{ trans('quiz::admin.difficulties.' . ($question->difficulty ?? 'easy')) }}
                                </span>
                            </td>
                            <td>{{ $question->time_limit ? $question->time_limit . 's' : '-' }}</td>
                            <td>{{ $question->reward }}</td>
                            <td>
                                <span class="badge bg-{{ $question->is_active ? 'success' : 'danger' }}">
                                    {{ trans('quiz::admin.questions.' . ($question->is_active ? 'active' : 'inactive')) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('quiz.admin.questions.edit', $question) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                <a href="{{ route('quiz.admin.questions.destroy', $question) }}" class="mx-1 text-danger" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $questions->links() }}
        </div>
    </div>
@endsection
