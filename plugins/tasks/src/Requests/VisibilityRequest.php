<?php

namespace Azuriom\Plugin\Tasks\Requests;

class VisibilityRequest extends TasksFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'role_id.required' => trans('tasks::messages.validation.visibility.role_id.required'),
            'role_id.exists' => trans('tasks::messages.validation.visibility.role_id.exists'),
        ];
    }
}
