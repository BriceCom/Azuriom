@extends('admin.layouts.admin')

@section('title', trans('webhook-manager::admin.webhooks.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('webhook-manager.admin.webhooks.store') }}" method="POST">
                @include('webhook-manager::admin.webhooks._form')

                <button type="submit" class="btn btn-primary" @disabled($services->isEmpty())>
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
