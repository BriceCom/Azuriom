<?php

namespace Azuriom\Plugin\Changelog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => ['required', 'exists:changelog_categories,id'],
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
        ];
    }
}
