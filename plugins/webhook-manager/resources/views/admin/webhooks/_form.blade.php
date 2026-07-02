@csrf

@php
    $currentPayload = $webhook->payload_template ?? ['content' => trans('webhook-manager::admin.webhooks.default_payload_content')];
    $payloadTemplate = old('payload_template', json_encode($currentPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    $payloadExamples = $payloadExamplesByEvent ?? [];
    $headersRows = old('headers', $headerRows ?? [['name' => '', 'value' => '']]);
    $selectedServiceId = (int) old('service_id', $webhook->service_id ?? 0);
    $hasServices = $services->isNotEmpty();
    $servicesPayload = $services->map(fn ($service) => [
        'id' => (int) $service->id,
        'name' => $service->name,
        'type' => $service->type,
        'type_label' => trans('webhook-manager::admin.services.types.'.$service->type),
        'url' => $service->url,
        'bot_name' => $service->bot_name,
        'bot_avatar' => $service->bot_avatar,
        'default_color' => $service->default_color,
    ])->values()->all();

    if (! is_array($headersRows) || $headersRows === []) {
        $headersRows = [['name' => '', 'value' => '']];
    }
@endphp

@if(! $hasServices)
    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle"></i>
        {{ trans('webhook-manager::admin.webhooks.no_service') }}
        <a href="{{ route('webhook-manager.admin.services.create') }}" class="alert-link">
            {{ trans('webhook-manager::admin.services.create') }}
        </a>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="nameInput">{{ trans('webhook-manager::admin.webhooks.fields.name') }}</label>
        <input type="text"
               class="form-control @error('name') is-invalid @enderror"
               id="nameInput"
               name="name"
               value="{{ old('name', $webhook->name ?? '') }}"
               required>
        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="serviceSelect">{{ trans('webhook-manager::admin.webhooks.fields.service') }}</label>
        <select class="form-select @error('service_id') is-invalid @enderror"
                id="serviceSelect"
                name="service_id"
                @disabled(! $hasServices)
                required>
            <option value="" @selected($selectedServiceId === 0)>{{ trans('webhook-manager::admin.webhooks.select_service') }}</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}" @selected($selectedServiceId === $service->id)>
                    {{ $service->name }} ({{ trans('webhook-manager::admin.services.types.'.$service->type) }})
                </option>
            @endforeach
        </select>
        @error('service_id')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <div class="form-text">{{ trans('webhook-manager::admin.webhooks.service_help') }}</div>
    </div>

    <div class="col-md-6">
        <label class="form-label" for="eventSelect">{{ trans('webhook-manager::admin.webhooks.fields.event') }}</label>
        <select class="form-select @error('event') is-invalid @enderror" id="eventSelect" name="event" required>
            @foreach($events as $event => $metadata)
                <option value="{{ $event }}" @selected(old('event', $webhook->event ?? 'user.registered') === $event)>
                    {{ $metadata['label'] }}
                </option>
            @endforeach
        </select>
        @error('event')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">{{ trans('webhook-manager::admin.webhooks.service_preview') }}</label>
        <div id="servicePreviewNone" class="border rounded p-3 text-muted small">
            {{ trans('webhook-manager::admin.webhooks.select_service_preview') }}
        </div>

        <div id="servicePreviewCard" class="card d-none">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="" alt="" id="serviceAvatar" class="rounded-circle d-none" width="44" height="44">
                    <div>
                        <div class="fw-semibold" id="serviceName"></div>
                        <div class="small text-muted" id="serviceType"></div>
                    </div>
                </div>

                <div class="small mb-1">
                    <strong>{{ trans('webhook-manager::admin.services.fields.url') }}:</strong>
                    <span id="serviceUrl"></span>
                </div>

                <div class="small mb-1">
                    <strong>{{ trans('webhook-manager::admin.services.fields.bot_name') }}:</strong>
                    <span id="serviceBotName">-</span>
                </div>

                <div class="small d-flex align-items-center gap-2">
                    <strong>{{ trans('webhook-manager::admin.services.fields.default_color') }}:</strong>
                    <span id="serviceColorText">-</span>
                    <span id="serviceColorSwatch" class="border rounded-circle d-inline-block d-none" style="width: 14px; height: 14px;"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <label class="form-label" for="timeoutInput">{{ trans('webhook-manager::admin.webhooks.fields.timeout') }}</label>
        <input type="number"
               class="form-control @error('timeout') is-invalid @enderror"
               id="timeoutInput"
               name="timeout"
               value="{{ old('timeout', $webhook->timeout ?? 5) }}"
               min="1"
               max="30"
               required>
        @error('timeout')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label" for="secretInput">{{ trans('webhook-manager::admin.webhooks.fields.secret') }}</label>
        <div class="input-group">
            <input type="text"
                   class="form-control @error('secret') is-invalid @enderror"
                   id="secretInput"
                   name="secret"
                   value="{{ old('secret', $webhook->secret ?? '') }}"
                   autocomplete="off">
            <button class="btn btn-outline-secondary" type="button" id="generateSecret">
                {{ trans('webhook-manager::admin.webhooks.generate_secret') }}
            </button>
            @error('secret')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="form-text">{{ trans('webhook-manager::admin.webhooks.secret_help') }}</div>
        <details class="small mt-2">
            <summary>{{ trans('webhook-manager::admin.webhooks.secret_example_title') }}</summary>
            <pre class="mb-0">X-Webhook-Signature: 0f3c6c9d1e8b...
hash_hmac('sha256', $rawBody, $secret)</pre>
        </details>
    </div>

    <div class="col-12">
        <label class="form-label" for="payloadTemplateInput">{{ trans('webhook-manager::admin.webhooks.fields.payload_template') }}</label>
        <textarea class="form-control font-monospace @error('payload_template') is-invalid @enderror"
                  id="payloadTemplateInput"
                  name="payload_template"
                  rows="12"
                  required>{{ $payloadTemplate }}</textarea>
        @error('payload_template')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <div class="form-text">{{ trans('webhook-manager::admin.webhooks.payload_help') }}</div>
        <div class="form-text mt-1">{{ trans('webhook-manager::admin.webhooks.variables_help') }}</div>
        <div class="small font-monospace" id="eventVariablesHelp"></div>

        <div class="card mt-2 border">
            <div class="card-body p-3 small">
                <div class="fw-semibold mb-2">{{ trans('webhook-manager::admin.webhooks.payload_helper_title') }}</div>
                <p class="text-muted mb-2">{{ trans('webhook-manager::admin.webhooks.payload_helper_intro') }}</p>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="insertEventPayloadExample">
                        <i class="bi bi-magic"></i> {{ trans('webhook-manager::admin.webhooks.payload_helper_use_event_example') }}
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="beautifyPayloadJson">
                        <i class="bi bi-braces"></i> {{ trans('webhook-manager::admin.webhooks.payload_helper_format_json') }}
                    </button>
                </div>

                <div class="mb-2">
                    <strong>{{ trans('webhook-manager::admin.webhooks.payload_helper_current_example') }}</strong>
                    <pre class="mb-0 mt-1 bg-body-tertiary p-2 rounded"><code id="eventPayloadExamplePreview"></code></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <label class="form-label">{{ trans('webhook-manager::admin.webhooks.fields.headers') }}</label>
        <div id="headers-container" data-next-index="{{ count($headersRows) }}">
            @foreach($headersRows as $i => $header)
                <div class="row g-2 mb-2 header-row">
                    <div class="col-md-5">
                        <input type="text"
                               class="form-control"
                               name="headers[{{ $i }}][name]"
                               placeholder="{{ trans('webhook-manager::admin.webhooks.fields.header_name') }}"
                               value="{{ $header['name'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <input type="text"
                               class="form-control"
                               name="headers[{{ $i }}][value]"
                               placeholder="{{ trans('webhook-manager::admin.webhooks.fields.header_value') }}"
                               value="{{ $header['value'] ?? '' }}">
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="button" class="btn btn-outline-danger remove-header" title="{{ trans('messages.actions.delete') }}">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary" id="add-header">
            <i class="bi bi-plus-lg"></i> {{ trans('webhook-manager::admin.webhooks.add_header') }}
        </button>
        @error('headers')
        <div class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></div>
        @enderror
        <div class="form-text">{{ trans('webhook-manager::admin.webhooks.headers_help') }}</div>
        <details class="small mt-2">
            <summary>{{ trans('webhook-manager::admin.webhooks.headers_example_title') }}</summary>
            <pre class="mb-0">Authorization: Bearer sk_live_xxx
X-Server-Key: 123456
Content-Type: application/json</pre>
        </details>
    </div>

    <div class="col-12 form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="activeSwitch" name="is_active" @checked(old('is_active', $webhook->is_active ?? true))>
        <label class="form-check-label" for="activeSwitch">{{ trans('webhook-manager::admin.webhooks.fields.status') }}</label>
    </div>
</div>

@push('footer-scripts')
    <script>
        (() => {
            const serviceMap = Object.fromEntries((@json($servicesPayload)).map((service) => [String(service.id), service]));
            const serviceSelect = document.getElementById('serviceSelect');
            const servicePreviewNone = document.getElementById('servicePreviewNone');
            const servicePreviewCard = document.getElementById('servicePreviewCard');
            const serviceAvatar = document.getElementById('serviceAvatar');
            const serviceName = document.getElementById('serviceName');
            const serviceType = document.getElementById('serviceType');
            const serviceUrl = document.getElementById('serviceUrl');
            const serviceBotName = document.getElementById('serviceBotName');
            const serviceColorText = document.getElementById('serviceColorText');
            const serviceColorSwatch = document.getElementById('serviceColorSwatch');

            function renderServicePreview() {
                const selected = serviceMap[String(serviceSelect.value)];

                if (selected === undefined) {
                    servicePreviewNone.classList.remove('d-none');
                    servicePreviewCard.classList.add('d-none');
                    return;
                }

                serviceName.textContent = selected.name;
                serviceType.textContent = selected.type_label;
                serviceUrl.textContent = selected.url;
                serviceBotName.textContent = selected.bot_name || '-';

                if (selected.bot_avatar) {
                    serviceAvatar.src = selected.bot_avatar;
                    serviceAvatar.alt = selected.name;
                    serviceAvatar.classList.remove('d-none');
                } else {
                    serviceAvatar.classList.add('d-none');
                    serviceAvatar.removeAttribute('src');
                }

                if (selected.default_color) {
                    serviceColorText.textContent = selected.default_color;
                    serviceColorSwatch.style.backgroundColor = selected.default_color;
                    serviceColorSwatch.classList.remove('d-none');
                } else {
                    serviceColorText.textContent = '-';
                    serviceColorSwatch.classList.add('d-none');
                }

                servicePreviewNone.classList.add('d-none');
                servicePreviewCard.classList.remove('d-none');
            }

            if (serviceSelect !== null) {
                serviceSelect.addEventListener('change', renderServicePreview);
                renderServicePreview();
            }

            const eventVariablesMap = @json($variablesByEvent);
            const payloadExamplesByEvent = @json($payloadExamples);
            const eventSelect = document.getElementById('eventSelect');
            const variablesHelp = document.getElementById('eventVariablesHelp');
            const emptyVariablesText = @json(trans('webhook-manager::admin.webhooks.no_variables'));
            const payloadInput = document.getElementById('payloadTemplateInput');
            const eventPayloadExamplePreview = document.getElementById('eventPayloadExamplePreview');
            const insertEventPayloadExampleButton = document.getElementById('insertEventPayloadExample');
            const beautifyPayloadJsonButton = document.getElementById('beautifyPayloadJson');
            const invalidJsonMessage = @json(trans('webhook-manager::admin.webhooks.payload_invalid_json'));
            const formattedJsonMessage = @json(trans('webhook-manager::admin.webhooks.payload_formatted'));

            function notify(type, message) {
                if (typeof createAlert === 'function') {
                    createAlert(type, message, true);
                    return;
                }

                window.alert(message);
            }

            function prettyJson(value) {
                return JSON.stringify(value, null, 2);
            }

            function currentEventPayloadExample() {
                return payloadExamplesByEvent[eventSelect.value]
                    || payloadExamplesByEvent['custom.*']
                    || {};
            }

            function renderEventPayloadExample() {
                eventPayloadExamplePreview.textContent = prettyJson(currentEventPayloadExample());
            }

            function renderVariables() {
                const selectedEvent = eventSelect.value;
                const variables = eventVariablesMap[selectedEvent] || [];

                if (variables.length === 0) {
                    variablesHelp.textContent = emptyVariablesText;
                    return;
                }

                variablesHelp.textContent = variables.map((variable) => `{${variable}}`).join('  ');
            }

            eventSelect.addEventListener('change', renderVariables);
            eventSelect.addEventListener('change', renderEventPayloadExample);
            renderVariables();
            renderEventPayloadExample();

            insertEventPayloadExampleButton.addEventListener('click', () => {
                payloadInput.value = prettyJson(currentEventPayloadExample());
            });

            beautifyPayloadJsonButton.addEventListener('click', () => {
                try {
                    const parsed = JSON.parse(payloadInput.value);
                    payloadInput.value = prettyJson(parsed);
                    notify('success', formattedJsonMessage);
                } catch (error) {
                    notify('danger', invalidJsonMessage);
                }
            });

            const headersContainer = document.getElementById('headers-container');
            const addHeaderButton = document.getElementById('add-header');
            const headerNamePlaceholder = @json(trans('webhook-manager::admin.webhooks.fields.header_name'));
            const headerValuePlaceholder = @json(trans('webhook-manager::admin.webhooks.fields.header_value'));
            let headerIndex = Number(headersContainer.dataset.nextIndex || 0);

            function addHeaderRow(name = '', value = '') {
                const row = document.createElement('div');
                row.className = 'row g-2 mb-2 header-row';
                row.innerHTML = `
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="headers[${headerIndex}][name]" placeholder="${headerNamePlaceholder}" value="${name}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="headers[${headerIndex}][value]" placeholder="${headerValuePlaceholder}" value="${value}">
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="button" class="btn btn-outline-danger remove-header" title="{{ trans('messages.actions.delete') }}">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                `;

                headerIndex += 1;
                headersContainer.appendChild(row);
            }

            addHeaderButton.addEventListener('click', () => addHeaderRow());

            headersContainer.addEventListener('click', (event) => {
                const button = event.target.closest('.remove-header');

                if (button === null) {
                    return;
                }

                const row = button.closest('.header-row');

                if (row !== null) {
                    row.remove();
                }
            });

            const secretInput = document.getElementById('secretInput');
            const generateSecretButton = document.getElementById('generateSecret');
            const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

            generateSecretButton.addEventListener('click', () => {
                let secret = '';

                for (let i = 0; i < 32; i += 1) {
                    const randomIndex = Math.floor(Math.random() * alphabet.length);
                    secret += alphabet[randomIndex];
                }

                secretInput.value = secret;
            });
        })();
    </script>
@endpush
