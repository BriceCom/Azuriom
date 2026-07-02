<?php

namespace Azuriom\Plugin\Tebex\Cart;

use Azuriom\Plugin\Tebex\Models\Concerns\Buyable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Represents an item in the cart.
 */
class CartItem implements Arrayable
{
    /**
     * The cart where this item is stored.
     * The cart *may* not contain this item if it was removed.
     */
    private Cart $cart;

    /**
     * The ID of the cart item with the format '{model class}-{model id}'.
     */
    public string $itemId;

    /**
     * The ID of the item.
     */
    public int $id;

    /**
     * The quantity for this cart item.
     */
    public int $quantity;

    /**
     * The model class.
     */
    public string $type;

    /**
     * The associated model.
     */
    private Buyable $buyable;

    /**
     * Create a new cart item instance.
     */
    public function __construct(Cart $cart, Buyable $buyable, string $itemId, int $quantity = 1)
    {
        $this->cart = $cart;
        $this->id = $buyable->getId();
        $this->itemId = $itemId;
        $this->type = get_class($buyable);
        $this->buyable = $buyable;
        $this->setQuantity($quantity);
    }

    /**
     * Set the quantity for this cart item.
     */
    public function setQuantity(int $quantity): void
    {
        $maxQuantity = $this->buyable->getMaxQuantity();

        $this->quantity = min($this->hasQuantity() ? $quantity : 1, $maxQuantity);

        if ($this->quantity <= 0) {
            $this->cart->remove($this->buyable);
        }
    }

    /**
     * Retrieve the buyable model.
     */
    public function buyable(): Buyable
    {
        return $this->buyable;
    }

    /**
     * Check if this item can be purchased multiple times.
     */
    public function hasQuantity(): bool
    {
        return $this->buyable->hasQuantity();
    }

    /**
     * Get the maximum quantity that can be purchased.
     */
    public function maxQuantity(): int
    {
        return $this->buyable->getMaxQuantity();
    }

    /**
     * Get the name of this item.
     */
    public function name(): string
    {
        return $this->buyable->getName();
    }

    /**
     * Get the price of this item.
     */
    public function price(): float
    {
        return $this->buyable->getPrice();
    }

    /**
     * Get the total price of this item.
     */
    public function total(): float
    {
        return $this->price() * $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'itemId' => $this->itemId,
            'type' => $this->type,
            'quantity' => $this->quantity,
        ];
    }
}
