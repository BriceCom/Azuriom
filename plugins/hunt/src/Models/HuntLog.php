<?php

namespace Azuriom\Plugin\Hunt\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $hunt_id
 * @property int $user_id
 * @property int|null $reward_id
 * @property float $money_received
 * @property array|null $commands_executed
 * @property string|null $ip_address
 * @property string|null $session_id
 * @property string|null $user_agent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Plugin\Hunt\Models\Hunt $hunt
 * @property \Azuriom\Models\User $user
 * @property \Azuriom\Plugin\Hunt\Models\HuntReward|null $reward
 */
class HuntLog extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'hunt_';

    /**
     * The table associated with the model.
     */
    protected $table = 'hunt_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hunt_id', 'user_id', 'reward_id', 'money_received',
        'commands_executed', 'ip_address', 'session_id', 'user_agent',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'money_received' => 'decimal:2',
        'commands_executed' => 'array',
    ];

    public function hunt()
    {
        return $this->belongsTo(Hunt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(HuntReward::class, 'reward_id');
    }

    /**
     * Create a log entry for a hunt claim.
     */
    public static function logClaim(Hunt $hunt, User $user, ?HuntReward $reward = null, float $money = 0, array $commands = [], ?string $ip = null, ?string $sessionId = null, ?string $userAgent = null): self
    {
        return static::create([
            'hunt_id' => $hunt->id,
            'user_id' => $user->id,
            'reward_id' => $reward?->id,
            'money_received' => $money,
            'commands_executed' => !empty($commands) ? $commands : null,
            'ip_address' => $ip,
            'session_id' => $sessionId,
            'user_agent' => $userAgent,
        ]);
    }

    /**
     * Get logs for a specific hunt.
     */
    public static function forHunt(Hunt $hunt)
    {
        return static::where('hunt_id', $hunt->id)
                    ->with(['user', 'reward'])
                    ->latest();
    }

    /**
     * Get logs for a specific user.
     */
    public static function forUser(User $user)
    {
        return static::where('user_id', $user->id)
                    ->with(['hunt', 'reward'])
                    ->latest();
    }

    /**
     * Get logs for admin panel with filters.
     */
    public static function adminLogs()
    {
        return static::with(['hunt', 'user', 'reward'])
                    ->latest();
    }

    /**
     * Get user statistics for a hunt.
     */
    public static function getUserStats(Hunt $hunt, User $user): array
    {
        $logs = static::where('hunt_id', $hunt->id)
                     ->where('user_id', $user->id);

        $totalClaims = $logs->count();
        $totalMoney = $logs->sum('money_received');
        $todayClaims = $logs->whereDate('created_at', today())->count();
        $todayMoney = $logs->whereDate('created_at', today())->sum('money_received');

        return [
            'total_claims' => $totalClaims,
            'total_money' => $totalMoney,
            'today_claims' => $todayClaims,
            'today_money' => $todayMoney,
        ];
    }

    /**
     * Get hunt statistics.
     */
    public static function getHuntStats(Hunt $hunt): array
    {
        $logs = static::where('hunt_id', $hunt->id);

        $totalClaims = $logs->count();
        $totalMoney = $logs->sum('money_received');
        $uniqueUsers = $logs->distinct('user_id')->count();
        $todayClaims = $logs->whereDate('created_at', today())->count();

        return [
            'total_claims' => $totalClaims,
            'total_money_distributed' => $totalMoney,
            'unique_participants' => $uniqueUsers,
            'today_claims' => $todayClaims,
        ];
    }

    /**
     * Get leaderboard data for a hunt.
     */
    public static function getLeaderboard(Hunt $hunt, int $limit = 10): \Illuminate\Support\Collection
    {
        return static::selectRaw('user_id, COUNT(*) as claims_count, SUM(money_received) as total_money')
                    ->where('hunt_id', $hunt->id)
                    ->with('user')
                    ->groupBy('user_id')
                    ->orderByDesc('claims_count')
                    ->orderByDesc('total_money')
                    ->limit($limit)
                    ->get();
    }
}
