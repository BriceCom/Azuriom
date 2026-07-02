<?php

namespace Azuriom\Plugin\Tasks\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
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
            'pending_statuses' => ['nullable', 'array'],
            'pending_statuses.*' => ['exists:tasks_statuses,id'],
            'in_progress_statuses' => ['nullable', 'array'],
            'in_progress_statuses.*' => ['exists:tasks_statuses,id'],
            'completed_statuses' => ['nullable', 'array'],
            'completed_statuses.*' => ['exists:tasks_statuses,id'],
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
            'pending_statuses' => trans('tasks::admin.settings.pending_statuses'),
            'in_progress_statuses' => trans('tasks::admin.settings.in_progress_statuses'),
            'completed_statuses' => trans('tasks::admin.settings.completed_statuses'),
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
            'pending_statuses.*.exists' => trans('tasks::messages.validation.status.exists'),
            'in_progress_statuses.*.exists' => trans('tasks::messages.validation.status.exists'),
            'completed_statuses.*.exists' => trans('tasks::messages.validation.status.exists'),
        ];
    }
}
