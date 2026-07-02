@csrf

@include('admin.elements.color-picker')

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="serviceNameInput">{{ trans('webhook-manager::admin.services.fields.name') }}</label>
        <input type="text"
               class="form-control @error('name') is-invalid @enderror"
               id="serviceNameInput"
               name="name"
               value="{{ old('name', $service->name ?? '') }}"
               required>
        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="serviceTypeSelect">{{ trans('webhook-manager::admin.services.fields.type') }}</label>
        <select class="form-select @error('type') is-invalid @enderror" id="serviceTypeSelect" name="type" required>
            @foreach($types as $type => $label)
                <option value="{{ $type }}" @selected(old('type', $service->type ?? 'discord') === $type)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('type')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label" for="serviceUrlInput">{{ trans('webhook-manager::admin.services.fields.url') }}</label>
        <input type="url"
               class="form-control @error('url') is-invalid @enderror"
               id="serviceUrlInput"
               name="url"
               value="{{ old('url', $service->url ?? '') }}"
               placeholder="https://discord.com/api/webhooks/..."
               required>
        @error('url')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="serviceBotNameInput">{{ trans('webhook-manager::admin.services.fields.bot_name') }}</label>
        <input type="text"
               class="form-control @error('bot_name') is-invalid @enderror"
               id="serviceBotNameInput"
               name="bot_name"
               value="{{ old('bot_name', $service->bot_name ?? '') }}"
               placeholder="Webhook Bot">
        @error('bot_name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-5">
        <label class="form-label" for="serviceBotAvatarInput">{{ trans('webhook-manager::admin.services.fields.bot_avatar') }}</label>
        <input type="url"
               class="form-control @error('bot_avatar') is-invalid @enderror"
               id="serviceBotAvatarInput"
               name="bot_avatar"
               value="{{ old('bot_avatar', $service->bot_avatar ?? '') }}"
               placeholder="https://example.com/avatar.png">
        @error('bot_avatar')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="serviceDefaultColorInput">{{ trans('webhook-manager::admin.services.fields.default_color') }}</label>
        <input type="color"
               class="form-control form-control-color color-picker @error('default_color') is-invalid @enderror"
               id="serviceDefaultColorInput"
               name="default_color"
               value="{{ old('default_color', $service->default_color ?: '#5865F2') }}">
        @error('default_color')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-12 form-text">
        {{ trans('webhook-manager::admin.services.identity_help') }}
    </div>
</div>
