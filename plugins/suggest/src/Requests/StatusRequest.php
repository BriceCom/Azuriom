<?php

namespace Azuriom\Plugin\Suggest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
            'refusal_reason' => ['nullable', 'string'],
        ];
    }
}
