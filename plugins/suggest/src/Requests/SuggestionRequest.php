<?php

namespace Azuriom\Plugin\Suggest\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class SuggestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $maxDescriptionLength = (int) setting('suggest.max_description_length', 600);

        $rules = [
            'title' => ['required', 'string', 'max:80'],
            'content' => [
                'required',
                'string',
                function (string $attribute, mixed $value, Closure $fail) use ($maxDescriptionLength): void {
                    $contentTextLength = $this->getContentTextLength((string) $value);

                    if ($contentTextLength > $maxDescriptionLength) {
                        $fail(trans('validation.max.string', [
                            'attribute' => trans('suggest::messages.fields.description'),
                            'max' => $maxDescriptionLength,
                        ]));
                    }
                },
            ],
            'category_id' => ['required', 'exists:suggest_categories,id'],
        ];

        if ($this->routeIs('suggest.admin.*')) {
            $rules['status'] = ['required', 'string', 'in:pending,approved,rejected'];
            $rules['refusal_reason'] = ['nullable', 'string'];
        }

        return $rules;
    }

    private function getContentTextLength(string $content): int
    {
        $decodedContent = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $strippedContent = trim(strip_tags($decodedContent));

        return mb_strlen($strippedContent);
    }
}
