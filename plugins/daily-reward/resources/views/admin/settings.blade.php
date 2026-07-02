@extends('admin.layouts.admin')

@section('title', trans('daily-reward::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ trans('daily-reward::admin.settings.title') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('daily-reward.admin.settings.save') }}" method="POST">
                @csrf

                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="enabledSwitch" name="enabled" @checked(old('enabled', $enabled))>
                    <label class="form-check-label" for="enabledSwitch">{{ trans('daily-reward::admin.settings.fields.enabled') }}</label>
                </div>

                <div class="row gx-3">
                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="resetModeSelect">{{ trans('daily-reward::admin.settings.fields.reset_mode') }}</label>
                        <select class="form-select @error('reset_mode') is-invalid @enderror" id="resetModeSelect" name="reset_mode" required>
                            <option value="midnight" @selected(old('reset_mode', $resetMode) === 'midnight')>
                                {{ trans('daily-reward::admin.settings.reset_modes.midnight') }}
                            </option>
                            <option value="rolling_24h" @selected(old('reset_mode', $resetMode) === 'rolling_24h')>
                                {{ trans('daily-reward::admin.settings.reset_modes.rolling_24h') }}
                            </option>
                        </select>
                        @error('reset_mode')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="cycleLengthInput">{{ trans('daily-reward::admin.settings.fields.cycle_length') }}</label>
                        <input type="number" min="1" max="365" class="form-control @error('cycle_length') is-invalid @enderror" id="cycleLengthInput" name="cycle_length" value="{{ old('cycle_length', $cycleLength) }}" required>
                        @error('cycle_length')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="defaultMoneyInput">{{ trans('daily-reward::admin.settings.fields.default_money') }}</label>
                        <input type="number" min="0" step="0.01" class="form-control @error('default_money') is-invalid @enderror" id="defaultMoneyInput" name="default_money" value="{{ old('default_money', $defaultMoney) }}" required>
                        @error('default_money')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="webhookInput">{{ trans('daily-reward::admin.settings.fields.webhook') }}</label>
                    <input type="url" class="form-control @error('webhook') is-invalid @enderror" id="webhookInput" name="webhook" value="{{ old('webhook', $webhook) }}" placeholder="https://discord.com/api/webhooks/.../...">
                    @error('webhook')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <div class="form-text">{{ trans('daily-reward::admin.settings.webhook_info') }}</div>
                </div>

                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="mailNotificationsSwitch" name="mail_notifications" @checked(old('mail_notifications', $mailNotifications))>
                    <label class="form-check-label" for="mailNotificationsSwitch">{{ trans('daily-reward::admin.settings.fields.mail_notifications') }}</label>
                    <div class="form-text">
                        {{ trans('daily-reward::admin.settings.mail_info') }}
                        <a href="{{ route('admin.settings.mail') }}">{{ trans('daily-reward::admin.settings.mail_link') }}</a>
                    </div>

                    @unless($mailEnabled)
                        <div class="text-warning mt-2">
                            <i class="bi bi-exclamation-triangle"></i> {{ trans('daily-reward::admin.settings.mail_disabled') }}
                        </div>
                    @endunless
                </div>

                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="leaderboardSwitch" name="public_leaderboard" @checked(old('public_leaderboard', $publicLeaderboard))>
                    <label class="form-check-label" for="leaderboardSwitch">{{ trans('daily-reward::admin.settings.fields.public_leaderboard') }}</label>
                    <div class="form-text">
                        {{ trans('daily-reward::admin.settings.public_leaderboard_info') }}
                        <a href="{{ route('daily-reward.leaderboard') }}" target="_blank" rel="noopener noreferrer">{{ trans('daily-reward::admin.settings.public_leaderboard_link') }}</a>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="syncRewardsCheckbox" name="sync_rewards" @checked(old('sync_rewards', false))>
                    <label class="form-check-label" for="syncRewardsCheckbox">{{ trans('daily-reward::admin.settings.fields.sync_rewards') }}</label>
                    <div class="form-text">{{ trans('daily-reward::admin.settings.sync_rewards_info') }}</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
