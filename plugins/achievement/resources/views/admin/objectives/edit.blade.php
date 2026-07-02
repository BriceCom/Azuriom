@extends('admin.layouts.admin')

@section('title', trans('achievement::admin.objectives.edit', ['objective' => $objective->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('achievement.admin.objectives.update', $objective) }}" method="POST">
                @method('PUT')

                @include('achievement::admin.objectives._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
