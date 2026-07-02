<div class="row g-3">
    <div class="mb-3 col-md-6">
        <label class="form-label" for="keyInput">{{ trans('shop::admin.gateways.public-key') }}</label>
        <input type="text" class="form-control @error('public-key') is-invalid @enderror" id="keyInput" name="public-key" value="{{ old('public-key', $gateway->data['public-key'] ?? '') }}" required>

        @error('public-key')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label" for="keyInput">{{ trans('shop::admin.gateways.private-key') }}</label>
        <input type="text" class="form-control @error('private-key') is-invalid @enderror" id="keyInput" name="private-key" value="{{ old('private-key', $gateway->data['private-key'] ?? '') }}" required>

        @error('private-key')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="alert alert-info">
    <p>
        <i class="bi bi-info-circle"></i>
        @lang('dedipasspayment::messages.setup', [
            'url' => '<code>'.route('home').'</code>',
            'ipn' => '<code>'.route('shop.payments.notification', 'dedipass').'</code>',
            'money' => money_name(1),
        ])
    </p>

    <a class="btn btn-primary mb-3" data-bs-toggle="collapse" href="#keysCollapse" role="button" aria-expanded="false" aria-controls="keysCollapse">
        <i class="bi bi-key"></i> {{ trans('dedipasspayment::messages.keys') }}
    </a>

    <div class="collapse" id="keysCollapse">
        <img src="https://azuriom.com/assets/img/docs/dedipass.png" alt="Dedipass" class="img-fluid rounded">
    </div>
</div>

@if(! use_site_money())
    <div class="alert alert-danger" role="alert">
        <i class="bi bi-exclamation-triangle"></i> @lang('dedipasspayment::messages.site_money', ['url' => route('shop.admin.settings')])
    </div>
@endif
