<?php

namespace Azuriom\Plugin\DailyReward\Requests\Admin;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DayRequest extends FormRequest
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
        $dayId = $this->route('day')?->id;

        return [
            'day_number' => [
                'required',
                'integer',
                'between:1,365',
                Rule::unique('daily_reward_days', 'day_number')->ignore($dayId),
            ],
            'label' => ['nullable', 'string', 'max:100'],
            'is_enabled' => ['filled', 'boolean'],
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
