@extends('admin.layouts.admin')

@section('title', trans('daily-reward::admin.days.edit', ['day' => $day->day_number]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('daily-reward.admin.days.update', $day) }}" method="POST">
                @method('PUT')

                @include('daily-reward::admin.days._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <a href="{{ route('daily-reward.admin.days.destroy', $day) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
