<?php

namespace Azuriom\Plugin\Tebex\Models;

/**
 * Interface for payment items.
 * This is a simplified version of the Shop plugin's PaymentItem class.
 */
interface PaymentItemInterface
{
    /**
     * Get the payment associated to this payment item.
     */
    public function payment();

    /**
     * Get the purchased model.
     */
    public function buyable();

    /**
     * Get the user who made the payment.
     */
    public function getUser();
}
