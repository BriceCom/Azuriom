<?php

namespace Azuriom\Plugin\Tasks\Requests;

class TaskRequest extends TasksFormRequest
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
            'description' => ['required', 'string'],
            'status_id' => ['required', 'exists:tasks_statuses,id'],
            'started_at' => ['nullable', 'date'],
            'limited_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'priority' => ['nullable', 'integer', 'min:0', 'max:100'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tasks_tags,id'],
            'assignees' => ['nullable', 'array'],
            'assignees.*' => ['exists:users,id'],
            'visibility' => ['nullable', 'in:public,role,private'],
            'visibility_roles' => ['nullable', 'array', 'required_if:visibility,role'],
            'visibility_roles.*' => ['exists:roles,id'],
            'related_tasks' => ['nullable', 'array'],
            'related_tasks.*' => ['exists:tasks_tasks,id', 'different:id'],
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
            'title.required' => trans('tasks::messages.validation.title.required'),
            'description.required' => trans('tasks::messages.validation.description.required'),
            'status_id.required' => trans('tasks::messages.validation.status.required'),
            'status_id.exists' => trans('tasks::messages.validation.status.exists'),
            'limited_at.after_or_equal' => trans('tasks::messages.validation.limited_at.after_or_equal'),
            'priority.integer' => trans('tasks::messages.validation.priority.integer'),
            'priority.min' => trans('tasks::messages.validation.priority.min'),
            'priority.max' => trans('tasks::messages.validation.priority.max'),
            'tags.*.exists' => trans('tasks::messages.validation.tags.exists'),
            'assignees.*.exists' => trans('tasks::messages.validation.assignees.exists'),
            'visibility.in' => trans('tasks::messages.validation.visibility.in'),
            'visibility_roles.required_if' => trans('tasks::messages.validation.visibility_roles.required_if'),
            'visibility_roles.*.exists' => trans('tasks::messages.validation.visibility_roles.exists'),
            'related_tasks.*.exists' => trans('tasks::messages.validation.related_tasks.exists'),
            'related_tasks.*.different' => trans('tasks::messages.validation.related_tasks.different'),
        ];
    }
}
