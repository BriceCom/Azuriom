<?php

namespace Azuriom\Plugin\DailyReward\Requests\Admin;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Azuriom\Plugin\DailyReward\Models\DailyRewardReward;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RewardRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'need_online',
        'is_enabled',
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
            'day_id' => ['required', 'integer', 'exists:daily_reward_days,id'],
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', Rule::in([DailyRewardReward::TYPE_MONEY, DailyRewardReward::TYPE_COMMAND])],
            'money' => ['nullable', 'numeric', 'min:0'],
            'commands' => ['sometimes', 'nullable', 'array'],
            'commands.*' => ['string', 'max:500'],
            'need_online' => ['filled', 'boolean'],
            'servers' => ['sometimes', 'nullable', 'array'],
            'servers.*' => ['integer', 'exists:servers,id'],
            'is_enabled' => ['filled', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();

        $commands = array_filter(array_map('trim', $this->input('commands', [])));

        $this->merge([
            'commands' => ! empty($commands) ? array_values($commands) : null,
        ]);

        if (! $this->filled('money')) {
            $this->merge(['money' => null]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $type = $this->input('type');
            $money = $this->input('money');
            $commands = $this->input('commands', []);

            if ($type === DailyRewardReward::TYPE_MONEY && ($money === null || (float) $money <= 0)) {
                $validator->errors()->add('money', trans('daily-reward::admin.rewards.validation.money_required'));
            }

            if ($type === DailyRewardReward::TYPE_COMMAND) {
                if (empty($commands)) {
                    $validator->errors()->add('commands', trans('daily-reward::admin.rewards.validation.commands_required'));
                }

                if (empty($this->input('servers', []))) {
                    $validator->errors()->add('servers', trans('daily-reward::admin.rewards.validation.servers_required'));
                }
            }
        });
    }
}
