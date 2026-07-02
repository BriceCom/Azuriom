@extends('admin.layouts.admin')

@section('title', trans('webhook-manager::admin.services.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('webhook-manager.admin.services.store') }}" method="POST">
                @include('webhook-manager::admin.services._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
