<?php

namespace Azuriom\Plugin\Tasks\Requests;


class StatusRequest extends TasksFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
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
            'name.required' => trans('tasks::messages.validation.status.name.required'),
            'name.max' => trans('tasks::messages.validation.status.name.max'),
            'color.required' => trans('tasks::messages.validation.status.color.required'),
            'color.regex' => trans('tasks::messages.validation.status.color.format'),
        ];
    }
}
