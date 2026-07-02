<?php

namespace Azuriom\Plugin\Achievement\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ObjectiveRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'is_enabled',
    ];

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();
        $this->mergeIfMissing([
            'rewards' => [],
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'is_enabled' => ['filled', 'boolean'],
            'name' => ['required', 'string', 'max:100'],
            'hook' => ['required', 'string', 'max:50'],
            'trigger' => ['required', 'string', 'max:50'],
            'amount' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'start_date' => ['nullable', 'date'],
            'visibility' => ['required', Rule::in(['public', 'role'])],
            'visibility_roles' => ['required_if:visibility,role', 'array'],
            'visibility_roles.*' => ['integer', 'exists:roles,id'],
            'rewards' => ['nullable', 'array'],
            'rewards.*.type' => ['required', Rule::in(['money', 'command', 'trophy', 'scratch_game'])],
            'rewards.*.name' => ['nullable', 'string', 'max:100'],
            'rewards.*.value' => ['required', 'string'],
            'rewards.*.server_id' => ['required_if:rewards.*.type,command', 'integer', 'exists:servers,id']
        ];
    }
}
