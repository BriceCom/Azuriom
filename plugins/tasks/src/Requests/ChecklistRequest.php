<?php

namespace Azuriom\Plugin\Tasks\Requests;

class ChecklistRequest extends TasksFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'completed' => ['boolean'],
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
            'title.required' => trans('tasks::messages.validation.checklist.title.required'),
            'title.max' => trans('tasks::messages.validation.checklist.title.max'),
        ];
    }
}
