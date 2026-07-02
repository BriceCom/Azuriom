@extends('admin.layouts.admin')

@section('title', trans('scratch-game::admin.cards.create'))

@section('content')
    <a href="{{ route('scratch-game.admin.cards.index') }}" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left"></i> {{ trans('scratch-game::admin.buttons.back') }}
    </a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('scratch-game.admin.cards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('scratch-game::admin.cards._form')

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg"></i> {{ trans('scratch-game::admin.buttons.create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
