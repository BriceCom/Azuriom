@extends('admin.layouts.admin')

@section('title', trans('daily-reward::admin.rewards.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('daily-reward.admin.rewards.store') }}" method="POST">
                @include('daily-reward::admin.rewards._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
