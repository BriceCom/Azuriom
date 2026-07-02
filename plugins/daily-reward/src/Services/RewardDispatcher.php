<?php

namespace Azuriom\Plugin\DailyReward\Services;

use Azuriom\Models\User;
use Azuriom\Plugin\DailyReward\Models\DailyRewardReward;
use Throwable;
use Illuminate\Support\Collection;

class RewardDispatcher
{
    /**
     * Dispatch rewards to a user and return a summary.
     *
     * @param  Collection<int, DailyRewardReward>  $rewards
     * @return array<string, mixed>
     */
    public function dispatch(User $user, Collection $rewards, int $dayNumber, int $streak): array
    {
        $summary = [
            'money' => 0.0,
            'commands' => [],
            'rewards' => [],
            'errors' => [],
        ];

        foreach ($rewards as $reward) {
            $rewardSummary = [
                'id' => $reward->id,
                'name' => $reward->name,
                'type' => $reward->type,
                'money' => 0.0,
                'commands' => [],
            ];

            if ($reward->type === DailyRewardReward::TYPE_MONEY && $reward->money !== null && $reward->money > 0) {
                try {
                    $user->addMoney((float) $reward->money);
                    $rewardSummary['money'] = (float) $reward->money;
                    $summary['money'] += (float) $reward->money;
                } catch (Throwable $e) {
                    $summary['errors'][] = trans('daily-reward::messages.claim.dispatch_money_failed', [
                        'reward' => $reward->name,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            if ($reward->type === DailyRewardReward::TYPE_COMMAND) {
                $commands = is_array($reward->commands) ? $reward->commands : [];
                $commands = array_values(array_filter($commands, static fn ($command) => is_string($command) && $command !== ''));

                if (empty($commands)) {
                    $summary['rewards'][] = $rewardSummary;
                    continue;
                }

                $processedCommands = array_map(
                    fn (string $command) => $this->interpolateCommand($command, $user->name, $reward->name, $dayNumber, $streak),
                    $commands
                );

                try {
                    foreach ($reward->servers as $server) {
                        $server->bridge()->sendCommands($processedCommands, $user, $reward->need_online);
                    }

                    $rewardSummary['commands'] = $processedCommands;
                    $summary['commands'] = array_merge($summary['commands'], $processedCommands);
                } catch (Throwable $e) {
                    $summary['errors'][] = trans('daily-reward::messages.claim.dispatch_commands_failed', [
                        'reward' => $reward->name,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $summary['rewards'][] = $rewardSummary;
        }

        return $summary;
    }

    private function interpolateCommand(string $command, string $player, string $reward, int $dayNumber, int $streak): string
    {
        return str_replace(
            ['{player}', '{user}', '{reward}', '{day}', '{streak}'],
            [$player, $player, $reward, (string) $dayNumber, (string) $streak],
            $command
        );
    }
}
