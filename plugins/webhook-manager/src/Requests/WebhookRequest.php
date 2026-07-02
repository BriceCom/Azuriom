<?php

namespace Azuriom\Plugin\WebhookManager\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Azuriom\Plugin\WebhookManager\Services\EventRegistry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class WebhookRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'is_active',
    ];

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'service_id' => ['required', 'integer', 'exists:webhook_manager_webhook_services,id'],
            'event' => ['required', 'string', 'max:120', function (string $attribute, mixed $value, \Closure $fail) {
                if (! is_string($value)) {
                    $fail(trans('webhook-manager::admin.webhooks.invalid_event'));

                    return;
                }

                if (! app(EventRegistry::class)->has($value)) {
                    $fail(trans('webhook-manager::admin.webhooks.invalid_event'));
                }
            }],
            'payload_template' => ['required', 'string', 'json', function (string $attribute, mixed $value, \Closure $fail) {
                if (! is_string($value)) {
                    $fail(trans('validation.json', ['attribute' => $attribute]));

                    return;
                }

                $decoded = json_decode($value, true);

                if (! is_array($decoded)) {
                    $fail(trans('webhook-manager::admin.webhooks.payload_structure'));
                }
            }],
            'headers' => ['nullable', 'array'],
            'headers.*.name' => ['nullable', 'string', 'max:100'],
            'headers.*.value' => ['nullable', 'string', 'max:1000'],
            'secret' => ['nullable', 'string', 'max:255'],
            'timeout' => ['nullable', 'integer', 'min:1', 'max:30'],
            'is_active' => ['filled', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();

        if (! $this->filled('timeout')) {
            $this->merge(['timeout' => 5]);
        }
    }

    /**
     * Get the validated data from the request.
     *
     * @param  array<int, string>|int|string|null  $key
     * @param  mixed  $default
     * @return mixed
     *
     * @throws \JsonException
     */
    public function validated($key = null, $default = null): mixed
    {
        $validated = $this->validator->validated();

        $validated['payload_template'] = json_decode(
            Arr::get($validated, 'payload_template', '{}'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $validated['service_id'] = (int) Arr::get($validated, 'service_id');
        $validated['headers'] = $this->normalizeHeaders(Arr::get($validated, 'headers', []));
        $validated['secret'] = blank(Arr::get($validated, 'secret')) ? null : Arr::get($validated, 'secret');
        $validated['timeout'] = (int) Arr::get($validated, 'timeout', 5);

        return data_get($validated, $key, $default);
    }

    /**
     * Convert the headers repeater payload into an associative array.
     *
     * @param  array<int, array{name?: string, value?: string}>  $headers
     * @return array<string, string>|null
     */
    protected function normalizeHeaders(array $headers): ?array
    {
        $normalized = [];

        foreach ($headers as $header) {
            $key = trim((string) Arr::get($header, 'name'));
            $value = trim((string) Arr::get($header, 'value'));

            if ($key === '' || $value === '') {
                continue;
            }

            $normalized[$key] = $value;
        }

        return $normalized !== [] ? $normalized : null;
    }
}
