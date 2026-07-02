@extends('admin.layouts.admin')

@section('title', trans('spin-wheel::admin.pages.rewards.create.title'))

@section('content')


    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('spin-wheel.admin.rewards.store') }}" method="POST">

                @include('spin-wheel::admin.elements._form')


                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
