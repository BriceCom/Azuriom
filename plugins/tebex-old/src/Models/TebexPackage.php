<?php

namespace Azuriom\Plugin\Tebex\Models;

use Azuriom\Plugin\Tebex\Models\Concerns\Buyable;
use Azuriom\Plugin\Tebex\Services\TebexApiService;
use Azuriom\Plugin\Tebex\Services\TebexShopService;

class TebexPackage implements Buyable
{
    /**
     * The package ID.
     *
     * @var int
     */
    protected $id;

    /**
     * The package name.
     *
     * @var string
     */
    protected $name;

    /**
     * The package price.
     *
     * @var float
     */
    protected $price;

    /**
     * The package description.
     *
     * @var string
     */
    protected $description;

    /**
     * The package currency.
     *
     * @var string
     */
    protected $currency;

    /**
     * The package image URL.
     *
     * @var string|null
     */
    protected $image;

    /**
     * Create a new TebexPackage instance.
     *
     * @param object $package The package object from the Tebex API
     */
    public function __construct($package)
    {
        $this->id = $package->id;
        $this->name = $package->name;

        // Handle different price structures
        if (isset($package->price) && is_object($package->price)) {
            // Old API structure
            $this->price = $package->price->normal;
            $this->currency = $package->price->currency ?? 'USD';
        } else {
            // New API structure as shown in the issue description
            $this->price = $package->base_price ?? $package->total_price ?? 0;
            $this->currency = $package->currency ?? 'USD';
        }

        $this->description = $package->description;
        $this->image = $package->image;
    }

    /**
     * Get the identifier of the buyable.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of this buyable.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the price of the buyable.
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the description of the buyable.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get whether the buyable can be purchased multiple times.
     */
    public function hasQuantity(): bool
    {
        return true;
    }

    /**
     * Get the maximum purchase quantity that the current user can purchase.
     */
    public function getMaxQuantity(): int
    {
        return 10; // Arbitrary limit, can be adjusted
    }

    /**
     * Deliver this buyable once it is paid.
     */
    public function deliver(PaymentItemInterface $item): void
    {
        // Get the API service from the container
        $apiService = app(TebexApiService::class);

        // Get the username from the session or the user's name
        $username = session('tebex_username', $item->getUser()->name);

        // Create a checkout for the package
        $apiService->createCheckout($this->id, $username);
    }

    /**
     * Get the currency of this package.
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Get the image URL of this package.
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Create a TebexPackage from a package object.
     *
     * @param object $package The package object from the Tebex API
     * @return self
     */
    public static function fromPackageObject($package): self
    {
        return new self($package);
    }

}
