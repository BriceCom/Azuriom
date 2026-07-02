<?php

namespace Azuriom\Plugin\Hunt\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;

class RewardRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'need_online', 'is_enabled',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'hunt_ids' => ['sometimes', 'nullable', 'array'],
            'hunt_ids.*' => ['integer', 'exists:hunt_hunts,id'],
            'name' => ['required', 'string', 'max:100'],
            'chances' => ['required', 'numeric', 'between:0.01,100'],
            'money' => ['nullable', 'numeric', 'min:0'],
            'scratch_card_id' => ['nullable', 'integer'],
            'commands' => ['sometimes', 'nullable', 'array'],
            'commands.*' => ['string', 'max:500'],
            'need_online' => ['filled', 'boolean'],
            'is_enabled' => ['filled', 'boolean'],
            'roles' => ['sometimes', 'nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
            'servers' => ['sometimes', 'nullable', 'array'],
            'servers.*' => ['exists:servers,id'],
        ];

        if (function_exists('scratch_game_give_ticket')) {
            $rules['scratch_card_id'][] = 'exists:scratch_game_cards,id';
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'hunt_ids' => trans('hunt::admin.hunts.title'),
            'name' => trans('hunt::admin.rewards.fields.name'),
            'chances' => trans('hunt::admin.rewards.fields.chances'),
            'money' => trans('hunt::admin.rewards.fields.money'),
            'scratch_card_id' => trans('hunt::admin.rewards.fields.scratch_card'),
            'commands' => trans('hunt::admin.rewards.fields.commands'),
            'need_online' => trans('hunt::admin.rewards.fields.need_online'),
            'is_enabled' => trans('hunt::admin.rewards.fields.is_enabled'),
            'roles' => trans('hunt::admin.rewards.fields.roles'),
            'servers' => trans('hunt::admin.rewards.fields.servers'),
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
            'chances.between' => trans('hunt::admin.rewards.validation.chances_range'),
            'money.min' => trans('hunt::admin.rewards.validation.money_positive'),
            'commands.*.max' => trans('hunt::admin.rewards.validation.command_length'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();

        if ($this->filled('hunt_id') && ! $this->filled('hunt_ids')) {
            $this->merge(['hunt_ids' => [$this->input('hunt_id')]]);
        }

        $huntIds = collect($this->input('hunt_ids', []))
            ->filter(static fn ($huntId) => $huntId !== null && $huntId !== '')
            ->map(static fn ($huntId) => (int) $huntId)
            ->unique()
            ->values()
            ->all();

        $this->merge([
            'hunt_ids' => ! empty($huntIds) ? $huntIds : null,
        ]);

        if (! $this->filled('money') || $this->input('money') == '') {
            $this->merge(['money' => null]);
        }

        if (! $this->filled('scratch_card_id') || $this->input('scratch_card_id') === '') {
            $this->merge(['scratch_card_id' => null]);
        }

        $commands = array_filter($this->input('commands', []), function ($command) {
            return !empty(trim($command));
        });

        $this->merge([
            'commands' => !empty($commands) ? array_values($commands) : null,
        ]);
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $commands = $this->input('commands', []);
            $hasScratchCard = $this->input('scratch_card_id') !== null;

            if (!$this->filled('money') && empty(array_filter(is_array($commands) ? $commands : [])) && ! $hasScratchCard) {
                $validator->errors()->add('money', trans('hunt::admin.rewards.validation.reward_required'));
            }

            if (!empty(array_filter(is_array($commands) ? $commands : [])) && empty($this->input('servers'))) {
                $validator->errors()->add('servers', trans('hunt::admin.rewards.validation.servers_required_for_commands'));
            }
        });
    }
}
