@csrf

<div class="row gx-3">
    <div class="mb-3 col-md-4">
        <label class="form-label" for="dayNumberInput">{{ trans('daily-reward::messages.fields.day') }}</label>
        <input type="number" min="1" max="365" class="form-control @error('day_number') is-invalid @enderror" id="dayNumberInput" name="day_number" value="{{ old('day_number', $day->day_number ?? '') }}" required>

        @error('day_number')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-8">
        <label class="form-label" for="dayLabelInput">{{ trans('daily-reward::messages.fields.label') }}</label>
        <input type="text" class="form-control @error('label') is-invalid @enderror" id="dayLabelInput" name="label" value="{{ old('label', $day->label ?? '') }}" maxlength="100">

        @error('label')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="dayEnabledSwitch" name="is_enabled" @checked(old('is_enabled', $day->is_enabled ?? true))>
    <label class="form-check-label" for="dayEnabledSwitch">{{ trans('daily-reward::admin.days.fields.enabled') }}</label>
</div>
