<?php

namespace Azuriom\Plugin\Suggest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestionCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:4000'],
        ];
    }
}
