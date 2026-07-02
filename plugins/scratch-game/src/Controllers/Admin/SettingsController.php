<?php

namespace Azuriom\Plugin\ScratchGame\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('scratch-game::admin.settings');
    }

    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'page_title' => ['nullable', 'string', 'max:100'],
            'card_min_width' => ['nullable', 'integer', 'min:100', 'max:2000'],
            'card_min_height' => ['nullable', 'integer', 'min:100', 'max:2000'],
        ]);

        Setting::updateSettings([
            'scratch-game.page_title' => $data['page_title'] ?? null,
            'scratch-game.card_min_width' => $data['card_min_width'] ?? null,
            'scratch-game.card_min_height' => $data['card_min_height'] ?? null,
        ]);

        return to_route('scratch-game.admin.settings.index')
            ->with('success', trans('scratch-game::admin.settings.status.updated'));
    }
}
