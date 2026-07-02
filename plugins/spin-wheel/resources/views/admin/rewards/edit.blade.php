@extends('admin.layouts.admin')

@section('title', trans('spin-wheel::admin.pages.rewards.edit.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('spin-wheel.admin.rewards.update', $reward) }}" method="POST">
                @method('PUT')

                @include('spin-wheel::admin.elements._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <a href="{{ route('spin-wheel.admin.rewards.destroy', $reward) }}" class="btn btn-danger"
                    data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
