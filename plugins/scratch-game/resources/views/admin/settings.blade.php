@extends('admin.layouts.admin')

@section('title', trans('scratch-game::admin.settings.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('scratch-game.admin.settings.update') }}">
                @csrf

                <h5 class="border-bottom pb-2 mb-4">{{ trans('scratch-game::admin.settings.page.title') }}</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label class="form-label" for="page_title">{{ trans('scratch-game::admin.settings.page.page_title') }}</label>
                        <input type="text"
                               class="form-control @error('page_title') is-invalid @enderror"
                               id="page_title"
                               name="page_title"
                               maxlength="100"
                               value="{{ old('page_title', setting('scratch-game.page_title', '')) }}">
                        <div class="form-text">{{ trans('scratch-game::admin.settings.page.page_title_help') }}</div>
                        @error('page_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mb-4">{{ trans('scratch-game::admin.settings.cards.title') }}</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="card_min_width">{{ trans('scratch-game::admin.settings.cards.min_width') }}</label>
                        <div class="input-group @error('card_min_width') has-validation @enderror">
                            <input type="number"
                                   class="form-control @error('card_min_width') is-invalid @enderror"
                                   id="card_min_width"
                                   name="card_min_width"
                                   min="100"
                                   max="2000"
                                   step="1"
                                   value="{{ old('card_min_width', setting('scratch-game.card_min_width', 300)) }}">
                            <span class="input-group-text">px</span>
                        </div>
                        <div class="form-text">{{ trans('scratch-game::admin.settings.cards.help') }}</div>
                        @error('card_min_width')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="card_min_height">{{ trans('scratch-game::admin.settings.cards.min_height') }}</label>
                        <div class="input-group @error('card_min_height') has-validation @enderror">
                            <input type="number"
                                   class="form-control @error('card_min_height') is-invalid @enderror"
                                   id="card_min_height"
                                   name="card_min_height"
                                   min="100"
                                   max="2000"
                                   step="1"
                                   value="{{ old('card_min_height', setting('scratch-game.card_min_height', 150)) }}">
                            <span class="input-group-text">px</span>
                        </div>
                        <div class="form-text">{{ trans('scratch-game::admin.settings.cards.help') }}</div>
                        @error('card_min_height')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
