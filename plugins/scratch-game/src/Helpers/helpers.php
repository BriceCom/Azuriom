<?php

use Azuriom\Models\User;
use Azuriom\Plugin\ScratchGame\Models\ScratchCard;
use Azuriom\Plugin\ScratchGame\Models\ScratchLog;
use Azuriom\Plugin\ScratchGame\Models\ScratchReward;
use Illuminate\Support\Collection;

/*
|--------------------------------------------------------------------------
| Helper functions
|--------------------------------------------------------------------------
|
| Helper functions for the Scratch Game plugin.
| These functions are loaded by Composer and are globally available.
|
*/

if (! function_exists('scratch_game_available_cards')) {
    /**
     * Get all enabled scratch cards, optionally filtered by user eligibility.
     *
     * @param  User|null  $user
     * @param  bool  $respectRoles
     * @return Collection<int, ScratchCard>
     */
    function scratch_game_available_cards(?User $user = null, bool $respectRoles = true): Collection
    {
        $cards = ScratchCard::with([
            'roles',
            'rewards' => fn ($query) => $query->enabled()->orderByDesc('chance'),
        ])
            ->enabled()
            ->orderBy('price')
            ->orderBy('name')
            ->get();

        if (! $respectRoles) {
            return $cards;
        }

        return $cards->filter(fn (ScratchCard $card) => $card->isUserEligible($user))->values();
    }
}

if (! function_exists('scratch_game_give_ticket')) {
    /**
     * Give a specific scratch card play to a user (free by default).
     *
     * This creates a log entry and selects a reward if not provided.
     *
     * @param  ScratchCard  $card
     * @param  User  $user
     * @param  float  $pricePaid
     * @param  ScratchReward|null  $reward
     * @param  bool  $ignoreEligibility
     * @param  string|null  $ip
     * @param  string|null  $userAgent
     */
    function scratch_game_give_ticket(
        ScratchCard $card,
        User $user,
        float $pricePaid = 0.0,
        ?ScratchReward $reward = null,
        bool $ignoreEligibility = false,
        ?string $ip = null,
        ?string $userAgent = null
    ): ScratchLog {
        if (! $card->is_enabled) {
            throw new InvalidArgumentException('Scratch card is disabled.');
        }

        $card->loadMissing(['roles']);

        if (! $ignoreEligibility && ! $card->isUserEligible($user)) {
            throw new InvalidArgumentException('User is not eligible for this scratch card.');
        }

        if ($reward === null) {
            $eligibleRewards = $card->enabledRewards()->with('servers')->get();
            $reward = ScratchReward::selectRandomReward($eligibleRewards);
        }

        return ScratchLog::logPlay(
            $card,
            $user,
            $reward,
            $pricePaid,
            0,
            [],
            $ip,
            $userAgent
        );
    }
}
