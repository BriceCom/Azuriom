@extends('admin.layouts.admin')

@section('title', trans('scratch-game::admin.rewards.edit', ['reward' => $reward->name]))

@section('content')
    <a href="{{ route('scratch-game.admin.rewards.index') }}" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left"></i> {{ trans('scratch-game::admin.buttons.back') }}
    </a>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('scratch-game.admin.rewards.update', $reward) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('scratch-game::admin.rewards._form')

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg"></i> {{ trans('scratch-game::admin.buttons.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ trans('scratch-game::admin.rewards.fields.used_in_cards') }}</h5>
                </div>
                <div class="card-body">
                    @if($reward->cards->isEmpty())
                        <p class="text-muted mb-0">{{ trans('scratch-game::admin.rewards.not_used_yet') }}</p>
                    @else
                        <ul class="list-unstyled mb-0">
                            @foreach($reward->cards as $card)
                                <li class="mb-2">
                                    <a href="{{ route('scratch-game.admin.cards.edit', $card) }}" class="text-decoration-none">
                                        {{ $card->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
