<?php

namespace Azuriom\Plugin\AlternativeCurrency\Models\Traits;


use Azuriom\Plugin\AlternativeCurrency\Models\History;

trait InteractsWithAmount
{
    public function addAmount(float $amount): int
    {
        History::create([
            'user_id' => $this->user_id,
            'coin_id' => $this->coin_id,
            'amount' => $amount,
            'type' => 'give'
        ]);

        return $this->increment('amount', $amount);
    }

    public function removeAmount(float $amount): int
    {
        History::create([
            'user_id' => $this->user_id,
            'coin_id' => $this->coin_id,
            'amount' => $amount,
            'type' => 'take'
        ]);

        return $this->decrement('amount', $amount);
    }

    public function hasAmount(float $amount): bool
    {
        return $this->amount >= $amount;
    }
}
