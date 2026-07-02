@extends('admin.layouts.admin')

@section('title', 'Herodia config')

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.themes.config', $theme) }}" method="POST">
                @csrf

                <div class="row align-items-center g-3">
                    <div class="mb-3">
                        <label class="form-label" for="colorInput">{{ trans('theme::herodia.config.color') }}</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror" id="colorInput" name="color" value="{{ old('color', config('theme.color')) }}">

                        @error('color')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="backgroundInput">{{ trans('theme::herodia.config.background') }}</label>
                        <input type="text" class="form-control @error('background') is-invalid @enderror" id="backgroundInput" name="background" value="{{ old('background', config('theme.background')) }}">

                        @error('background')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="welcome_title">{{ trans('theme::herodia.config.welcome_title') }}</label>
                        <input type="text" class="form-control @error('welcome_title') is-invalid @enderror" id="welcome_title" name="welcome_title" value="{{ old('welcome_title', config('theme.welcome_title')) }}">

                        @error('welcome_title')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="welcome_text">{{ trans('theme::herodia.config.welcome_text') }}</label>
                        <input type="text" class="form-control @error('welcome_text') is-invalid @enderror" id="welcome_text" name="welcome_text" value="{{ old('welcome_text', config('theme.welcome_text')) }}">

                        @error('welcome_text')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="unique_players">{{ trans('theme::herodia.config.unique_players') }}</label>
                        <input type="text" class="form-control @error('unique_players') is-invalid @enderror" id="unique_players" name="unique_players" value="{{ old('unique_players', config('theme.unique_players')) }}">

                        @error('unique_players')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    @include('admin.config.vote')
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>

    <script>
        // TODO: This is temporary, it needs to be moved to a separate JS file.
        document.addEventListener('DOMContentLoaded', initVoteRewardsManagement);

        function initVoteRewardsManagement() {
            document.querySelectorAll('.vote-reward-remove').forEach(attachRemoveListener);

            const addBtn = document.getElementById('addVoteRewardButton');
            if (addBtn) addBtn.addEventListener('click', addVoteReward);
        }

        function attachRemoveListener(btn) {
            btn.addEventListener('click', () => {
                const card = btn.closest('.vote-reward-card');
                if (card) card.remove();
            });
        }

        function addVoteReward() {
            const container = document.querySelector('#vote-rewards-container');
            if (!container) return;

            const index = container.querySelectorAll('.vote-reward-card').length;
            const positionLabel = 'Position';
            const rewardLabel = 'Reward';
            const positionPlaceholder = '1';
            const rewardPlaceholder = '5 diamond';
            const removeTitle = 'Remove';

            const html = `<div class="card mb-3 vote-reward-card border-secondary">
        <div class="card-body p-0">
            <div class="row align-items-end g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-hash me-2"></i>
                            ${positionLabel}
                        </label>
                        <input type="text" class="form-control" name="vote[rewards][${index}][position]" placeholder="${positionPlaceholder}">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label class="form-label fw-semibold">
                            ${rewardLabel}
                        </label>
                        <input type="text" class="form-control" name="vote[rewards][${index}][reward]" placeholder="${rewardPlaceholder}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <button class="btn btn-outline-danger btn-sm vote-reward-remove w-100" type="button" title="${removeTitle}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

            container.insertAdjacentHTML('beforeend', html);
            const newBtn = container.querySelector('.vote-reward-card:last-child .vote-reward-remove');
            if (newBtn) attachRemoveListener(newBtn);
        }

    </script>
@endsection

@push('footer-scripts')
    {{--  Herodia do find config.js 404   --}}
    {{--    <script src="{{ theme_asset('js/config.js') }}"></script>--}}
@endpush
