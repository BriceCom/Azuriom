<?php

namespace Azuriom\Plugin\AlternativeCurrency\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Azuriom\Plugin\AlternativeCurrency\Models\Coin;

class SettingsController extends Controller
{
    public function index()
    {
        $coins = Coin::all();

        return view('alternative-currency::admin.settings.index', compact('coins'));
    }

    public function store(){

        Setting::updateSettings('alternative_currency.api_key', request('apiToken'));

        return redirect()->route('alternative-currency.admin.setting.index')->with('success', "Paramètres mis à jour avec succès.");
    }
}
