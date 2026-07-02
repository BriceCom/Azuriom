<?php

namespace Azuriom\Plugin\Tasks\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class TasksFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // By default, defer authorization to the controller and middleware
        return true;
    }
}
