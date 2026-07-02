<?php

namespace Azuriom\Plugin\Tasks\Requests;

class StatusUpdateRequest extends TasksFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('tasks.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status_id' => ['required', 'exists:tasks_statuses,id'],
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
            'status_id' => trans('tasks::admin.fields.status'),
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
            'status_id.required' => trans('tasks::messages.validation.status.required'),
            'status_id.exists' => trans('tasks::messages.validation.status.exists'),
        ];
    }
}
