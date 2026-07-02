<?php

namespace Azuriom\Plugin\ScratchGame\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Azuriom\Models\Server;
use Azuriom\Plugin\ScratchGame\Models\ScratchReward;
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
        'need_online',
        'is_enabled',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'chance' => ['required', 'numeric', 'between:0.01,100'],
            'money' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image:allow_svg', 'max:2048'],
            'commands' => ['sometimes', 'nullable', 'array'],
            'commands.*.name' => ['nullable', 'string', 'max:100'],
            'commands.*.command' => ['required', 'string', 'max:500'],
            'need_online' => ['filled', 'boolean'],
            'is_enabled' => ['filled', 'boolean'],
            'servers' => ['sometimes', 'nullable', 'array'],
            'servers.*' => ['exists:servers,id'],
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
            'name' => trans('scratch-game::admin.rewards.fields.name'),
            'chance' => trans('scratch-game::admin.rewards.fields.chance'),
            'money' => trans('scratch-game::admin.rewards.fields.money'),
            'image' => trans('scratch-game::admin.rewards.fields.image'),
            'commands' => trans('scratch-game::admin.rewards.fields.commands'),
            'commands.*.name' => trans('scratch-game::admin.rewards.fields.command_name'),
            'commands.*.command' => trans('scratch-game::admin.rewards.fields.command_line'),
            'servers' => trans('scratch-game::admin.rewards.fields.servers'),
            'need_online' => trans('scratch-game::admin.rewards.fields.need_online'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();

        if (! $this->filled('money') || $this->input('money') === '') {
            $this->merge(['money' => null]);
        }

        $commands = ScratchReward::normalizeCommands($this->input('commands', []));

        $this->merge([
            'commands' => ! empty($commands) ? array_values($commands) : null,
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $commands = $this->input('commands', []);
            $servers = $this->input('servers', []);
            $hasCommands = ! empty($commands);

            if (! $this->filled('money') && ! $hasCommands) {
                $validator->errors()->add('money', trans('scratch-game::admin.rewards.validation.reward_required'));
            }

            if ($hasCommands && empty($servers)) {
                $validator->errors()->add('servers', trans('scratch-game::admin.rewards.validation.servers_required_for_commands'));
            }

            if ($this->boolean('need_online') && empty($servers)) {
                $validator->errors()->add('servers', trans('scratch-game::admin.rewards.validation.servers_required_for_need_online'));
            }

            if ($this->boolean('need_online') && ! empty($servers)) {
                $hasNonAzLink = Server::query()
                    ->whereIn('id', $servers)
                    ->where('type', 'not like', '%azlink')
                    ->exists();

                if ($hasNonAzLink) {
                    $validator->errors()->add('need_online', trans('scratch-game::admin.rewards.validation.need_online_only_azlink'));
                }
            }
        });
    }
}
