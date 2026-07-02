<?php

namespace Azuriom\Plugin\Tebex\Cart;

use Azuriom\Plugin\Tebex\Models\Concerns\Buyable;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/**
 * Represents a cart with items.
 */
class Cart implements Arrayable
{
    /**
     * The session where this cart is stored.
     */
    private ?Session $session;

    /**
     * The items in the cart.
     */
    private Collection $items;

    /**
     * Create a new cart instance.
     */
    private function __construct(?Session $session = null)
    {
        $this->session = $session;

        if ($session === null) {
            $this->items = collect();
            return;
        }

        $this->loadFromSession($this->session);
    }

    /**
     * Add an item to the cart.
     */
    public function add(Buyable $buyable, int $quantity = 1): CartItem
    {
        if ($quantity <= 0) {
            return $this->set($buyable, $quantity);
        }

        $cartItem = $this->get($buyable);

        if ($cartItem === null) {
            return $this->set($buyable, $quantity);
        }

        $cartItem->setQuantity($cartItem->quantity + $quantity);

        $this->save();

        return $cartItem;
    }

    /**
     * Set the quantity of an item in the cart.
     */
    public function set(Buyable $buyable, int $quantity = 1): CartItem
    {
        if ($quantity <= 0) {
            $this->remove($buyable);

            return new CartItem($this, $buyable, $this->getItemId($buyable), 0);
        }

        $item = $this->get($buyable);

        if ($item !== null) {
            $item->setQuantity($quantity);

            return $item;
        }

        $id = $this->getItemId($buyable);
        $item = new CartItem($this, $buyable, $id, $quantity);

        if ($item->quantity > 0) {
            $this->items->put($id, $item);
        }

        $this->save();

        return $item;
    }

    /**
     * Remove the given model from cart.
     */
    public function remove(Buyable $buyable): void
    {
        $this->items->forget($this->getItemId($buyable));

        $this->save();
    }

    /**
     * Remove an item from the cart by its ID.
     */
    public function removeById(string $id): void
    {
        $this->items->forget($id);

        $this->save();
    }

    /**
     * Get the cart item associated with the given model.
     */
    public function get(Buyable $buyable): ?CartItem
    {
        return $this->items->get($this->getItemId($buyable));
    }

    /**
     * Get a cart item by its id.
     */
    public function getById(string $id): ?CartItem
    {
        return $this->items->get($id);
    }

    /**
     * Determine if a cart item is in the cart.
     */
    public function has(Buyable $buyable): bool
    {
        return $this->items->has($this->getItemId($buyable));
    }

    /**
     * Clear the current cart content.
     */
    public function clear(): void
    {
        $this->items = collect();

        $this->save();
    }

    /**
     * Check if the cart is empty.
     */
    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    /**
     * Get the content of the cart.
     */
    public function content(): Collection
    {
        return $this->items->values();
    }

    /**
     * Get the number of items in the cart.
     */
    public function count(): int
    {
        return $this->content()->sum('quantity');
    }

    /**
     * Get the total price of the items in the cart.
     */
    public function total(): float
    {
        return $this->content()->sum(fn (CartItem $item) => $item->total());
    }

    /**
     * Save the cart content to the associated session (if any).
     */
    public function save(): void
    {
        $this->session?->put('tebex.cart', $this->toArray());
    }

    /**
     * Create a new empty cart without an associated session.
     */
    public static function createEmpty(): self
    {
        return new self(null);
    }

    /**
     * Create a new cart instance and load the content from the given session.
     */
    public static function fromSession(Session $session): self
    {
        return new self($session);
    }

    /**
     * Get the item ID for a buyable model.
     */
    protected function getItemId(Buyable $buyable): string
    {
        return class_basename($buyable).'-'.$buyable->getId();
    }

    /**
     * Load the cart content from the session.
     */
    protected function loadFromSession(Session $session): void
    {
        $this->items = collect();

        $content = $session->get('tebex.cart', []);

        if (empty($content['items'])) {
            return;
        }

        collect($content['items'])->groupBy('type')->each(function (Collection $items, string $type) {
            try {
                // Get the shop service from the container
                $shopService = app(\Azuriom\Plugin\Tebex\Services\TebexShopService::class);

                // Create a collection to store the found packages
                $models = collect();

                // Get the IDs of the items
                $ids = $items->pluck('id');

                // For each ID, get the package from the shop service
                foreach ($ids as $id) {
                    $package = $shopService->getPackage($id);
                    if ($package) {
                        $models->put($id, $package);
                    }
                }

                $items->each(function ($item) use ($models) {
                    if (! $models->has($item['id'])) {
                        return;
                    }

                    $buyable = $models->get($item['id']);
                    $itemId = $item['itemId'];
                    $quantity = $item['quantity'];

                    $cartItem = new CartItem($this, $buyable, $itemId, $quantity);

                    if ($cartItem->quantity > 0) {
                        $this->items->put($item['itemId'], $cartItem);
                    }
                });
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error loading cart items', ['error' => $e->getMessage()]);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'items' => $this->items->toArray(),
        ];
    }
}
