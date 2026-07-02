<?php

namespace Azuriom\Plugin\Trackurl\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string|Rule>>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'destination_url' => ['required', 'url', 'max:255'],
            'short_code' => ['required', 'string', 'max:50'],
        ];

        // If this is a create request, the short_code can be nullable
        if ($this->isMethod('post')) {
            $rules['short_code'] = ['nullable', 'string', 'max:50', 'unique:trackurl_links'];
        } else {
            // For update requests, we need to ignore the current link's short_code
            $linkId = $this->route('link')->id;
            $rules['short_code'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('trackurl_links')->ignore($linkId)
            ];
        }

        return $rules;
    }
}
