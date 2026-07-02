<?php

namespace Azuriom\Plugin\ScratchGame\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'is_enabled',
    ];

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $card = $this->route('card');
        $requiredImageRule = $card === null ? 'required' : 'nullable';

        return [
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'free_interval_minutes' => ['nullable', 'integer', 'min:1', 'max:43200'],
            'cover_image' => [$requiredImageRule, 'string', 'max:255', 'exists:images,file'],
            'background_image' => [$requiredImageRule, 'string', 'max:255', 'exists:images,file'],
            'is_enabled' => ['filled', 'boolean'],
            'rewards' => ['sometimes', 'nullable', 'array'],
            'rewards.*' => ['exists:scratch_game_rewards,id'],
            'roles' => ['sometimes', 'nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => trans('scratch-game::admin.cards.fields.name'),
            'price' => trans('scratch-game::admin.cards.fields.price'),
            'free_interval_minutes' => trans('scratch-game::admin.cards.fields.free_interval_minutes'),
            'cover_image' => trans('scratch-game::admin.cards.fields.cover_image'),
            'background_image' => trans('scratch-game::admin.cards.fields.background_image'),
            'rewards' => trans('scratch-game::admin.cards.fields.rewards'),
            'roles' => trans('scratch-game::admin.cards.fields.roles'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();

        if (! $this->has('rewards')) {
            $this->merge(['rewards' => []]);
        }

        if (! $this->has('roles')) {
            $this->merge(['roles' => []]);
        }

        if (! $this->filled('cover_image')) {
            $this->merge(['cover_image' => null]);
        }

        if (! $this->filled('background_image')) {
            $this->merge(['background_image' => null]);
        }

        if (! $this->filled('free_interval_minutes') || $this->input('free_interval_minutes') === '') {
            $this->merge(['free_interval_minutes' => null]);
        }
    }
}
