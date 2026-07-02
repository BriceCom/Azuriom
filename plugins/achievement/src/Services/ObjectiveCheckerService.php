<?php

namespace Azuriom\Plugin\Achievement\Services;

use Azuriom\Models\Like;
use Azuriom\Models\User;
use Azuriom\Plugin\Achievement\Models\Objective;
use Azuriom\Plugin\Achievement\Models\UserTrophyPoints;
use Azuriom\Plugin\Review\Models\Review;
use Azuriom\Plugin\Shop\Models\Payment;
use Azuriom\Plugin\Shop\Models\PaymentItem;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Vote\Models\Vote;
use Azuriom\Plugin\Forum\Models\Post as ForumPost;
use Azuriom\Plugin\Forum\Models\Discussion as ForumDiscussion;
use Azuriom\Plugin\Forum\Models\Like as ForumLike;
use Illuminate\Support\Facades\DB;

class ObjectiveCheckerService
{
    protected array $triggers = [
        'vote' => [
            'voted' => [Vote::class, 'user_id', null],
            'leaderboard' => [Vote::class, 'user_id', null]
        ],
        'shop' => [
            'spent' => [Payment::class, 'user_id', null],
            'points_spent' => [Payment::class, 'user_id', null],
            'item_purchase' => [PaymentItem::class, 'payment.user_id', 'payment'],
        ],
        'suggest' => [
            'post' => [Suggestion::class, 'user_id', null],
            'like_received' => [Suggestion::class, 'user_id', "upvotes"],
        ],
        'review' => [
            'post' => [Review::class, 'author_id', null],
        ],
        'forum' => [
            'message' => [ForumPost::class, 'author_id', null],
            'topic' => [ForumDiscussion::class, 'author_id', null],
            'like_received' => [ForumLike::class, 'post.author_id', null],
        ],
        'post' => [
            'like' => [Like::class, 'author_id', null],
        ],
        'achievement' => [
            'achievement_trophy_amount' => [Like::class, 'author_id', null],
        ],
    ];

    public function checkProgress(User $user, Objective $objective): int
    {
        $trigger = $objective->trigger;
        $hook = $objective->hook;

        if (!isset($this->triggers[$hook][$trigger])) {
            return 0;
        }

        $config = $this->triggers[$hook][$trigger];

        if (!$config) {
            return 0;
        }

        if ($hook === 'shop' && $trigger === 'spent') {
            return $this->checkShopSpent($user, $config, $objective->start_date);
        }

        if ($hook === 'shop' && $trigger === 'points_spent') {
            return $this->checkShopPointsSpent($user, $config, $objective->start_date);
        }

        if ($hook === 'vote' && $trigger === 'voted') {
            return $this->checkVoteCount($user, $config, $objective->start_date);
        }

        if ($hook === 'vote' && $trigger === 'leaderboard') {
            return $this->checkVoteLeaderboard($user, $objective);
        }

        if ($hook === 'achievement' && $trigger === 'achievement_trophy_amount') {
            return $this->checkAchievementTrophyAmount($user);
        }

        return $this->checkDefaultProgress($user, $config, $objective->start_date);
    }

    protected function checkShopSpent(User $user, array $config, $startDate = null): int
    {
        [$model, $attr, $relation] = $config;

        $query = $model::where($attr, $user->id);

        if ($relation) {
            $query->whereHas($relation);
        }

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        $query->where('status', 'completed')
              ->where('gateway_type', '!=', 'azuriom'); // Exclude internal site points
        return (int) $query->sum('price');
    }

    protected function checkShopPointsSpent(User $user, array $config, $startDate = null): int
    {
        [$model, $attr, $relation] = $config;

        $query = $model::where($attr, $user->id);

        if ($relation) {
            $query->whereHas($relation);
        }

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        $query->where('status', 'completed')
              ->where('gateway_type', '=', 'azuriom'); // Only internal site points
        return (int) $query->sum('price');
    }

    protected function checkVoteCount(User $user, array $config, $startDate = null): int
    {
        [$model, $attr, $relation] = $config;

        $query = $model::where($attr, $user->id);

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        return $query->count();
    }

    protected function checkVoteLeaderboard(User $user, Objective $objective): int
    {
        $currentMonthStart = now()->startOfMonth();

        $userVoteMonths = DB::table((new Vote())->getTable())
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as vote_month'))
            ->where('user_id', $user->id)
            ->where('created_at', '<', $currentMonthStart);

        // Apply start_date filter if set
        if ($objective->start_date) {
            $userVoteMonths->where('created_at', '>=', $objective->start_date);
        }

        $userVoteMonths = $userVoteMonths->groupBy('vote_month')
            ->orderBy('vote_month', 'desc')
            ->get();

        foreach ($userVoteMonths as $monthData) {
            $monthStart = \Carbon\Carbon::createFromFormat('Y-m', $monthData->vote_month)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            $leaderboard = DB::table((new Vote())->getTable())
                ->select('user_id', DB::raw('COUNT(*) as vote_count'))
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->groupBy('user_id')
                ->orderByDesc('vote_count')
                ->limit($objective->amount)
                ->get();

            $userRank = $leaderboard->search(function($item) use ($user) {
                return $item->user_id == $user->id;
            });

            if ($userRank !== false) {
                return 1;
            }
        }

        return 0;
    }

    protected function checkAchievementTrophyAmount(User $user): int
    {
        return UserTrophyPoints::getTrophyPoints($user->id);
    }

    protected function checkDefaultProgress(User $user, array $config, $startDate = null): int
    {
        [$model, $attr, $relation] = $config;

        // Handle relationship-based attributes (e.g., payment.user_id)
        if (str_contains($attr, '.')) {
            $parts = explode('.', $attr);
            $relationName = $parts[0];
            $relationAttr = $parts[1];

            $query = $model::whereHas($relationName, function($q) use ($relationAttr, $user) {
                $q->where($relationAttr, $user->id);
            });
        } else {
            $query = $model::where($attr, $user->id);
        }

        if ($relation) {
            $query->whereHas($relation);
        }

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        return $query->count();
    }

    public function getTriggers(): array
    {
        return $this->triggers;
    }
}
