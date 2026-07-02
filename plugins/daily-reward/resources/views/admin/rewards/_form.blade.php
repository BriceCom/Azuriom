@csrf

<div class="row gx-3">
    <div class="mb-3 col-md-4">
        <label class="form-label" for="rewardDaySelect">{{ trans('daily-reward::messages.fields.day') }}</label>
        <select class="form-select @error('day_id') is-invalid @enderror" id="rewardDaySelect" name="day_id" required>
            @foreach($days as $day)
                <option value="{{ $day->id }}" @selected((string) old('day_id', $reward->day_id ?? '') === (string) $day->id)>
                    #{{ $day->day_number }} - {{ $day->label ?? trans('daily-reward::messages.day_label', ['day' => $day->day_number]) }}
                </option>
            @endforeach
        </select>
        @error('day_id')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-4">
        <label class="form-label" for="rewardNameInput">{{ trans('messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="rewardNameInput" name="name" value="{{ old('name', $reward->name ?? '') }}" maxlength="100" required>
        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-4">
        <label class="form-label" for="rewardTypeSelect">{{ trans('messages.fields.type') }}</label>
        <select class="form-select @error('type') is-invalid @enderror" id="rewardTypeSelect" name="type" required>
            <option value="{{ \Azuriom\Plugin\DailyReward\Models\DailyRewardReward::TYPE_MONEY }}" @selected(old('type', $reward->type ?? \Azuriom\Plugin\DailyReward\Models\DailyRewardReward::TYPE_MONEY) === \Azuriom\Plugin\DailyReward\Models\DailyRewardReward::TYPE_MONEY)>
                {{ trans('daily-reward::admin.rewards.types.money') }}
            </option>
            <option value="{{ \Azuriom\Plugin\DailyReward\Models\DailyRewardReward::TYPE_COMMAND }}" @selected(old('type', $reward->type ?? '') === \Azuriom\Plugin\DailyReward\Models\DailyRewardReward::TYPE_COMMAND)>
                {{ trans('daily-reward::admin.rewards.types.command') }}
            </option>
        </select>
        @error('type')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row gx-3">
    <div class="mb-3 col-md-4">
        <label class="form-label" for="rewardMoneyInput">{{ trans('messages.fields.money') }}</label>
        <div class="input-group @error('money') has-validation @enderror">
            <input type="number" min="0" step="0.01" class="form-control @error('money') is-invalid @enderror" id="rewardMoneyInput" name="money" value="{{ old('money', $reward->money ?? '') }}">
            <div class="input-group-text">{{ money_name() }}</div>
            @error('money')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="form-text">{{ trans('daily-reward::admin.rewards.money_info') }}</div>
    </div>

    <div class="mb-3 col-md-8">
        <label class="form-label" for="rewardServersSelect">{{ trans('daily-reward::admin.rewards.fields.servers') }}</label>
        <select class="form-select @error('servers') is-invalid @enderror" id="rewardServersSelect" name="servers[]" multiple>
            @foreach($servers as $server)
                <option value="{{ $server->id }}" @selected((collect(old('servers', isset($reward) ? $reward->servers->pluck('id')->all() : []))->contains($server->id)))>
                    {{ $server->name }}
                </option>
            @endforeach
        </select>
        @error('servers')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <div class="form-text">{{ trans('daily-reward::admin.rewards.servers_info') }}</div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">{{ trans('daily-reward::admin.rewards.fields.commands') }}</label>
    @include('admin.elements.list-input', ['name' => 'commands', 'values' => old('commands', $reward->commands ?? [])])
    @error('commands')
    <div class="text-danger"><small><strong>{{ $message }}</strong></small></div>
    @enderror
    <div class="form-text">
        @lang('daily-reward::admin.rewards.commands_info', ['placeholders' => '<code>{player}</code>, <code>{user}</code>, <code>{day}</code>, <code>{streak}</code>, <code>{reward}</code>'])
    </div>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="needOnlineSwitch" name="need_online" @checked(old('need_online', $reward->need_online ?? false))>
    <label class="form-check-label" for="needOnlineSwitch">{{ trans('daily-reward::admin.rewards.fields.need_online') }}</label>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="rewardEnabledSwitch" name="is_enabled" @checked(old('is_enabled', $reward->is_enabled ?? true))>
    <label class="form-check-label" for="rewardEnabledSwitch">{{ trans('daily-reward::admin.rewards.fields.enabled') }}</label>
</div>
