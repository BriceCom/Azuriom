<?php

namespace Azuriom\Plugin\DailyReward\Requests\Admin;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;

class DailyRewardSettingsRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'enabled',
        'mail_notifications',
        'public_leaderboard',
        'sync_rewards',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'enabled' => ['filled', 'boolean'],
            'reset_mode' => ['required', 'in:midnight,rolling_24h'],
            'cycle_length' => ['required', 'integer', 'between:1,365'],
            'default_money' => ['required', 'numeric', 'min:0'],
            'webhook' => ['nullable', 'url'],
            'mail_notifications' => ['filled', 'boolean'],
            'public_leaderboard' => ['filled', 'boolean'],
            'sync_rewards' => ['filled', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();
    }
}
