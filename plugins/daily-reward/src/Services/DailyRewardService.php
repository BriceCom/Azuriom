<?php

namespace Azuriom\Plugin\DailyReward\Services;

use Azuriom\Models\User;
use Azuriom\Plugin\DailyReward\Models\DailyRewardClaim;
use Azuriom\Plugin\DailyReward\Models\DailyRewardDay;
use Azuriom\Plugin\DailyReward\Models\DailyRewardReward;
use Azuriom\Plugin\DailyReward\Models\DailyRewardUserState;
use Azuriom\Plugin\DailyReward\Notifications\DailyRewardClaimed;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DailyRewardService
{
    public function __construct(
        private readonly RewardDispatcher $dispatcher,
        private readonly DiscordWebhookNotifier $webhookNotifier
    ) {
    }

    /**
     * Return the current reward status for a user.
     *
     * @return array<string, mixed>
     */
    public function getStatus(User $user): array
    {
        $state = DailyRewardUserState::query()->where('user_id', $user->id)->first();
        $now = now();
        $mode = $this->resetMode();
        $availability = $this->availability($state?->last_claim_at, $mode, $now);

        return [
            'streak' => $state?->streak_count ?? 0,
            'max_streak' => $state?->max_streak ?? 0,
            'next_day_number' => $state?->next_day_number ?? 1,
            'last_claim_at' => $state?->last_claim_at,
            'can_claim' => $availability['can_claim'],
            'next_claim_at' => $availability['next_claim_at'],
        ];
    }

    /**
     * Create missing days and optionally bootstrap one reward per day.
     */
    public function synchronizeDays(int $cycleLength, float $defaultMoney, bool $createDefaultRewards): void
    {
        $cycleLength = max(1, $cycleLength);

        DailyRewardDay::query()->where('day_number', '<=', $cycleLength)->update(['is_enabled' => true]);
        DailyRewardDay::query()->where('day_number', '>', $cycleLength)->update(['is_enabled' => false]);

        for ($dayNumber = 1; $dayNumber <= $cycleLength; $dayNumber++) {
            $day = DailyRewardDay::query()->firstOrCreate(
                ['day_number' => $dayNumber],
                [
                    'label' => trans('daily-reward::messages.day_label', ['day' => $dayNumber]),
                    'is_enabled' => true,
                ],
            );

            if (! $createDefaultRewards || $day->rewards()->enabled()->exists()) {
                continue;
            }

            $day->rewards()->create([
                'name' => trans('daily-reward::messages.default_reward_name', ['day' => $dayNumber]),
                'type' => DailyRewardReward::TYPE_MONEY,
                'money' => $defaultMoney,
                'need_online' => false,
                'is_enabled' => true,
            ]);
        }
    }

    /**
     * Claim today reward for a user.
     *
     * @return array<string, mixed>
     */
    public function claim(User $user): array
    {
        if (! setting('daily_reward.enabled', true)) {
            return [
                'success' => false,
                'message' => trans('daily-reward::messages.claim.disabled'),
            ];
        }

        $cycleLength = max(1, (int) setting('daily_reward.cycle_length', 7));
        $defaultMoney = (float) setting('daily_reward.default_money', 100);
        $mode = $this->resetMode();

        $result = DB::transaction(function () use ($user, $cycleLength, $defaultMoney, $mode) {
            $state = DailyRewardUserState::query()
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if ($state === null) {
                try {
                    $state = DailyRewardUserState::query()->create([
                        'user_id' => $user->id,
                        'streak_count' => 0,
                        'max_streak' => 0,
                        'next_day_number' => 1,
                    ]);
                } catch (QueryException) {
                    $state = DailyRewardUserState::query()
                        ->where('user_id', $user->id)
                        ->lockForUpdate()
                        ->firstOrFail();
                }
            }

            $now = now();
            $availability = $this->availability($state->last_claim_at, $mode, $now);

            if (! $availability['can_claim']) {
                return [
                    'success' => false,
                    'message' => trans('daily-reward::messages.claim.cooldown'),
                    'next_claim_at' => $availability['next_claim_at'],
                ];
            }

            $streakBefore = (int) $state->streak_count;
            $streakAfter = $this->nextStreak($state->last_claim_at, $mode, $now, $streakBefore);
            $dayNumber = $this->normalizedDay((int) $state->next_day_number, $cycleLength);

            $day = DailyRewardDay::query()->firstOrCreate(
                ['day_number' => $dayNumber],
                [
                    'label' => trans('daily-reward::messages.day_label', ['day' => $dayNumber]),
                    'is_enabled' => true,
                ]
            );

            if (! $day->is_enabled) {
                return [
                    'success' => false,
                    'message' => trans('daily-reward::messages.claim.day_disabled'),
                ];
            }

            $rewards = $day->rewards()->enabled()->with('servers')->get();

            if ($rewards->isEmpty()) {
                $reward = $day->rewards()->create([
                    'name' => trans('daily-reward::messages.default_reward_name', ['day' => $dayNumber]),
                    'type' => DailyRewardReward::TYPE_MONEY,
                    'money' => $defaultMoney,
                    'need_online' => false,
                    'is_enabled' => true,
                ]);

                $rewards = collect([$reward->load('servers')]);
            }

            $summary = $this->dispatcher->dispatch($user, $rewards, $dayNumber, $streakAfter);
            $nextDayNumber = $dayNumber >= $cycleLength ? 1 : $dayNumber + 1;

            $state->update([
                'streak_count' => $streakAfter,
                'max_streak' => max((int) $state->max_streak, $streakAfter),
                'next_day_number' => $nextDayNumber,
                'last_claim_at' => $now,
            ]);

            DailyRewardClaim::query()->create([
                'user_id' => $user->id,
                'day_number' => $dayNumber,
                'streak_before' => $streakBefore,
                'streak_after' => $streakAfter,
                'rewards_snapshot' => $summary,
                'claimed_at' => $now,
            ]);

            return [
                'success' => true,
                'message' => trans('daily-reward::messages.claim.success'),
                'day_number' => $dayNumber,
                'streak' => $streakAfter,
                'summary' => $summary,
            ];
        });

        if (! ($result['success'] ?? false)) {
            return $result;
        }

        $money = (float) ($result['summary']['money'] ?? 0);
        $commandsCount = count($result['summary']['commands'] ?? []);

        $this->webhookNotifier->sendClaim(
            $user,
            (int) $result['day_number'],
            (int) $result['streak'],
            $money,
            $commandsCount
        );

        if (setting('daily_reward.mail_notifications', false)) {
            rescue(fn () => $user->notify(new DailyRewardClaimed(
                (int) $result['day_number'],
                (int) $result['streak'],
                $money,
                $commandsCount,
            )));
        }

        return $result;
    }

    /**
     * @return array{can_claim: bool, next_claim_at: Carbon|null}
     */
    private function availability(?Carbon $lastClaimAt, string $mode, Carbon $now): array
    {
        if ($lastClaimAt === null) {
            return ['can_claim' => true, 'next_claim_at' => null];
        }

        if ($mode === 'rolling_24h') {
            $nextClaimAt = $lastClaimAt->copy()->addDay();
            $canClaim = $now->greaterThanOrEqualTo($nextClaimAt);

            return [
                'can_claim' => $canClaim,
                'next_claim_at' => $canClaim ? null : $nextClaimAt,
            ];
        }

        if ($lastClaimAt->isSameDay($now)) {
            return [
                'can_claim' => false,
                'next_claim_at' => $lastClaimAt->copy()->addDay()->startOfDay(),
            ];
        }

        return ['can_claim' => true, 'next_claim_at' => null];
    }

    private function nextStreak(?Carbon $lastClaimAt, string $mode, Carbon $now, int $currentStreak): int
    {
        if ($lastClaimAt === null) {
            return 1;
        }

        if ($mode === 'rolling_24h') {
            $hours = $lastClaimAt->diffInHours($now);

            if ($hours > 48) {
                return 1;
            }

            return $currentStreak + 1;
        }

        if ($lastClaimAt->isSameDay($now->copy()->subDay())) {
            return $currentStreak + 1;
        }

        return 1;
    }

    private function normalizedDay(int $nextDayNumber, int $cycleLength): int
    {
        if ($nextDayNumber < 1) {
            return 1;
        }

        return $nextDayNumber > $cycleLength ? 1 : $nextDayNumber;
    }

    private function resetMode(): string
    {
        $mode = setting('daily_reward.reset_mode', 'midnight');

        return in_array($mode, ['midnight', 'rolling_24h'], true) ? $mode : 'midnight';
    }
}
