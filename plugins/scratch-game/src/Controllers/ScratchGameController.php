<?php

namespace Azuriom\Plugin\ScratchGame\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\ScratchGame\Models\ScratchCard;
use Azuriom\Plugin\ScratchGame\Models\ScratchLog;
use Azuriom\Plugin\ScratchGame\Models\ScratchReward;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ScratchGameController extends Controller
{
    private const PENDING_LOGS_LIMIT = 12;

    /**
     * Display all available scratch cards grouped by role requirements.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $cards = ScratchCard::with([
            'roles',
            'rewards' => fn ($query) => $query->enabled()->orderByDesc('chance'),
        ])
            ->enabled()
            ->orderBy('price')
            ->orderBy('name')
            ->get();

        $cardsByCategory = $cards->groupBy(function (ScratchCard $card) {
            if ($card->roles->isEmpty()) {
                return trans('scratch-game::messages.categories.public');
            }

            return $card->roles->pluck('name')->sort()->values()->join(' / ');
        });

        $pendingCount = 0;
        $pendingLogs = collect();
        $freeStatusByCard = [];

        if ($user !== null) {
            $pendingCount = ScratchLog::query()
                ->where('user_id', $user->id)
                ->pending()
                ->count();

            $pendingLogs = ScratchLog::query()
                ->where('user_id', $user->id)
                ->with(['card'])
                ->pending()
                ->latest()
                ->limit(self::PENDING_LOGS_LIMIT)
                ->get();

            $freeCards = $cards->filter(fn (ScratchCard $card) => (int) ($card->free_interval_minutes ?? 0) > 0);

            if ($freeCards->isNotEmpty()) {
                $lastFreeByCard = ScratchLog::query()
                    ->select('card_id', DB::raw('MAX(created_at) as last_free_at'))
                    ->where('user_id', $user->id)
                    ->whereIn('card_id', $freeCards->pluck('id'))
                    ->where('price_paid', '<=', 0)
                    ->groupBy('card_id')
                    ->get()
                    ->keyBy('card_id');

                $now = now();

                foreach ($freeCards as $card) {
                    $intervalMinutes = (int) ($card->free_interval_minutes ?? 0);
                    if ($intervalMinutes <= 0) {
                        continue;
                    }

                    $lastFreeAt = optional($lastFreeByCard->get($card->id))->last_free_at;

                    if ($lastFreeAt === null) {
                        $freeStatusByCard[$card->id] = [
                            'available' => true,
                            'cooldown' => null,
                        ];
                        continue;
                    }

                    $nextAvailableAt = Carbon::parse($lastFreeAt)->addMinutes($intervalMinutes);

                    if ($nextAvailableAt->isPast()) {
                        $freeStatusByCard[$card->id] = [
                            'available' => true,
                            'cooldown' => null,
                        ];
                        continue;
                    }

                    $cooldownHuman = $nextAvailableAt
                        ->locale(app()->getLocale())
                        ->diffForHumans($now, [
                            'parts' => 2,
                            'short' => true,
                            'syntax' => Carbon::DIFF_ABSOLUTE,
                        ]);

                    $freeStatusByCard[$card->id] = [
                        'available' => false,
                        'cooldown' => $cooldownHuman,
                    ];
                }
            }
        }

        return view('scratch-game::index', [
            'cardsByCategory' => $cardsByCategory,
            'pendingCount' => $pendingCount,
            'pendingLogs' => $pendingLogs,
            'user' => $user,
            'freeStatusByCard' => $freeStatusByCard,
        ]);
    }

    /**
     * Buy and play one scratch card.
     */
    public function play(Request $request, ScratchCard $card): RedirectResponse
    {
        if (! $card->is_enabled) {
            abort(404);
        }

        $card->load(['roles']);

        $user = $request->user();

        if (! $card->isUserEligible($user)) {
            return back()->with('error', trans('scratch-game::messages.errors.role_not_allowed'));
        }

        $eligibleRewards = $card->enabledRewards()->with('servers')->get();

        if ($eligibleRewards->isEmpty()) {
            return back()->with('error', trans('scratch-game::messages.errors.no_enabled_rewards'));
        }

        try {
            $playData = DB::transaction(function () use ($user, $card, $eligibleRewards, $request) {
                $lockedUser = User::query()->lockForUpdate()->findOrFail($user->id);
                $price = (float) $card->price;
                $freeIntervalMinutes = (int) ($card->free_interval_minutes ?? 0);

                if ($freeIntervalMinutes > 0) {
                    $lastFreeLog = ScratchLog::query()
                        ->where('user_id', $lockedUser->id)
                        ->where('card_id', $card->id)
                        ->where('price_paid', '<=', 0)
                        ->latest()
                        ->lockForUpdate()
                        ->first();

                    $canUseFree = $lastFreeLog === null
                        || $lastFreeLog->created_at === null
                        || $lastFreeLog->created_at->addMinutes($freeIntervalMinutes)->isPast();

                    if ($canUseFree) {
                        $price = 0;
                    }
                }

                if ($price > 0 && $lockedUser->money < $price) {
                    return [
                        'error' => trans('scratch-game::messages.errors.not_enough_points', [
                            'price' => number_format($price, 2),
                            'currency' => money_name(),
                        ]),
                    ];
                }

                if ($price > 0) {
                    $lockedUser->removeMoney($price);
                }

                $selectedReward = ScratchReward::selectRandomReward($eligibleRewards);

                $log = ScratchLog::logPlay(
                    $card,
                    $lockedUser,
                    $selectedReward,
                    $price,
                    0,
                    [],
                    $request->ip(),
                    $request->userAgent()
                );

                return [
                    'log' => $log,
                ];
            }, 3);
        } catch (Throwable) {
            return back()->with('error', trans('scratch-game::messages.errors.unknown_error'));
        }

        if (isset($playData['error'])) {
            return back()->with('error', $playData['error']);
        }

        return to_route('scratch-game.result', $playData['log'])
            ->with('success', trans('scratch-game::messages.play.success'));
    }

    /**
     * Display the scratch result page.
     */
    public function result(Request $request, ScratchLog $log)
    {
        if ($log->user_id !== $request->user()->id) {
            abort(403);
        }

        $log->load([
            'card.roles',
            'card.rewards' => fn ($query) => $query->orderByDesc('chance'),
            'reward',
        ]);

        $freeStatus = null;
        $intervalMinutes = (int) ($log->card->free_interval_minutes ?? 0);
        if ($intervalMinutes > 0) {
            $lastFreeLog = ScratchLog::query()
                ->where('user_id', $request->user()->id)
                ->where('card_id', $log->card->id)
                ->where('price_paid', '<=', 0)
                ->latest()
                ->first();

            if ($lastFreeLog === null || $lastFreeLog->created_at === null) {
                $freeStatus = [
                    'available' => true,
                    'cooldown' => null,
                ];
            } else {
                $nextFreeAt = $lastFreeLog->created_at->addMinutes($intervalMinutes);

                if ($nextFreeAt->isPast()) {
                    $freeStatus = [
                        'available' => true,
                        'cooldown' => null,
                    ];
                } else {
                    $cooldownHuman = $nextFreeAt
                        ->locale(app()->getLocale())
                        ->diffForHumans(now(), [
                            'parts' => 2,
                            'short' => true,
                            'syntax' => Carbon::DIFF_ABSOLUTE,
                        ]);

                    $freeStatus = [
                        'available' => false,
                        'cooldown' => $cooldownHuman,
                    ];
                }
            }
        }

        return view('scratch-game::result', [
            'log' => $log,
            'remainingPoints' => $request->user()->fresh()->money,
            'freeStatus' => $freeStatus,
        ]);
    }

    /**
     * Display user scratch history and pending games.
     */
    public function history(Request $request)
    {
        $logs = ScratchLog::query()
            ->where('user_id', $request->user()->id)
            ->with(['card', 'reward'])
            ->latest()
            ->paginate(20);

        return view('scratch-game::history', [
            'logs' => $logs,
        ]);
    }

    /**
     * Claim and dispatch the reward after scratching.
     */
    public function claim(Request $request, ScratchLog $log): JsonResponse
    {
        if ($log->user_id !== $request->user()->id) {
            abort(403);
        }

        $hasClaimedAtColumn = ScratchLog::hasClaimedAtColumn();

        try {
            $payload = DB::transaction(function () use ($request, $log, $hasClaimedAtColumn) {
                $lockedLog = ScratchLog::query()
                    ->with(['card', 'reward.servers'])
                    ->lockForUpdate()
                    ->findOrFail($log->id);

                if ($lockedLog->user_id !== $request->user()->id) {
                    abort(403);
                }

                $alreadyDispatched = (float) $lockedLog->money_given > 0
                    || ! empty($lockedLog->commands_executed);

                $isAlreadyClaimed = $alreadyDispatched
                    || ($hasClaimedAtColumn && $lockedLog->claimed_at !== null);

                if ($isAlreadyClaimed) {
                    if ($hasClaimedAtColumn && $lockedLog->claimed_at === null) {
                        $lockedLog->claimed_at = $lockedLog->created_at ?? now();
                        $lockedLog->save();
                    }

                    return $this->buildClaimPayload($lockedLog, $request->user()->fresh());
                }

                $warnings = [];
                $errors = [];
                $moneyGiven = 0;
                $commandsExecuted = [];

                if ($lockedLog->reward !== null) {
                    $lockedUser = User::query()->lockForUpdate()->findOrFail($request->user()->id);
                    $dispatchResult = $lockedLog->reward->dispatch($lockedUser, $lockedLog->card);

                    $moneyGiven = (float) ($dispatchResult['money_given'] ?? 0);
                    $commandsExecuted = $dispatchResult['commands_executed'] ?? [];
                    $warnings = $dispatchResult['warnings'] ?? [];
                    $errors = $dispatchResult['errors'] ?? [];

                    $lockedLog->money_given = $moneyGiven;
                    $lockedLog->commands_executed = ! empty($commandsExecuted) ? $commandsExecuted : null;
                }

                if ($hasClaimedAtColumn) {
                    $lockedLog->claimed_at = now();
                }
                $lockedLog->save();

                return $this->buildClaimPayload($lockedLog->fresh(['reward', 'card']), $request->user()->fresh(), $warnings, $errors);
            }, 3);

            return response()->json($payload);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => trans('scratch-game::messages.errors.claim_failed'),
            ], 500);
        }
    }

    /**
     * Build claim response payload.
     *
     * @param  array<int, string>  $warnings
     * @param  array<int, string>  $errors
     * @return array<string, mixed>
     */
    private function buildClaimPayload(ScratchLog $log, User $user, array $warnings = [], array $errors = []): array
    {
        $success = empty($errors);

        return [
            'success' => $success,
            'reward' => $log->reward ? [
                'name' => $log->reward->name,
                'image' => $log->reward->hasImage() ? $log->reward->imageUrl() : null,
                'commands_count' => is_array($log->commands_executed) ? count($log->commands_executed) : 0,
            ] : null,
            'money_given' => (float) $log->money_given,
            'remaining_money' => (float) $user->money,
            'currency' => money_name(),
            'warnings' => $warnings,
            'errors' => $errors,
            'claimed_at' => $log->claimed_at?->toIso8601String(),
        ];
    }
}
