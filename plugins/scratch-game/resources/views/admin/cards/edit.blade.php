@extends('admin.layouts.admin')

@section('title', trans('scratch-game::admin.cards.edit', ['card' => $card->name]))

@section('content')
    <a href="{{ route('scratch-game.admin.cards.index') }}" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left"></i> {{ trans('scratch-game::admin.buttons.back') }}
    </a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('scratch-game.admin.cards.update', $card) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('scratch-game::admin.cards._form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg"></i> {{ trans('scratch-game::admin.buttons.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
