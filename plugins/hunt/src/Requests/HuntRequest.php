<?php

namespace Azuriom\Plugin\Hunt\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class HuntRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'is_active', 'is_archived',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $hunt = $this->route('hunt');
        $isUpdate = $hunt && $hunt->exists;

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:100', 'alpha_dash', 'unique:hunt_hunts,slug,' . ($hunt?->id ?? 'null')],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image:allow_svg', 'max:2048'],
            'priority' => ['required', 'integer', 'min:0', 'max:1000'],
            'max_per_day' => ['required', 'integer', 'min:1', 'max:100'],
            'global_cap' => ['nullable', 'integer', 'min:0'],
            'spawn_rate' => ['required', 'numeric', 'between:0.01,100'],
            'cooldown_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'spawn_delay_seconds' => ['required', 'integer', 'min:0', 'max:3600'],
            'is_active' => ['filled', 'boolean'],
            'is_archived' => ['filled', 'boolean'],
        ];

        if (!$isUpdate) {
            $rules['start_date'] = ['nullable', 'date', 'after_or_equal:today'];
            $rules['end_date'] = ['required', 'date', 'after:start_date'];
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
            'name' => trans('hunt::admin.hunts.fields.name'),
            'slug' => trans('hunt::admin.hunts.fields.slug'),
            'description' => trans('hunt::admin.hunts.fields.description'),
            'image' => trans('hunt::admin.hunts.fields.image'),
            'priority' => trans('hunt::admin.hunts.fields.priority'),
            'max_per_day' => trans('hunt::admin.hunts.fields.max_per_day'),
            'global_cap' => trans('hunt::admin.hunts.fields.global_cap'),
            'spawn_rate' => trans('hunt::admin.hunts.fields.spawn_rate'),
            'cooldown_minutes' => trans('hunt::admin.hunts.fields.cooldown_minutes'),
            'spawn_delay_seconds' => trans('hunt::admin.hunts.fields.spawn_delay_seconds'),
            'start_date' => trans('hunt::admin.hunts.fields.start_date'),
            'end_date' => trans('hunt::admin.hunts.fields.end_date'),
            'is_active' => trans('hunt::admin.hunts.fields.is_active'),
            'is_archived' => trans('hunt::admin.hunts.fields.is_archived'),
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
            'spawn_rate.between' => trans('hunt::admin.hunts.validation.spawn_rate_range'),
            'cooldown_minutes.max' => trans('hunt::admin.hunts.validation.cooldown_max'),
            'start_date.after_or_equal' => trans('hunt::admin.hunts.validation.start_date_future'),
            'end_date.after' => trans('hunt::admin.hunts.validation.end_date_after_start'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();

        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge(['slug' => Str::slug($this->input('name'))]);
        }

        $globalCap = $this->input('global_cap');
        if ($globalCap === null || $globalCap === '' || (int) $globalCap === 0) {
            $this->merge(['global_cap' => null]);
        }
    }
}
