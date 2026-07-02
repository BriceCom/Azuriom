<?php

namespace Azuriom\Plugin\AlternativeCurrency\Request;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoinsRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'shop_currency',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('alternative_currency_coins', 'name')->ignore($this->route('coin')->id),
            ],
            'logo' => ['nullable', 'exists:images,file'],
            'shop_currency' => ['filled', 'boolean'],
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
