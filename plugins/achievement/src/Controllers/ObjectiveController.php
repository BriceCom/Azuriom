<?php

namespace Azuriom\Plugin\Achievement\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\Achievement\Models\Objective;
use Azuriom\Plugin\Achievement\Models\UserObjective;
use Azuriom\Plugin\Achievement\Models\UserTrophyPoints;
use Azuriom\Plugin\Achievement\Services\ObjectiveService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ObjectiveController extends Controller
{
    protected ObjectiveService $objectiveService;

    public function __construct(ObjectiveService $objectiveService)
    {
        $this->objectiveService = $objectiveService;
    }

    public function index()
    {
        $topUsersQuery = UserTrophyPoints::with('user')
            ->where('trophy_points', '>', 0)
            ->orderByDesc('trophy_points')
            ->limit(15)
            ->get();

        $topUsers = $topUsersQuery->map(function ($userTrophy) {
            $user = $userTrophy->user;
            $user->trophy_points = $userTrophy->trophy_points;
            return $user;
        });

        $userPosition = null;
        $userTrophyPoints = 0;

        if (Auth::check()) {
            $user = Auth::user();
            $userTrophyPoints = achievement_user_trophy_points($user);

            if ($userTrophyPoints > 0) {
                $userPosition = UserTrophyPoints::where('trophy_points', '>', $userTrophyPoints)
                        ->count() + 1;
            }
        }

        return view('achievement::index', [
            'topUsers' => $topUsers,
            'userPosition' => $userPosition,
            'userTrophyPoints' => $userTrophyPoints,
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        $allObjectives = Objective::enabled()->visibleToUser($user)->get();
        $claimedUserObjectives = $this->getClaimedUserObjectives(Auth::id(), true);
        $userObjectives = $this->processUserObjectives($allObjectives, $claimedUserObjectives, $user, true);

        return view('achievement::profile.index', [
            'all' => $userObjectives,
            'completed' => $userObjectives->where('status', UserObjective::STATUS_COMPLETED),
            'claimed' => $userObjectives->where('status', UserObjective::STATUS_CLAIMED),
        ]);
    }

    public function claimReward(Objective $objective)
    {
        $user = Auth::user();

        Log::info("User #{$user->id} attempting to claim reward for objective #{$objective->id}");

        // Check if user can see this objective
        $visibleObjectives = Objective::enabled()->visibleToUser($user)->where('id', $objective->id)->exists();
        if (!$visibleObjectives) {
            Log::info("User #{$user->id} cannot see objective #{$objective->id}");
            return redirect()->route('achievement.profile')
                ->with('error', trans('achievement::messages.claim.not_found'));
        }

        if (!$this->objectiveService->canClaimReward($user, $objective)) {
            $existingUserObjective = UserObjective::where('user_id', $user->id)
                ->where('objective_id', $objective->id)
                ->where('status', UserObjective::STATUS_CLAIMED)
                ->first();

            if ($existingUserObjective) {
                Log::info("User #{$user->id} has already claimed objective #{$objective->id}");
                return redirect()->route('achievement.profile')
                    ->with('error', trans('achievement::messages.claim.already_completed'));
            }

            Log::info("User #{$user->id} does not meet requirements for objective #{$objective->id}");
            return redirect()->route('achievement.profile')
                ->with('error', trans('achievement::messages.claim.not_met'));
        }

        $progress = $this->objectiveService->calculateProgress($user, $objective);
        Log::info("Creating UserObjective record for user #{$user->id}, objective #{$objective->id} with progress {$progress}");

        try {
            $userObjective = UserObjective::create([
                'user_id' => $user->id,
                'objective_id' => $objective->id,
                'progress' => $progress,
                'status' => UserObjective::STATUS_CLAIMED,
                'completed_at' => now(),
            ]);

            Log::info("UserObjective record created with ID #{$userObjective->id}");

            // Store initial values for diagnostic purposes
            $initialMoney = $user->money;
            $initialTrophyPoints = achievement_user_trophy_points($user);

            // Give rewards
            $this->objectiveService->giveRewards($user, $objective);

            // Refresh user to get updated values
            $user->refresh();
            $finalTrophyPoints = achievement_user_trophy_points($user);

            // Log the changes for debugging
            Log::info("Reward results for user #{$user->id}: Money {$initialMoney}->{$user->money}, Trophy points {$initialTrophyPoints}->{$finalTrophyPoints}");

            return redirect()->route('achievement.profile')
                ->with('success', trans('achievement::messages.claim.success'));

        } catch (\Exception $e) {
            Log::error("Failed to claim reward for user #{$user->id}, objective #{$objective->id}: {$e->getMessage()}");
            Log::error("Stack trace: {$e->getTraceAsString()}");

            return redirect()->route('achievement.profile')
                ->with('error', trans('achievement::messages.claim.error'));
        }
    }
    private function getClaimedUserObjectives(int $userId, bool $withObjective = false)
    {
        $query = UserObjective::where('user_id', $userId)
            ->where('status', UserObjective::STATUS_CLAIMED);

        if ($withObjective) {
            $query->with('objective');
        }

        return $query->get()->keyBy('objective_id');
    }

    private function processUserObjectives($objectives, $claimedUserObjectives, $user, bool $withRelation = false)
    {
        $userObjectives = collect();

        foreach ($objectives as $objective) {
            if ($claimedUserObjectives->has($objective->id)) {
                $userObjective = $claimedUserObjectives->get($objective->id);

                if ($withRelation) {
                    $userObjective->objective = $objective;
                    $userObjectives->push($userObjective);
                } else {
                    $userObjectives->put($objective->id, $userObjective);
                }
            } else {
                $progress = $this->objectiveService->calculateProgress($user, $objective);
                $status = $this->determineObjectiveStatus($progress, $objective->amount);

                $userObjective = new UserObjective([
                    'user_id' => $user->id,
                    'objective_id' => $objective->id,
                    'progress' => $progress,
                    'status' => $status,
                ]);

                if ($withRelation) {
                    $userObjective->objective = $objective;
                    $userObjectives->push($userObjective);
                } else {
                    $userObjectives->put($objective->id, $userObjective);
                }
            }
        }

        return $userObjectives;
    }

    private function determineObjectiveStatus(int $progress, int $requiredAmount): string
    {
        if ($progress >= $requiredAmount) {
            return UserObjective::STATUS_COMPLETED;
        }

        if ($progress > 0) {
            return UserObjective::STATUS_IN_PROGRESS;
        }

        return UserObjective::STATUS_NOT_STARTED;
    }
}
