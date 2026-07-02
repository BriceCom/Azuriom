<?php

namespace Azuriom\Plugin\Tebex\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;

class TebexSettingsRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'home_status',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('admin.access');
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'public_key' => ['required', 'string', 'max:255'],
            'project_id' => ['required', 'string', 'max:255'],
            'private_key' => ['nullable', 'string', 'max:255'],
            'tebex_title' => ['nullable', 'string', 'max:255'],
            'tebex_subtitle' => ['nullable', 'string', 'max:255'],
            'home_status' => ['nullable', 'boolean'],
            'home_message' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'public_key.required' => trans('tebex::admin.errors.noApiKey'),
            'public_key.max' => trans('tebex::admin.validation.public_key_max'),
            'project_id.required' => trans('tebex::admin.fields.project_id'),
            'project_id.max' => trans('tebex::admin.validation.project_id_max'),
            'private_key.max' => trans('tebex::admin.validation.private_key_max'),
            'tebex_title.max' => trans('tebex::admin.validation.title_max'),
            'tebex_subtitle.max' => trans('tebex::admin.validation.subtitle_max'),
        ];
    }
}
