@extends('admin.layouts.admin')

@section('title', trans('daily-reward::admin.rewards.edit', ['reward' => $reward->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('daily-reward.admin.rewards.update', $reward) }}" method="POST">
                @method('PUT')

                @include('daily-reward::admin.rewards._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <a href="{{ route('daily-reward.admin.rewards.destroy', $reward) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
