@extends('admin.layouts.admin')

@section('title', "Edition d'un coin")

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('alternative-currency.admin.coins.update', $coin) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')

                @include('alternative-currency::admin.coins._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <a href="{{ route('alternative-currency.admin.coins.destroy', $coin) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
