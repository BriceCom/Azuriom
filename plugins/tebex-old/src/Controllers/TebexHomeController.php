<?php

namespace Azuriom\Plugin\Tebex\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tebex\Services\TebexShopService;
use Exception;
use Illuminate\Support\Facades\Log;

class TebexHomeController extends Controller
{
    /**
     * @var TebexShopService
     */
    protected $shopService;

    /**
     * TebexHomeController constructor.
     *
     * @param TebexShopService $shopService
     */
    public function __construct(TebexShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!setting('tebex.key')) {
            return redirect()->route('home')->with('error', trans('tebex::admin.errors.noApiKey'));
        }

        try {
            $categories = $this->shopService->getShopData();
            return view('tebex::index', ["categories" => $categories]);
        } catch (Exception $e) {
            Log::error('Tebex shop error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', trans('tebex::admin.errors.apiError'));
        }
    }

    /**
     * Show packages for a specific category.
     *
     * @param int $category The category ID
     * @return \Illuminate\Http\Response
     */
    public function category($category)
    {
        if (!setting('tebex.key')) {
            return redirect()->route('home')->with('error', trans('tebex::admin.errors.noApiKey'));
        }

        try {
            $categories = $this->shopService->getShopData();
            $currentCategory = null;

            // Find the requested category
            foreach ($categories as $cat) {
                if ($cat->id == $category) {
                    $currentCategory = $cat;
                    break;
                }

                // Check in subcategories if not found
                if (!$currentCategory) {
                    foreach ($cat->subcategories as $subCat) {
                        if ($subCat->id == $category) {
                            $currentCategory = $subCat;
                            break 2;
                        }
                    }
                }
            }

            if (!$currentCategory) {
                return redirect()->route('tebex.index')->with('error', trans('tebex::messages.categories.not_found'));
            }

            return view('tebex::categories.category', [
                'categories' => $categories,
                'category' => $currentCategory
            ]);
        } catch (Exception $e) {
            Log::error('Tebex shop error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', trans('tebex::admin.errors.apiError'));
        }
    }
}
