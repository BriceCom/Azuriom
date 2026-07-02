<?php

namespace Azuriom\Plugin\SpinWheel\Controllers\Admin;

use Azuriom\Models\Setting;

use Illuminate\Http\Request;
use Azuriom\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return view('spin-wheel::admin.settings');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'delay' => ['nullable', 'numeric', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'homeWins' => ['required', 'integer', 'min:0'],
            'webhookUrl' => ['nullable', 'url'],
            'webhookTitle' => ['nullable'],
            'webhookDesc' => ['nullable'],
            'webhookFooter' => ['nullable'],
            'freeSpinDelay' => ['nullable', 'integer', 'min:0'],
        ]);

        Setting::updateSettings([
            'spin.delay' => $request->input('delay'),
            'spin.price' => $request->input('price'),
            'spin.homeWins' => $request->input('homeWins'),
            'spin.homePercentage' => ($request->has('homePercentage') == 1) ? true : false,
            'spin.proportionalWheel' => $request->has('proportionalWheel'),
            'spin.webhookUrl' => $request->input('webhookUrl'),
            'spin.webhookTitle' => $request->input('webhookTitle'),
            'spin.webhookDesc' => $request->input('webhookDesc'),
            'spin.webhookFooter' => $request->input('webhookFooter'),
            'spin.webhookSkin' => ($request->has('webhookSkin') == 1) ? true : false,
            'spin.webhookFooterDate' => ($request->has('webhookFooterDate') == 1) ? true : false,
            'spin.freeSpin' => ($request->has('freeSpin') == 1) ? true : false,
            'spin.freeSpin.delay' => $request->input('freeSpinDelay'),
            'spin.ordering' => $request->has('ordering')
        ]);

        return redirect()->route('spin-wheel.admin.settings.index')
            ->with('success', trans('spin-wheel::admin.pages.settings.notifs.updated'));
    }
}
