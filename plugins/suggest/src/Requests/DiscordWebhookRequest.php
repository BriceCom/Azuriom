<?php

namespace Azuriom\Plugin\Suggest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscordWebhookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('suggest.settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'webhook_url' => ['nullable', 'url', 'max:2048'],
            'enabled' => ['boolean'],
            'send_on_create' => ['boolean'],
            'send_on_accept' => ['boolean'],
            'send_on_refuse' => ['boolean'],

            // Color customization
            'color_created' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_accepted' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_refused' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],

            // Template customization
            'template_created' => ['nullable', 'string', 'max:4000'],
            'template_accepted' => ['nullable', 'string', 'max:4000'],
            'template_refused' => ['nullable', 'string', 'max:4000'],

            // Webhook appearance
            'custom_username' => ['nullable', 'string', 'max:80'],
            'custom_avatar_url' => ['nullable', 'url', 'max:2048'],

            // Display options
            'show_author' => ['boolean'],
            'show_category' => ['boolean'],
            'show_votes' => ['boolean'],
            'show_description' => ['boolean'],

            // Advanced settings
            'description_length' => ['nullable', 'integer', 'min:50', 'max:4000'],
            'custom_variables' => ['nullable', 'array'],
            'custom_variables.*' => ['string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'webhook_url.url' => 'The webhook URL must be a valid URL.',
            'webhook_url.max' => 'The webhook URL may not be greater than 2048 characters.',
            'color_created.regex' => 'The created color must be a valid hex color (e.g., #00ff00).',
            'color_accepted.regex' => 'The accepted color must be a valid hex color (e.g., #0099ff).',
            'color_refused.regex' => 'The refused color must be a valid hex color (e.g., #ff0000).',
            'template_created.max' => 'The created template may not be greater than 4000 characters.',
            'template_accepted.max' => 'The accepted template may not be greater than 4000 characters.',
            'template_refused.max' => 'The refused template may not be greater than 4000 characters.',
            'custom_username.max' => 'The custom username may not be greater than 80 characters.',
            'custom_avatar_url.url' => 'The custom avatar URL must be a valid URL.',
            'custom_avatar_url.max' => 'The custom avatar URL may not be greater than 2048 characters.',
            'description_length.min' => 'The description length must be at least 50 characters.',
            'description_length.max' => 'The description length may not be greater than 4000 characters.',
            'custom_variables.*.max' => 'Each custom variable may not be greater than 500 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'enabled' => $this->has('enabled'),
            'send_on_create' => $this->has('send_on_create'),
            'send_on_accept' => $this->has('send_on_accept'),
            'send_on_refuse' => $this->has('send_on_refuse'),
            'show_author' => $this->has('show_author'),
            'show_category' => $this->has('show_category'),
            'show_votes' => $this->has('show_votes'),
            'show_description' => $this->has('show_description'),
            'description_length' => $this->input('description_length') ?: 200,
        ]);
    }
}
