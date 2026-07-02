<?php

namespace Azuriom\Plugin\Tasks\Requests;

class RelatedTaskRequest extends TasksFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'related_task_id' => [
                'required',
                'exists:tasks_tasks,id',
                'different:task_id', // Cannot relate a task to itself
            ],
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
            'related_task_id.required' => trans('tasks::messages.validation.related_task.id.required'),
            'related_task_id.exists' => trans('tasks::messages.validation.related_task.id.exists'),
            'related_task_id.different' => trans('tasks::messages.validation.related_task.id.different'),
        ];
    }
}
