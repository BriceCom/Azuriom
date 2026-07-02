@extends('admin.layouts.admin')

@section('title', trans('webhook-manager::admin.services.edit', ['name' => $service->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('webhook-manager.admin.services.update', $service) }}" method="POST">
                @method('PUT')

                @include('webhook-manager::admin.services._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('webhook-manager.admin.services.destroy', $service) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
