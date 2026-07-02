<?php

namespace Azuriom\Plugin\Shop\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Models\Setting;
use Azuriom\Plugin\Shop\Models\Package;
use Azuriom\Plugin\Shop\Payment\Currencies;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CustomSettingsController extends Controller
{
    /**
     * Display the shop settings.
     */
    public function show()
    {
        $commands = setting('shop.commands');

        return view('shop::admin.custom-settings', [
            'hey' => (int) setting('shop.month_hey', 0),
        ]);
    }

    /**
     * Update the shop settings.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        $data = $this->validate($request, [
            'hey' => ['nullable', 'integer', 'min:0'],
        ]);

        $commands = $request->input('commands');

        Setting::updateSettings(Arr::only($data, 'currency'));

        Setting::updateSettings([
            'shop.month_hey' => $request->input('hey'),
        ]);

        return to_route('shop.admin.custom')
            ->with('success', trans('admin.settings.updated'));
    }
}
