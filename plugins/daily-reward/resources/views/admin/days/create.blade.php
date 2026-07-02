@extends('admin.layouts.admin')

@section('title', trans('daily-reward::admin.days.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('daily-reward.admin.days.store') }}" method="POST">
                @include('daily-reward::admin.days._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
