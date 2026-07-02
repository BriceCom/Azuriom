@extends('admin.layouts.admin')

@section('title', trans('webhook-manager::admin.webhooks.edit', ['name' => $webhook->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('webhook-manager.admin.webhooks.update', $webhook) }}" method="POST">
                @method('PUT')

                @include('webhook-manager::admin.webhooks._form')

                <button type="submit" class="btn btn-primary" @disabled($services->isEmpty())>
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('webhook-manager.admin.webhooks.destroy', $webhook) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
