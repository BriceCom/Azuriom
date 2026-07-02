<?php

namespace Azuriom\Plugin\Achievement\Services;

use Azuriom\Models\Server;
use Azuriom\Models\User;
use Azuriom\Plugin\Achievement\Models\Objective;
use Azuriom\Plugin\Achievement\Models\UserObjective;
use Azuriom\Plugin\ScratchGame\Models\ScratchCard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ObjectiveService
{
    protected ObjectiveCheckerService $checkerService;

    public function __construct(ObjectiveCheckerService $checkerService)
    {
        $this->checkerService = $checkerService;
    }

    public function calculateProgress(User $user, Objective $objective): int
    {
        if (!$this->isPluginEnabled($objective->hook)) {
            return 0;
        }

        return $this->checkerService->checkProgress($user, $objective);
    }

    protected function isPluginEnabled(string $hook): bool
    {
        return $hook === 'azuriom' || $hook === 'post' || plugins()->isEnabled($hook);
    }

    public function giveRewards(User $user, Objective $objective): void
    {
        if (empty($objective->rewards)) {
            Log::info(trans('achievement::admin.logs.no_rewards_defined', ['id' => $objective->id]));
            return;
        }

        Log::info(trans('achievement::admin.logs.starting_reward_process', ['objective_id' => $objective->id, 'user_id' => $user->id]));
        Log::info(trans('achievement::admin.logs.rewards_list', ['rewards' => json_encode($objective->rewards)]));

        DB::beginTransaction();

        try {
            foreach ($objective->rewards as $reward) {
                $this->processReward($user, $reward, $objective);
            }

            DB::commit();
            Log::info(trans('achievement::admin.logs.successfully_committed', ['objective_id' => $objective->id, 'user_id' => $user->id]));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(trans('achievement::admin.logs.failed_rewards', ['objective_id' => $objective->id, 'user_id' => $user->id, 'error' => $e->getMessage()]));
            Log::error(trans('achievement::admin.logs.exception_stack_trace', ['trace' => $e->getTraceAsString()]));
        }
    }

    protected function processReward(User $user, array $reward, Objective $objective): void
    {
        $type = $reward['type'] ?? null;
        $value = $reward['value'] ?? null;

        if (!$type) {
            Log::warning(trans('achievement::admin.logs.missing_reward_type', ['user_id' => $user->id, 'reward' => json_encode($reward)]));
            return;
        }

        if (!$value) {
            Log::warning(trans('achievement::admin.logs.missing_value', ['type' => $type, 'user_id' => $user->id, 'reward' => json_encode($reward)]));
            return;
        }

        // Validate reward data based on type
        switch ($type) {
            case 'money':
                if (!is_numeric($value)) {
                    Log::warning(trans('achievement::admin.logs.invalid_money_value', ['value' => $value, 'user_id' => $user->id]));
                    return;
                }

                $user->addMoney($value);
                Log::info(trans('achievement::admin.logs.added_money', ['value' => $value, 'user_id' => $user->id]));
                break;
            case 'command':
                if (!is_string($value) || empty(trim($value))) {
                    Log::warning(trans('achievement::admin.logs.invalid_command_value', ['user_id' => $user->id, 'value' => $value]));
                    return;
                }

                $serverId = $reward['server_id'] ?? null;
                if (!$serverId) {
                    Log::warning(trans('achievement::admin.logs.missing_server_id', ['user_id' => $user->id]));
                    return;
                }

                $this->executeCommand($user, $value, $serverId, $objective);
                break;
            case 'trophy':
                if (!is_numeric($value)) {
                    Log::warning(trans('achievement::admin.logs.invalid_trophy_value', ['value' => $value, 'user_id' => $user->id]));
                    return;
                }
                achievement_add_trophy_points($user, (int) $value);
                Log::info(trans('achievement::admin.logs.added_trophy_points', ['value' => $value, 'user_id' => $user->id]));
                break;
            case 'scratch_game':
                if (!function_exists('scratch_game_give_ticket') || !class_exists(ScratchCard::class)) {
                    Log::warning(trans('achievement::admin.logs.scratch_game_unavailable', ['user_id' => $user->id]));
                    return;
                }

                if (!is_numeric($value)) {
                    Log::warning(trans('achievement::admin.logs.invalid_scratch_card', ['value' => $value, 'user_id' => $user->id]));
                    return;
                }

                $card = ScratchCard::query()->whereKey((int) $value)->first();

                if ($card === null || ! $card->is_enabled) {
                    Log::warning(trans('achievement::admin.logs.invalid_scratch_card', ['value' => $value, 'user_id' => $user->id]));
                    return;
                }

                scratch_game_give_ticket($card, $user, 0.0, null, true);
                Log::info(trans('achievement::admin.logs.added_scratch_card', [
                    'card_id' => $card->id,
                    'user_id' => $user->id,
                ]));
                break;
            default:
                Log::warning(trans('achievement::admin.logs.unknown_reward_type', ['type' => $type, 'user_id' => $user->id]));
                break;
        }
    }

    protected function executeCommand(User $user, string $command, ?int $serverId, Objective $objective): void
    {
        if (!$serverId) {
            Log::warning(trans('achievement::admin.logs.cannot_execute_no_server', ['user_id' => $user->id]));
            return;
        }

        $server = Server::find($serverId);

        if (!$server) {
            Log::warning(trans('achievement::admin.logs.server_not_found', ['user_id' => $user->id, 'server_id' => $serverId]));
            return;
        }

        // Use isOnline() to check if server is responsive instead of isEnabled() which doesn't exist
        if (!$server->isOnline()) {
            Log::warning(trans('achievement::admin.logs.server_not_online', ['user_id' => $user->id, 'server_id' => $serverId]));
            return;
        }

        // Replace placeholders in the command
        $command = str_replace(
            ['{player}', '{objective_name}'],
            [$user->name, $objective->name],
            $command
        );

        try {
            $server->bridge()->sendCommands([$command], $user, true);
            Log::info(trans('achievement::admin.logs.successfully_executed_command', ['user_id' => $user->id, 'server_id' => $serverId]));
        } catch (\Exception $e) {
            Log::error(trans('achievement::admin.logs.failed_execute_command', ['user_id' => $user->id, 'server_id' => $serverId, 'error' => $e->getMessage()]));
        }
    }

    public function canClaimReward(User $user, Objective $objective): bool
    {
        $existingUserObjective = UserObjective::where('user_id', $user->id)
            ->where('objective_id', $objective->id)
            ->where('status', UserObjective::STATUS_CLAIMED)
            ->first();

        if ($existingUserObjective) {
            return false;
        }

        $progress = $this->calculateProgress($user, $objective);

        return $progress >= $objective->amount;
    }
}
