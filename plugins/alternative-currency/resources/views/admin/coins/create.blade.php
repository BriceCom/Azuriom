@extends('admin.layouts.admin')

@section('title', "Création d'un coin")

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('alternative-currency.admin.coins.store') }}" method="POST">
                @csrf

                @include('alternative-currency::admin.coins._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
