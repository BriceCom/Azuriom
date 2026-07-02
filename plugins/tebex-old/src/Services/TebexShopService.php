<?php

namespace Azuriom\Plugin\Tebex\Services;

use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Service for processing Tebex shop data from the Headless API
 * Compatible with the new Tebex Headless API as per https://docs.tebex.io/developers/headless-api/endpoints
 */
class TebexShopService
{
    /**
     * @var TebexApiService
     */
    protected $apiService;

    /**
     * TebexShopService constructor.
     *
     * @param TebexApiService $apiService
     */
    public function __construct(TebexApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Get all categories with their packages and subcategories
     *
     * @return array
     * @throws Exception
     */
    public function getShopData()
    {
        try {
            // Fetch categories with packages included
            $categoriesData = $this->apiService->getCategories();

            return $this->processShopData($categoriesData);
        } catch (Exception $e) {
            Log::error('Tebex shop data error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Process shop data from API responses
     *
     * @param object $categoriesData
     * @return array
     */
    protected function processShopData($categoriesData)
    {
        $categories = [];

        foreach ($categoriesData->categories as $cate) {
            // When using includePackages=1, the packages are already included in the category
            $packages = isset($cate->packages) && is_array($cate->packages) && !empty($cate->packages)
                ? $this->processPackagesFromCategory($cate->packages)
                : [];

            $subCategories = isset($cate->subcategories) && is_array($cate->subcategories) && !empty($cate->subcategories)
                ? $this->processSubcategoriesFromCategory($cate->subcategories)
                : [];

            $categories[] = (object) [
                'id' => $cate->id,
                'name' => $cate->name,
                'packages' => $packages,
                'subcategories' => $subCategories
            ];
        }

        return $categories;
    }

    /**
     * Process packages that are already included in the category data
     *
     * @param array $packages
     * @return array
     */
    protected function processPackagesFromCategory($packages)
    {
        $processedPackages = [];

        foreach ($packages as $package) {
            // Skip disabled packages
            $isDisabled = isset($package->disabled) ? $package->disabled : false;
            if ($isDisabled) {
                continue;
            }

            $processedPackages[] = $this->createPackageObject($package);
        }

        return $processedPackages;
    }

    /**
     * Process subcategories that are already included in the category data
     *
     * @param array $subcategories
     * @return array
     */
    protected function processSubcategoriesFromCategory($subcategories)
    {
        $subCategoriesArray = [];

        foreach ($subcategories as $subCategory) {
            $packages = isset($subCategory->packages) && is_array($subCategory->packages) && !empty($subCategory->packages)
                ? $this->processPackagesFromCategory($subCategory->packages)
                : [];

            $subCategoriesArray[] = (object) [
                'id' => $subCategory->id,
                'name' => $subCategory->name,
                'packages' => $packages,
            ];
        }

        return $subCategoriesArray;
    }

    /**
     * Create a package object with all necessary data
     *
     * @param object $product
     * @return object
     */
    protected function createPackageObject($product)
    {
        // In the Headless API, price might be in a different property structure
        $productPrice = $product->base_price;

        // In the Headless API, image might be in a different property
        $image = $product->image;

        $packageObj = (object) [
            'id' => $product->id,
            'name' => $product->name,
            'image' => $image,
            'description' => $product->description,
            "price" => (object) [
                "normal" => $productPrice,
                "currency" => $product->currency,
                "discount" => $product->discount ?? null
            ]
        ];

        return $packageObj;
    }

    /**
     * Get a specific package by ID
     *
     * @param int $packageId
     * @return \Azuriom\Plugin\Tebex\Models\TebexPackage|null
     */
    public function getPackage($packageId)
    {
        try {
            // Get all categories with their packages
            $categories = $this->getShopData();

            // Search for the package in all categories and subcategories
            foreach ($categories as $category) {
                // Check packages in this category
                foreach ($category->packages as $package) {
                    if ($package->id == $packageId) {
                        return \Azuriom\Plugin\Tebex\Models\TebexPackage::fromPackageObject($package);
                    }
                }

                // Check packages in subcategories
                foreach ($category->subcategories as $subcategory) {
                    foreach ($subcategory->packages as $package) {
                        if ($package->id == $packageId) {
                            return \Azuriom\Plugin\Tebex\Models\TebexPackage::fromPackageObject($package);
                        }
                    }
                }
            }

            // Package not found
            return null;
        } catch (Exception $e) {
            Log::error('Error finding Tebex package: ' . $e->getMessage());
            return null;
        }
    }
}
