<?php

namespace Azuriom\Plugin\Hunt\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Hunt\Models\Hunt;
use Azuriom\Plugin\Hunt\Models\HuntLog;
use Azuriom\Plugin\Hunt\Models\HuntReward;
use Azuriom\Plugin\Hunt\Models\HuntUserDaily;
use Carbon\Carbon;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HuntController extends Controller
{
    /**
     * Display the hunt leaderboards.
     */
    public function index()
    {
        $now = now();

        $withEnabledRewards = ['rewards' => function ($query) {
            $query->enabled();
        }];

        $activeHunts = Hunt::active()
            ->current()
            ->byPriority()
            ->with($withEnabledRewards)
            ->get();

        $currentHunt = $activeHunts->first();

        $currentHunts = Hunt::query()
            ->where('is_archived', false)
            ->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->with($withEnabledRewards)
            ->orderByDesc('priority')
            ->orderBy('start_date')
            ->get();

        $upcomingHunts = Hunt::query()
            ->where('is_archived', false)
            ->where('is_active', true)
            ->where('start_date', '>', $now)
            ->with($withEnabledRewards)
            ->orderBy('start_date')
            ->orderByDesc('priority')
            ->get();

        $finalizedHunts = Hunt::query()
            ->where('is_archived', false)
            ->where(function ($query) use ($now) {
                $query->where('is_active', false)
                    ->orWhere('end_date', '<', $now);
            })
            ->with($withEnabledRewards)
            ->orderByDesc('end_date')
            ->orderByDesc('priority')
            ->get();

        $allHunts = $currentHunts
            ->concat($upcomingHunts)
            ->concat($finalizedHunts)
            ->values();

        return view('hunt::index', [
            'activeHunts' => $activeHunts,
            'currentHunt' => $currentHunt,
            'allHunts' => $allHunts,
        ]);
    }

    /**
     * Show hunt details and leaderboard.
     */
    public function show(Hunt $hunt)
    {
        if ($hunt->is_archived) {
            abort(404);
        }

        $hunt->load(['rewards' => function ($query) {
            $query->enabled();
        }]);

        $stats = HuntLog::getHuntStats($hunt);

        $leaderboard = HuntLog::getLeaderboard($hunt, 50);

        $userProgress = null;
        $userStats = null;
        $userPosition = null;
        if (Auth::check()) {
            $userDaily = $hunt->getUserDaily(Auth::user());
            $userProgress = $userDaily?->getTodayProgress();
            $userStats = HuntLog::getUserStats($hunt, Auth::user());

            $userPosition = $leaderboard->search(function ($item) {
                return $item->user_id === Auth::id();
            });
            $userPosition = $userPosition !== false ? $userPosition + 1 : null;
        }

        return view('hunt::show', [
            'hunt' => $hunt,
            'stats' => $stats,
            'leaderboard' => $leaderboard,
            'userProgress' => $userProgress,
            'userStats' => $userStats,
            'userPosition' => $userPosition,
        ]);
    }

    /**
     * Process hunt claim.
     */
    public function claim(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'not_authenticated',
                'message' => trans('hunt::messages.not_authenticated'),
            ], 401);
        }

        $user = Auth::user();
        $hunt = Hunt::getCurrentHunt();

        if (!$hunt) {
            return response()->json([
                'success' => false,
                'error' => 'no_active_hunt',
                'message' => trans('hunt::messages.no_active_hunt'),
            ], 404);
        }
        try {
            return DB::transaction(function () use ($hunt, $user, $request) {
                $lockedHunt = Hunt::query()->lockForUpdate()->find($hunt->id);

                if ($lockedHunt === null || ! $lockedHunt->isCurrentlyActive()) {
                    return response()->json([
                        'success' => false,
                        'error' => 'hunt_not_active',
                        'message' => trans('hunt::messages.hunt_not_active'),
                    ], 400);
                }

                if ($lockedHunt->hasReachedGlobalCap()) {
                    return response()->json([
                        'success' => false,
                        'error' => 'global_cap_reached',
                        'message' => trans('hunt::messages.global_cap_reached'),
                        'hunt' => [
                            'id' => $lockedHunt->id,
                            'name' => $lockedHunt->name,
                            'slug' => $lockedHunt->slug,
                            'global_cap' => $lockedHunt->global_cap,
                        ],
                    ], 400);
                }

                $today = Carbon::today()->toDateString();
                $userDaily = HuntUserDaily::query()
                    ->where('hunt_id', $lockedHunt->id)
                    ->where('user_id', $user->id)
                    ->whereDate('date', $today)
                    ->lockForUpdate()
                    ->first();

                if ($userDaily === null) {
                    try {
                        $userDaily = HuntUserDaily::create([
                            'hunt_id' => $lockedHunt->id,
                            'user_id' => $user->id,
                            'date' => $today,
                            'claims_count' => 0,
                            'money_received_today' => 0,
                        ]);
                    } catch (QueryException $e) {
                        $userDaily = HuntUserDaily::query()
                            ->where('hunt_id', $lockedHunt->id)
                            ->where('user_id', $user->id)
                            ->whereDate('date', $today)
                            ->lockForUpdate()
                            ->firstOrFail();
                    }
                }

                if ($userDaily->claims_count >= $lockedHunt->max_per_day) {
                    $remainingClaims = max(0, $lockedHunt->max_per_day - (int) $userDaily->claims_count);

                    return response()->json([
                        'success' => false,
                        'error' => 'daily_limit_reached',
                        'message' => trans('hunt::messages.daily_limit_reached'),
                        'user_progress' => [
                            'claims_today' => (int) $userDaily->claims_count,
                            'max_claims' => (int) $lockedHunt->max_per_day,
                            'remaining_claims' => $remainingClaims,
                            'money_today' => (float) ($userDaily->money_received_today ?? 0),
                            'last_claim' => $userDaily->last_claim_at,
                            'on_cooldown' => $userDaily->cooldown_until
                                ? Carbon::now()->lt($userDaily->cooldown_until)
                                : false,
                        ],
                    ], 400);
                }

                if ($userDaily->cooldown_until && Carbon::now()->lt($userDaily->cooldown_until)) {
                    $cooldownRemaining = max(0, Carbon::now()->diffInMinutes($userDaily->cooldown_until));

                    return response()->json([
                        'success' => false,
                        'error' => 'cooldown_active',
                        'message' => trans('hunt::messages.cooldown_active'),
                        'cooldown_remaining' => $cooldownRemaining,
                    ], 400);
                }

                if (! $this->checkSpawnRate((float) $lockedHunt->spawn_rate)) {
                    $userDaily->setCooldown();

                    return response()->json([
                        'success' => false,
                        'error' => 'spawn_failed',
                        'message' => trans('hunt::messages.spawn_failed'),
                        'cooldown_minutes' => $lockedHunt->cooldown_minutes,
                    ]);
                }

                $eligibleRewards = HuntReward::getEligibleRewards($lockedHunt, $user);
                $selectedReward = HuntReward::selectRandomReward($eligibleRewards);

                $totalMoneyGiven = 0;
                $commandsExecuted = [];
                $errors = [];

                if ($selectedReward) {
                    $result = $selectedReward->dispatch($user, $lockedHunt);
                    $totalMoneyGiven = $result['money_given'];
                    $commandsExecuted = $result['commands_executed'];
                    $errors = $result['errors'];
                }

                HuntLog::logClaim(
                    $lockedHunt,
                    $user,
                    $selectedReward,
                    $totalMoneyGiven,
                    $commandsExecuted,
                    $request->ip(),
                    $request->hasSession() ? $request->session()->getId() : null,
                    $request->userAgent()
                );

                $userDaily->recordClaim($totalMoneyGiven);

                $response = [
                    'success' => true,
                    'hunt' => [
                        'id' => $lockedHunt->id,
                        'name' => $lockedHunt->name,
                        'slug' => $lockedHunt->slug,
                    ],
                    'reward' => $selectedReward ? [
                        'name' => $selectedReward->name,
                        'money' => $totalMoneyGiven,
                        'commands_count' => count($commandsExecuted),
                    ] : null,
                    'user_progress' => $userDaily->getTodayProgress(),
                    'global_cap' => $lockedHunt->global_cap,
                    'global_claims' => HuntLog::where('hunt_id', $lockedHunt->id)->count(),
                ];

                if (! empty($errors)) {
                    $response['warnings'] = $errors;
                }

                return response()->json($response);
            }, 3);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'error' => 'unknown_error',
                'message' => config('app.debug') ? $e->getMessage() : trans('hunt::messages.unknown_error'),
            ], 500);
        }
    }

    /**
     * Check spawn rate probability.
     */
    private function checkSpawnRate(float $spawnRate): bool
    {
        $random = mt_rand(1, 10000) / 100;
        return $random <= $spawnRate;
    }

    /**
     * Handle claim errors.
     */
    private function handleClaimError(string $reason, Hunt $hunt, $user): \Illuminate\Http\JsonResponse
    {
        switch ($reason) {
            case 'hunt_not_active':
                return response()->json([
                    'success' => false,
                    'error' => 'hunt_not_active',
                    'message' => trans('hunt::messages.hunt_not_active'),
                ], 400);

            case 'global_cap_reached':
                return response()->json([
                    'success' => false,
                    'error' => 'global_cap_reached',
                    'message' => trans('hunt::messages.global_cap_reached'),
                    'hunt' => [
                        'id' => $hunt->id,
                        'name' => $hunt->name,
                        'slug' => $hunt->slug,
                        'global_cap' => $hunt->global_cap,
                    ],
                ], 400);

            case 'daily_limit_reached':
                $userDaily = $hunt->getUserDaily($user);
                return response()->json([
                    'success' => false,
                    'error' => 'daily_limit_reached',
                    'message' => trans('hunt::messages.daily_limit_reached'),
                    'user_progress' => $userDaily?->getTodayProgress(),
                ], 400);

            case 'cooldown_active':
                $userDaily = $hunt->getUserDaily($user);
                return response()->json([
                    'success' => false,
                    'error' => 'cooldown_active',
                    'message' => trans('hunt::messages.cooldown_active'),
                    'cooldown_remaining' => $userDaily?->getCooldownRemainingMinutes(),
                ], 400);

            default:
                return response()->json([
                    'success' => false,
                    'error' => 'unknown_error',
                    'message' => trans('hunt::messages.unknown_error'),
                ], 400);
        }
    }

    /**
     * Get hunt data for JavaScript (AJAX endpoint).
     */
    public function getHuntData(Request $request)
    {
        $currentHunt = Hunt::getCurrentHunt();

        if (!$currentHunt) {
            return response()->json(['hunt' => null]);
        }

        $data = [
            'hunt' => [
                'id' => $currentHunt->id,
                'name' => $currentHunt->name,
                'slug' => $currentHunt->slug,
                'image' => $currentHunt->imageUrl(),
                'spawn_rate' => $currentHunt->spawn_rate,
                'spawn_delay_seconds' => $currentHunt->spawn_delay_seconds ?? 0,
                'global_cap' => $currentHunt->global_cap,
                'global_claims' => $currentHunt->logs()->count(),
                'max_per_day' => $currentHunt->max_per_day,
                'is_capped' => $currentHunt->hasReachedGlobalCap(),
            ],
        ];

        if (Auth::check()) {
            $userDaily = $currentHunt->getUserDaily(Auth::user());
            $data['user'] = [
                'authenticated' => true,
                'progress' => $userDaily?->getTodayProgress() ?? [
                    'claims_today' => 0,
                    'max_claims' => $currentHunt->max_per_day,
                    'remaining_claims' => $currentHunt->max_per_day,
                    'money_today' => 0,
                    'last_claim' => null,
                    'on_cooldown' => false,
                    'cooldown_remaining_minutes' => 0,
                ],
            ];
        } else {
            $data['user'] = ['authenticated' => false];
        }

        return response()->json($data);
    }
}
