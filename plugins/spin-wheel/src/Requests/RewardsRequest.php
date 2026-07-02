<?php

namespace Azuriom\Plugin\SpinWheel\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class RewardsRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The checkboxes attributes.
     *
     * @var array
     */
    protected $checkboxes = [
        'need_online', 'is_enabled', 'send_webhook'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'servers.*' => ['required', 'exists:servers,id'],
            'chances' => ['required', 'numeric', 'between:1,100'],
            'money' => ['nullable', 'numeric', 'min:0'],
            'scratch_card_id' => ['nullable', 'integer'],
            'need_online' => ['filled', 'boolean'],
            'commands' => ['sometimes', 'nullable', 'array'],
            'is_enabled' => ['filled', 'boolean'],
            'color' => ['required'],
            'textFontSize' => ['required', 'min:0'],
            'textDirection' => ['required'],
            'textOrientation' => ['required'],
            'send_webhook' => ['filled', 'boolean'],
            'servers_id' => ['array']
        ];

        if (function_exists('scratch_game_give_ticket')) {
            $rules['scratch_card_id'][] = 'exists:scratch_game_cards,id';
        }

        return $rules;
    }

    /**
     * Get the validated data from the request.
     *
     * @param  mixed|null  $key
     * @param  mixed|null  $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        $validated['commands'] = array_filter(Arr::get($validated, 'commands', []));

        if (Arr::get($validated, 'money') === null) {
            $validated['money'] = 0;
        }

        return $validated;
    }
}
