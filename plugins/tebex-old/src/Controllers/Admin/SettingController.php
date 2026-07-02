<?php

namespace Azuriom\Plugin\Tebex\Controllers\Admin;

use Azuriom\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tebex\Resources\Currencies;
use Azuriom\Plugin\Tebex\Services\TebexApiService;
use Exception;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * @var TebexApiService
     */
    protected $apiService;

    /**
     * SettingController constructor.
     *
     * @param TebexApiService $apiService
     */
    public function __construct(TebexApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Display the tebex settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('tebex::admin.index', [
            'tebex_key' => setting('tebex.key', ''),
            'tebex_shop_title' => setting('tebex.shop.title', ''),
            'tebex_shop_subtitle' => setting('tebex.shop.subtitle', '')
        ]);
    }

    /**
     * Update the tebex settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        $this->validate($request, [
            'tebex_key' => ['nullable', 'max:45', 'min:45'],
        ]);

        try {
            $apiKey = $request->input('tebex_key');

            if ($this->apiService->verifyApiKey($apiKey)) {
                Setting::updateSettings([
                    'tebex.key' => $apiKey,
                    'tebex.shop.title' => $request->input('tebex_title'),
                    'tebex.shop.subtitle' => $request->input('tebex_subtitle'),
                    'tebex.shop.home' => $request->has("home_status") ? true : false,
                    'tebex.shop.home.message' => $request->input('home_message')
                ]);

                return redirect()->route('tebex.admin.index')
                    ->with('success', trans('admin.settings.updated'));
            } else {
                return redirect()->route('tebex.admin.index')
                    ->with('error', trans('tebex::admin.errors.badApiKey'));
            }
        } catch (Exception $e) {
            Log::error('Tebex API key verification error: ' . $e->getMessage());

            return redirect()->route('tebex.admin.index')
                ->with('error', trans('tebex::admin.errors.badApiKey'));
        }
    }
}
