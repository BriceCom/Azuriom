@extends('admin.layouts.admin')

@section('title', trans('spin-wheel::admin.pages.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <h4>{{ trans('spin-wheel::admin.pages.settings.general.title') }}</h4>
            <form class="mb-3" action="{{ route('spin-wheel.admin.settings.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-sm-6 col-xl-4">
                        <label class="form-label"
                            for="price">{{ trans('spin-wheel::admin.pages.settings.general.forms.price') }}</label>

                        <div class="input-group @error('price') has-validation @enderror">
                            <input type="number" class="form-control" id='price' name='price' placeholder="10"
                                min='0' step="0.5" value="{{ old('price', setting('spin.price', '')) }}">
                            <span class="input-group-text">{{ money_name() }}</span>
                        </div>
                        <small
                            class="form-text">{{ trans('spin-wheel::admin.pages.settings.general.forms.priceDesc') }}</small>

                        @error('price')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <label class="form-label"
                            for="delay">{{ trans('spin-wheel::admin.pages.settings.general.forms.delay') }}</label>

                        <div class="input-group @error('delay') has-validation @enderror">
                            <input type="number" class="form-control" id='delay' name='delay' placeholder="120"
                                min='0' step="1" value="{{ old('delay', setting('spin.delay', '')) }}">
                            <span class="input-group-text">Minutes</span>
                        </div>

                        <small
                            class="form-text">{{ trans('spin-wheel::admin.pages.settings.general.forms.delayDesc') }}</small>
                        @error('delay')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <label class="form-label"
                            for="homeWins">{{ trans('spin-wheel::admin.pages.settings.general.forms.displayPlayers') }}</label>

                        <div class="@error('homeWins') has-validation @enderror">
                            <input type="number" class="form-control" id='homeWins' name='homeWins' placeholder="10"
                                min='0' step="1"
                                value="{{ old('homeWins', setting('spin.homeWins', '10')) }}">
                        </div>
                        <small
                            class="form-text">{{ trans('spin-wheel::admin.pages.settings.general.forms.displayPlayersInfo') }}</small>
                        @error('homeWins')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6 col-xl-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="homePercentage" name="homePercentage"
                                @if (displayPercentage()) checked @endif>
                            <label class="form-check-label"
                                for="homePercentage">{{ trans('spin-wheel::admin.pages.settings.general.forms.tooglePercentage') }}</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="ordering" name="ordering"
                                @if (setting('spin.ordering', 1)) checked @endif>
                            <label class="form-check-label"
                                for="ordering">{{ trans('spin-wheel::admin.pages.settings.general.forms.ordering') }}</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="proportionalWheel" name="proportionalWheel"
                                @if (setting('spin.proportionalWheel', 0)) checked @endif>
                            <label class="form-check-label"
                                for="proportionalWheel">{{ trans('spin-wheel::admin.pages.settings.general.forms.proportionalWheel') }}</label>
                        </div>
                    </div>
                </div>
                <hr>
                <h4>{{ trans('spin-wheel::admin.pages.settings.freeSpin.title') }}</h4>
                <div class="row mb-3">
                    <div class="col-sm-6 col-xl-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="freeSpin" name="freeSpin"
                                @if (setting('spin.freeSpin', 1)) checked @endif>
                            <label class="form-check-label"
                                for="freeSpin">{{ trans('spin-wheel::admin.pages.settings.freeSpin.forms.toogleFreeSpin') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xl-4">
                        <label class="form-label"
                            for="freeSpinDelay">{{ trans('spin-wheel::admin.pages.settings.freeSpin.forms.delay') }}</label>

                        <div class="input-group @error('freeSpinDelay') has-validation @enderror">
                            <input type="number" class="form-control" id='freeSpinDelay' name='freeSpinDelay'
                                min='0' step="1"
                                value="{{ old('freeSpinDelay', setting('spin.freeSpin.delay', '120')) }}">
                            <span class="input-group-text">Minutes</span>
                        </div>
                        @error('freeSpinDelay')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <hr>
                <div id="webhook">
                    <h4 class="mb-3">{{ trans('spin-wheel::admin.pages.settings.webhook.title') }}</h4>
                    <div class="row mb-3">
                        <label class="form-label"
                            for="webhookUrl">{{ trans('spin-wheel::admin.pages.settings.webhook.forms.url') }}</label>

                        <div class="input-group @error('webhookUrl') has-validation @enderror">
                            <input type="url" class="form-control" id='webhookUrl' name='webhookUrl'
                                value="{{ old('webhookUrl', setting('spin.webhookUrl', '')) }}">
                        </div>

                        @error('webhookUrl')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label"
                                for="webhookTitle">{{ trans('spin-wheel::admin.pages.settings.webhook.forms.title') }}</label>

                            <div class="input-group @error('webhookTitle') has-validation @enderror">
                                <input type="text" class="form-control" id='webhookTitle' name='webhookTitle'
                                    value="{{ old('webhookTitle', setting('spin.webhookTitle', trans('spin-wheel::admin.webhook.title'))) }}">
                            </div>

                            @error('webhookTitle')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label"
                                for="webhookDesc">{{ trans('spin-wheel::admin.pages.settings.webhook.forms.desc') }}</label>

                            <div class="input-group @error('webhookDesc') has-validation @enderror">
                                <input type="text" class="form-control" id='webhookDesc' name='webhookDesc'
                                    value="{{ old('webhookDesc', setting('spin.webhookDesc', trans('spin-wheel::admin.webhook.description'))) }}">
                            </div>

                            @error('webhookDesc')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label"
                                for="webhookFooter">{{ trans('spin-wheel::admin.pages.settings.webhook.forms.footer') }}</label>

                            <div class="input-group @error('webhookFooter') has-validation @enderror">
                                <input type="text" class="form-control" id='webhookFooter' name='webhookFooter'
                                    value="{{ old('webhookFooter', setting('spin.webhookFooter', trans('spin-wheel::admin.webhook.footer'))) }}">
                            </div>

                            @error('webhookFooter')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="my-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="webhookSkin" name="webhookSkin"
                                @checked(old('webhookSkin', setting('spin.webhookSkin', 1) == 1))>
                            <label class="form-check-label"
                                for="webhookSkin">{{ trans('spin-wheel::admin.pages.settings.webhook.forms.toogleSkin') }}</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="webhookFooterDate"
                                name="webhookFooterDate" @checked(old('webhookFooterDate', setting('spin.webhookFooterDate', 1) == 1))>
                            <label class="form-check-label"
                                for="webhookFooterDate">{{ trans('spin-wheel::admin.pages.settings.webhook.forms.toogleDate') }}</label>
                        </div>
                    </div>
                    <h5>{{ trans('spin-wheel::admin.pages.settings.webhook.placeholders.title') }}</h5>
                    <ul>
                        <li>
                            <h4>@lang('spin-wheel::admin.pages.settings.webhook.placeholders.player')</h4>
                        </li>
                        <li>
                            <h4>@lang('spin-wheel::admin.pages.settings.webhook.placeholders.reward')</h4>
                        </li>
                        <li>
                            <h4>@lang('spin-wheel::admin.pages.settings.webhook.placeholders.siteName')</h4>
                        </li>
                    </ul>
                    <span>@lang('spin-wheel::admin.pages.settings.webhook.placeholders.markdown')</span>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <button type="button" class="btn btn-success" onclick='sendWebhook()' id="#sendWebhook"><i
                        class="bi bi-send"></i> Send Webhook</button>
            </form>
            <small>@lang('spin-wheel::admin.permission.required')</small>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        const selectElement = document.querySelector('#webhook');
        selectElement.addEventListener('keyup', (event) => {
            document.getElementById("#sendWebhook").disabled = true;
        });

        function sendWebhook() {
            if (!document.getElementById("#sendWebhook").disabled == true) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState != 4) return;

                    if (this.status == 200) {
                        window.location = window.location
                    }
                };
                xhr.open("GET", "{{ route('spin-wheel.admin.send-webhook') . '?test' }}", true);
                xhr.send();
            }
        }
    </script>
@endpush
