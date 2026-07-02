<?php

namespace Azuriom\Plugin\Suggest\Requests;

use Azuriom\Plugin\Suggest\Models\Suggestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:up,down'],
        ];
    }
}
