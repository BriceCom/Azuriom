<?php

namespace Azuriom\Plugin\Tasks\Requests;

class AssigneeRequest extends TasksFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
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
            'user_id.required' => trans('tasks::messages.validation.assignee.user_id.required'),
            'user_id.exists' => trans('tasks::messages.validation.assignee.user_id.exists'),
        ];
    }
}
