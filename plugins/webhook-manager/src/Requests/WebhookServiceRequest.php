<?php

namespace Azuriom\Plugin\WebhookManager\Requests;

use Azuriom\Plugin\WebhookManager\Models\WebhookService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WebhookServiceRequest extends FormRequest
{
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
            'type' => ['required', 'string', Rule::in(WebhookService::types())],
            'url' => ['required', 'string', 'url', 'max:2048'],
            'bot_name' => ['nullable', 'string', 'max:80'],
            'bot_avatar' => ['nullable', 'string', 'url', 'max:2048'],
            'default_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'bot_name' => blank($this->input('bot_name')) ? null : $this->input('bot_name'),
            'bot_avatar' => blank($this->input('bot_avatar')) ? null : $this->input('bot_avatar'),
            'default_color' => blank($this->input('default_color')) ? null : $this->input('default_color'),
        ]);
    }
}
