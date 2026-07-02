<?php

namespace Azuriom\Plugin\Tebex\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class TebexApiService
{
    /**
     * Base URL for Tebex Headless API
     * Using the new Headless API as per https://docs.tebex.io/developers/headless-api/endpoints
     *
     * @var string
     */
    protected $baseUrl = 'https://headless.tebex.io/api';

    /**
     * Get the API key from settings
     *
     * @return string|null
     */
    protected function getApiKey()
    {
        return setting('tebex.key');
    }

    /**
     * Create HTTP request with proper headers
     *
     * @return \Illuminate\Http\Client\PendingRequest
     * @throws Exception If API key is not set
     */
    protected function createRequest()
    {
        $apiKey = $this->getApiKey();

        if (!$apiKey) {
            throw new Exception(trans('tebex::admin.errors.noApiKey'));
        }

        return Http::withToken($apiKey);
    }

    /**
     * Get all categories from Tebex
     * Using the new accounts/categories endpoint as per https://docs.tebex.io/developers/headless-api/endpoints
     *
     * @return object
     * @throws Exception If API request fails
     */
    public function getCategories()
    {
        try {
            $apiKey = $this->getApiKey();
            $response = $this->createRequest()->get("{$this->baseUrl}/accounts/{$apiKey}/categories?includePackages=1");

            if (!$response->successful()) {
                throw new Exception("Failed to fetch categories: {$response->status()}");
            }

            $data = json_decode($response->body());

            // Step 1: Create a map of categories by their ID
            $categoryMap = [];
            foreach ($data->data as $category) {
                $category->subcategories = [];
                $categoryMap[$category->id] = $category;
            }

            // Step 2: Organize into parent/child
            $rootCategories = [];
            foreach ($data->data as $category) {
                if (!empty($category->parent)) {
                    // This is a subcategory — attach to its parent
                    $parentId = $category->parent->id;
                    if (isset($categoryMap[$parentId])) {
                        $categoryMap[$parentId]->subcategories[] = $category;
                    }
                } else {
                    // No parent — it's a root category
                    $rootCategories[] = $category;
                }
            }

            // Step 3: Return grouped categories
            $categories = new \stdClass();
            $categories->categories = $rootCategories;

            return $categories;

        } catch (Exception $e) {
            Log::error('Tebex API error: ' . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Create a checkout for a package
     *
     * @param int $packageId
     * @param string $username
     * @return string The checkout URL
     * @throws Exception If API request fails
     */
    public function createCheckout($packageId, $username)
    {
        try {
            $response = $this->createRequest()->post("{$this->baseUrl}/checkout/create", [
                'package_id' => $packageId,
                'username' => $username
            ]);

            if (!$response->successful()) {
                throw new Exception(trans('tebex::admin.errors.nickname'));
            }

            $data = json_decode($response->body());
            return $data->data->url;
        } catch (Exception $e) {
            Log::error('Tebex API error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verify if the API key is valid
     * Using the new accounts endpoint as per https://docs.tebex.io/developers/headless-api/endpoints
     *
     * @param string $apiKey
     * @return bool
     */
    public function verifyApiKey($apiKey)
    {
        try {
            $response = Http::withToken($apiKey)
                ->get("{$this->baseUrl}/accounts/{$apiKey}");

            return $response->successful();
        } catch (Exception $e) {
            Log::error('Tebex API key verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a new basket for checkout
     *
     * @param string $completeUrl URL to redirect to after successful checkout
     * @param string $cancelUrl URL to redirect to if checkout is canceled
     * @param bool $completeAutoRedirect Whether to automatically redirect after completion
     * @param array $custom Custom data to include with the basket
     * @param string $username Username to set for the basket (optional)
     * @param string $email Email to set for the basket (optional)
     * @return object The created basket object
     * @throws Exception If API request fails
     */
    public function createBasket($completeUrl = null, $cancelUrl = null, $completeAutoRedirect = true, $custom = [], $username = null, $email = null)
    {
        try {
            Log::debug('Creating new basket', [
                'complete_url' => $completeUrl,
                'cancel_url' => $cancelUrl,
                'username' => $username,
                'email' => $email
            ]);

            $apiKey = $this->getApiKey();
            $data = [
                'complete_url' => $completeUrl ?? route('tebex.index'),
                'cancel_url' => $cancelUrl ?? route('tebex.cart.index'),
                'complete_auto_redirect' => $completeAutoRedirect,
            ];

            if (!empty($custom)) {
                $data['custom'] = $custom;
            }

            // Add username and email if provided
            if ($username) {
                $data['username'] = $username;
            }

            if ($email) {
                $data['email'] = $email;
            } elseif ($username) {
                // Use a placeholder email based on the username if email is not provided
                $data['email'] = $username . '@example.com';
            }

            $response = $this->createRequest()->post("{$this->baseUrl}/accounts/{$apiKey}/baskets", $data);

            if (!$response->successful()) {
                Log::error('Failed to create basket', ['status' => $response->status(), 'body' => $response->body()]);
                throw new Exception("Failed to create basket: {$response->status()} - {$response->body()}");
            }

            Log::debug('Basket created successfully', ['response' => $response->body()]);
            return json_decode($response->body())->data;
        } catch (Exception $e) {
            Log::error('Tebex API error creating basket: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add a package to a basket
     *
     * @param string $basketIdent The basket identifier
     * @param int $packageId The package ID to add
     * @param int $quantity The quantity to add
     * @return object The updated basket
     * @throws Exception If API request fails
     */
    public function addPackageToBasket($basketIdent, $packageId, $quantity = 1)
    {
        try {
            $response = $this->createRequest()->post("{$this->baseUrl}/baskets/{$basketIdent}/packages", [
                'package_id' => $packageId,
                'quantity' => $quantity
            ]);

            if (!$response->successful()) {
                throw new Exception("Failed to add package to basket: {$response->status()} - {$response->body()}");
            }

            return json_decode($response->body())->data;
        } catch (Exception $e) {
            Log::error('Tebex API error adding package to basket: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Set the username for a basket
     *
     * @param string $basketIdent The basket identifier
     * @param string $username The username to set
     * @return object The updated basket
     * @throws Exception If API request fails
     */
    public function setBasketUsername($basketIdent, $username)
    {
        try {
            // The endpoint for setting the username directly is not documented in the Postman collection
            // Let's try using the documented endpoint for adding a package to a basket
            // This will update the basket and might implicitly set the username

            Log::debug('Setting username for basket', ['basket_ident' => $basketIdent, 'username' => $username]);

            // First, get the current basket to see what packages are in it
            $apiKey = $this->getApiKey();
            $response = $this->createRequest()->get("{$this->baseUrl}/accounts/{$apiKey}/baskets/{$basketIdent}");

            if (!$response->successful()) {
                Log::error('Failed to get basket', ['status' => $response->status(), 'body' => $response->body()]);
                throw new Exception("Failed to get basket: {$response->status()} - {$response->body()}");
            }

            $basket = json_decode($response->body())->data;
            Log::debug('Got basket', ['basket' => $basket]);

            // Try approach 1: Use the documented endpoint for updating a basket with PUT
            Log::debug('Trying PUT request to update basket');
            $response = $this->createRequest()->put("{$this->baseUrl}/baskets/{$basketIdent}", [
                'username' => $username,
                'email' => $username . '@example.com' // Use a placeholder email based on the username
            ]);

            if ($response->successful()) {
                Log::debug('PUT request successful');
                return json_decode($response->body())->data;
            }

            Log::warning('PUT request failed', ['status' => $response->status(), 'body' => $response->body()]);

            // Try approach 2: Use POST request instead
            Log::debug('Trying POST request to update basket');
            $response = $this->createRequest()->post("{$this->baseUrl}/baskets/{$basketIdent}", [
                'username' => $username,
                'email' => $username . '@example.com' // Use a placeholder email based on the username
            ]);

            if ($response->successful()) {
                Log::debug('POST request successful');
                return json_decode($response->body())->data;
            }

            Log::warning('POST request failed', ['status' => $response->status(), 'body' => $response->body()]);

            // Try approach 3: Use the original endpoint as a last resort
            Log::debug('Trying original endpoint');
            $response = $this->createRequest()->post("{$this->baseUrl}/baskets/{$basketIdent}/username", [
                'username' => $username
            ]);

            if ($response->successful()) {
                Log::debug('Original endpoint request successful');
                return json_decode($response->body())->data;
            }

            Log::error('All approaches failed', ['status' => $response->status(), 'body' => $response->body()]);
            throw new Exception("Failed to set basket username: {$response->status()} - {$response->body()}");
        } catch (Exception $e) {
            Log::error('Tebex API error setting basket username: ' . $e->getMessage());
            throw $e;
        }
    }
}
