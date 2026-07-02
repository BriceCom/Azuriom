@extends('admin.layouts.admin')

@section('title', trans('achievement::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('achievement.admin.settings.save') }}" method="POST" enctype="multipart/form-data">
                @csrf


                <h3>{{ trans('achievement::admin.settings.trophy_system') }}</h3>
                <div class="mb-3">
                    <label class="form-label" for="trophyNameInput">{{ trans('achievement::admin.settings.trophy_name') }}</label>
                    <input type="text" class="form-control" id="trophyNameInput" name="trophy_name" value="{{ $trophyName }}" required>
                    <small class="form-text">{{ trans('achievement::admin.settings.trophy_name_info') }}</small>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="trophyIconInput">{{ trans('achievement::admin.settings.trophy_icon') }}</label>
                    <input type="text" class="form-control" id="trophyIconInput" name="trophy_icon" value="{{ $trophyIcon }}">
                    <small class="form-text">{{ trans('achievement::admin.settings.trophy_icon_info') }}</small>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="trophyImageSelect">{{ trans('achievement::admin.settings.trophy_image') }}</label>
                    <div class="d-flex align-items-center">
                        <a class="input-group-text text-success me-2" href="{{ route('admin.images.create') }}" title="Upload a image" target="_blank" rel="noopener noreferrer">
                           <i class="bi bi-upload"></i>
                        </a>
                        <select class="form-select @error('trophy_image') is-invalid @enderror" id="trophyImageSelect" name="trophy_image" onchange="showTrophyPreview()">
                            <option value="">{{ trans('messages.actions.none') }}</option>
                            @foreach($images as $image)
                                <option value="{{ $image->file }}" @selected($trophyImage === $image->file)>{{ $image->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('trophy_image')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <div class="mt-3" style="height: 100px; {{ $trophyImage ? '' : 'display: none;' }}" id="trophyImagePreviewContainer">
                        <img id="trophyImagePreview" style="object-fit: contain;" class="w-100 h-100" src="{{ $trophyImage ? image_url($trophyImage) : '' }}" alt="Trophy Image">
                    </div>

                    <small class="form-text">{{ trans('achievement::admin.settings.trophy_image_info') }}</small>
                </div>

                <h3>{{ trans('achievement::admin.settings.leaderboard_settings') }}</h3>
                <div class="mb-3">
                    <label class="form-label" for="leaderboardTitleInput">{{ trans('achievement::admin.settings.leaderboard_title') }}</label>
                    <input type="text" class="form-control" id="leaderboardTitleInput" name="leaderboard_title" value="{{ $leaderboardTitle }}" required>
                    <small class="form-text">{{ trans('achievement::admin.settings.leaderboard_title_info') }}</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h3>{{ trans('achievement::admin.settings.reset_trophy_points') }}</h3>
            <p class="text-muted">{{ trans('achievement::admin.settings.reset_trophy_points_info') }}</p>

            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('achievement.admin.settings.reset-all') }}" method="POST" onsubmit="return confirm('{{ trans('achievement::admin.settings.reset_all_confirm') }}')">
                        @csrf
                        <div>
                            <div class="card-body">
                                <h5 class="card-title text-danger">{{ trans('achievement::admin.settings.reset_all_players') }}</h5>
                                <p class="card-text">{{ trans('achievement::admin.settings.reset_all_players_info') }}</p>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-arrow-counterclockwise"></i> {{ trans('achievement::admin.settings.reset_all') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('achievement.admin.settings.reset-player') }}" method="POST" onsubmit="return confirmPlayerReset()">
                        @csrf
                        <div class="border-warning">
                            <div class="card-body">
                                <h5 class="card-title text-warning">{{ trans('achievement::admin.settings.reset_specific_player') }}</h5>
                                <p class="card-text">{{ trans('achievement::admin.settings.reset_specific_player_info') }}</p>

                                <div class="mb-3">
                                    <label class="form-label" for="playerNameInput">{{ trans('achievement::admin.settings.player_name') }}</label>
                                    <input type="text" class="form-control" id="playerNameInput" name="player_name" list="playersList" placeholder="{{ trans('achievement::admin.settings.select_player') }}" required>
                                    <datalist id="playersList">
                                        @foreach($users as $user)
                                            <option value="{{ $user->name }}">
                                        @endforeach
                                    </datalist>
                                    <small class="form-text">{{ trans('achievement::admin.settings.player_name_info') }}</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="resetAmountInput">{{ trans('achievement::admin.settings.reset_amount') }}</label>
                                    <input type="number" class="form-control" id="resetAmountInput" name="reset_amount" min="0" placeholder="{{ trans('achievement::admin.settings.reset_amount_placeholder') }}">
                                    <small class="form-text">{{ trans('achievement::admin.settings.reset_amount_info') }}</small>
                                </div>

                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-arrow-counterclockwise"></i> {{ trans('achievement::admin.settings.reset_player') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showTrophyPreview() {
                const select = document.getElementById('trophyImageSelect');
                const container = document.getElementById('trophyImagePreviewContainer');
                const img = document.getElementById('trophyImagePreview');

                if (select.value) {
                    img.src = '{{ asset('storage/img') }}/' + select.value;
                    container.style.display = '';
                } else {
                    container.style.display = 'none';
                    img.src = '';
                }
            }

            function confirmPlayerReset() {
                const playerInput = document.getElementById('playerNameInput');
                const resetAmountInput = document.getElementById('resetAmountInput');

                if (!playerInput.value || playerInput.value.trim() === '') {
                    alert('{{ trans('achievement::admin.settings.please_select_player') }}');
                    return false;
                }

                let confirmMessage;
                if (resetAmountInput.value && resetAmountInput.value.trim() !== '') {
                    confirmMessage = '{{ trans('achievement::admin.settings.reset_player_amount_confirm') }}'.replace(':name', playerInput.value).replace(':amount', resetAmountInput.value);
                } else {
                    confirmMessage = '{{ trans('achievement::admin.settings.reset_player_confirm') }}'.replace(':name', playerInput.value);
                }

                return confirm(confirmMessage);
            }
        </script>
    @endpush
@endsection
