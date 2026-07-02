<?php

namespace Azuriom\Plugin\Tasks\Requests;

class DiscordWebhookRequest extends TasksFormRequest
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
            'discord_enabled' => ['boolean'],
            'discord_webhook_url' => ['nullable', 'url', 'max:2048'],
            'discord_webhook_url_created' => ['nullable', 'url', 'max:2048'],
            'discord_webhook_url_started' => ['nullable', 'url', 'max:2048'],
            'discord_webhook_url_completed' => ['nullable', 'url', 'max:2048'],
            'discord_webhook_url_archived' => ['nullable', 'url', 'max:2048'],
            'discord_webhook_url_comment' => ['nullable', 'url', 'max:2048'],
            'discord_webhook_url_logs' => ['nullable', 'url', 'max:2048'],
            'discord_send_on_created' => ['boolean'],
            'discord_send_on_started' => ['boolean'],
            'discord_send_on_completed' => ['boolean'],
            'discord_send_on_archived' => ['boolean'],
            'discord_send_on_comment' => ['boolean'],
            'discord_send_on_logs' => ['boolean'],
            'discord_color_created' => ['nullable', 'string', 'max:7'],
            'discord_color_started' => ['nullable', 'string', 'max:7'],
            'discord_color_completed' => ['nullable', 'string', 'max:7'],
            'discord_color_archived' => ['nullable', 'string', 'max:7'],
            'discord_color_comment' => ['nullable', 'string', 'max:7'],
            'discord_color_logs' => ['nullable', 'string', 'max:7'],
            'discord_template_created' => ['nullable', 'string', 'max:2000'],
            'discord_template_started' => ['nullable', 'string', 'max:2000'],
            'discord_template_completed' => ['nullable', 'string', 'max:2000'],
            'discord_template_archived' => ['nullable', 'string', 'max:2000'],
            'discord_template_comment' => ['nullable', 'string', 'max:2000'],
            'discord_template_logs' => ['nullable', 'string', 'max:2000'],
            'discord_custom_username' => ['nullable', 'string', 'max:80'],
            'discord_custom_avatar_url' => ['nullable', 'url', 'max:2048'],
            'discord_show_author' => ['boolean'],
            'discord_show_assignees' => ['boolean'],
            'discord_show_tags' => ['boolean'],
            'discord_show_description' => ['boolean'],
            'discord_description_length' => ['integer', 'min:10', 'max:2000'],
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
            'discord_webhook_url.url' => 'The webhook URL must be a valid URL.',
            'discord_webhook_url.max' => 'The webhook URL may not be greater than 2048 characters.',
            'discord_webhook_url_*.url' => 'The webhook URL must be a valid URL.',
            'discord_webhook_url_*.max' => 'The webhook URL may not be greater than 2048 characters.',
            'discord_color_*.max' => 'The color code must be a valid hex color (e.g., #00ff00).',
            'discord_template_*.max' => 'The template message may not be greater than 2000 characters.',
            'discord_custom_username.max' => 'The custom username may not be greater than 80 characters.',
            'discord_custom_avatar_url.url' => 'The custom avatar URL must be a valid URL.',
            'discord_custom_avatar_url.max' => 'The custom avatar URL may not be greater than 2048 characters.',
            'discord_description_length.min' => 'The description length must be at least 10 characters.',
            'discord_description_length.max' => 'The description length may not be greater than 2000 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {

        $this->merge([
            'discord_enabled' => $this->has('discord_enabled'),
            'discord_send_on_created' => $this->has('discord_send_on_created'),
            'discord_send_on_started' => $this->has('discord_send_on_started'),
            'discord_send_on_completed' => $this->has('discord_send_on_completed'),
            'discord_send_on_archived' => $this->has('discord_send_on_archived'),
            'discord_send_on_comment' => $this->has('discord_send_on_comment'),
            'discord_send_on_logs' => $this->has('discord_send_on_logs'),
            'discord_show_author' => $this->has('discord_show_author'),
            'discord_show_assignees' => $this->has('discord_show_assignees'),
            'discord_show_tags' => $this->has('discord_show_tags'),
            'discord_show_description' => $this->has('discord_show_description'),
            'discord_description_length' => $this->input('discord_description_length') ?: 200,
        ]);
    }
}
