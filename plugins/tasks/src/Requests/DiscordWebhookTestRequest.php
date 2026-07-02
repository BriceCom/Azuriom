<?php

namespace Azuriom\Plugin\Tasks\Requests;

class DiscordWebhookTestRequest extends TasksFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('tasks.settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'webhook_url' => ['required', 'url', 'max:2048'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'webhook_url' => trans('tasks::admin.settings.discord.webhook_url'),
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
            'webhook_url.required' => 'The webhook URL is required for testing.',
            'webhook_url.url' => 'The webhook URL must be a valid URL.',
            'webhook_url.max' => 'The webhook URL may not be greater than 2048 characters.',
        ];
    }
}
