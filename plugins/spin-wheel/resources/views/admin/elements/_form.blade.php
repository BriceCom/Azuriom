@csrf

<div class="row">
    <div class="mb-3 col-sm-6 col-xl-4">
        <label class="form-label" for="nameInput">{{ trans('spin-wheel::admin.pages.rewards.form.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $reward->name ?? '') }}" required>

        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        
    </div>
    <div class="mb-3 col-sm-6 col-xl-4">
        <label class="form-label" for="colorInput">{{ trans('spin-wheel::admin.pages.rewards.form.color') }}</label>
        <input type="color" class="form-control form-control-color color-picker @error('color') is-invalid @enderror" id="colorInput" name="color" value="{{ old('color', $reward->color ?? '#2196f3') }}" required>

        @error('color')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="chancesInput">{{ trans('spin-wheel::admin.pages.rewards.form.chances') }}</label>

    <div class="input-group @error('chances') has-validation @enderror">
        <input type="number" class="form-control @error('chances') is-invalid @enderror" min="0" step="0.1" id="chancesInput" name="chances" value="{{ old('chances', $reward->chances ?? '0') }}" required>
        <div class="input-group-text">%</div>

        @error('chances')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="moneyInput">{{ trans('spin-wheel::admin.pages.rewards.form.money') }}</label>

    <div class="input-group @error('money') has-validation @enderror">
        <input type="number" class="form-control @error('money') is-invalid @enderror" min="0" step="0.01" id="moneyInput" name="money" value="{{ old('money', $reward->money ?? '') }}">
        <div class="input-group-text">{{ money_name() }}</div>

        @error('money')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
@if(($scratchGameEnabled ?? false) === true)
<div class="mb-3">
    <label class="form-label" for="scratchCardInput">{{ trans('spin-wheel::admin.pages.rewards.form.scratchCard') }}</label>
    <select class="form-select @error('scratch_card_id') is-invalid @enderror" id="scratchCardInput" name="scratch_card_id">
        <option value="">{{ trans('spin-wheel::admin.pages.rewards.form.scratchCardNone') }}</option>
        @foreach(($scratchCards ?? []) as $card)
            <option value="{{ $card->id }}" @selected(old('scratch_card_id', $reward->scratch_card_id ?? '') == $card->id)>{{ $card->name }}</option>
        @endforeach
    </select>
    <small class="form-text">@lang('spin-wheel::admin.pages.rewards.form.scratchCardDesc')</small>

    @error('scratch_card_id')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>
@endif
<div class="mb-3">
    <label for="">{{ trans('spin-wheel::admin.pages.rewards.form.servers') }}</label> 
    <select class="form-select" multiple size='2' name='servers_id[]'>
        @foreach($servers as $server)
            <option @selected(in_array($server->id, ((isset($reward) && $reward->getServers() !== null) ? $reward->getServers() : []) )) value="{{ $server->id }}">-> {{ $server->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label" for="commands">{{ trans('spin-wheel::admin.pages.rewards.form.commands') }}</label> 
       
    @include('admin.elements.list-input', ['name' => 'commands', 'values' => $reward->commands ?? []])

    <small class="form-text">@lang('spin-wheel::admin.pages.rewards.form.commandsDesc')</small>
</div>
<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="send_webhook" name="send_webhook" @checked(old('send_webhook', $reward->send_webhook ?? true))>
    <label class="form-check-label" for="send_webhook">{{ trans('spin-wheel::admin.pages.rewards.form.toogleWebhook') }}</label>
</div>
<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="needOnlineSwitch" name="need_online" @checked(old('need_online', $reward->need_online ?? true))>
    <label class="form-check-label" for="needOnlineSwitch">{{ trans('spin-wheel::admin.pages.rewards.form.toogleAzlink') }}</label>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="enableSwitch" name="is_enabled" @checked(old('is_enabled', $reward->is_enabled ?? true))>
    <label class="form-check-label" for="enableSwitch">{{ trans('spin-wheel::admin.pages.rewards.form.toogleEnable') }}</label>
</div>

<hr>

<div class="row mb-3">
    <div class="mb-3 col-sm-6 col-xl-4">
        <label class="form-label" for="textFontSize">{{ trans('spin-wheel::admin.pages.rewards.form.fontSize') }}</label>

        <div class="input-group @error('textFontSize') has-validation @enderror">
            <input type="number" class="form-control @error('textFontSize') is-invalid @enderror" id="textFontSize" min="1" name="textFontSize" value="{{ old('textFontSize', $reward->textFontSize ?? 28) }}">
            <div class="input-group-text">px</div>

            @error('textFontSize')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div> 
    </div>
    <div class="mb-3 col-sm-6 col-xl-4">
        <label class="form-label" for="textOrientation">{{ trans('spin-wheel::admin.pages.rewards.form.orientation') }}</label>
        <select class="form-control" id="textOrientation" required name="textOrientation">
            <option  @if(old('textDirection', $reward->textOrientation ?? '') == 'horizontal') selected @endif value='horizontal'>{{ trans('spin-wheel::admin.pages.rewards.form.horizontal') }}</option>
            <option  @if(old('textDirection', $reward->textOrientation ?? '') == 'vertical') selected @endif value='vertical'>{{ trans('spin-wheel::spin-wheel::admin.pages.rewards.form.vertical') }}</option>
            <option  @if(old('textDirection', $reward->textOrientation ?? '') == 'curved') selected @endif value='curved'>{{ trans('spin-wheel::spin-wheel::admin.pages.rewards.form.curved') }}</option>
        </select>
    </div>
    <div class="mb-3 col-sm-6 col-xl-4">
        <label class="form-label"required for="textDirection">{{ trans('spin-wheel::admin.pages.rewards.form.direction') }}</label>
        <select class="form-control" id="textDirection" name='textDirection'>
            <option @if(old('textDirection', $reward->textDirection ?? '') == 'normal') selected @endif value='normal'>{{ trans('spin-wheel::admin.pages.rewards.form.normal') }}</option>
            <option @if(old('textDirection', $reward->textDirection ?? '') == 'reversed') selected @endif value='reversed'>{{ trans('spin-wheel::admin.pages.rewards.form.reversed') }}</option>
        </select>
    </div>
</div>

@include('admin.elements.color-picker')
