<?php

namespace Azuriom\Plugin\Hunt\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $hunt_id
 * @property int $user_id
 * @property string $date
 * @property int $claims_count
 * @property float $money_received_today
 * @property \Carbon\Carbon|null $last_claim_at
 * @property \Carbon\Carbon|null $cooldown_until
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Plugin\Hunt\Models\Hunt $hunt
 * @property \Azuriom\Models\User $user
 */
class HuntUserDaily extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'hunt_';

    /**
     * The table associated with the model.
     */
    protected $table = 'hunt_user_daily';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hunt_id', 'user_id', 'date', 'claims_count',
        'money_received_today', 'last_claim_at', 'cooldown_until',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'money_received_today' => 'decimal:2',
        'last_claim_at' => 'datetime',
        'cooldown_until' => 'datetime',
    ];

    public function hunt()
    {
        return $this->belongsTo(Hunt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get or create user daily record.
     */
    public static function getOrCreate(Hunt $hunt, User $user, ?Carbon $date = null): self
    {
        $date = $date ?? Carbon::today();

        return static::firstOrCreate([
            'hunt_id' => $hunt->id,
            'user_id' => $user->id,
            'date' => $date->toDateString(),
        ], [
            'claims_count' => 0,
            'money_received_today' => 0,
        ]);
    }

    /**
     * Check if user is on cooldown.
     */
    public function isOnCooldown(): bool
    {
        return $this->cooldown_until && Carbon::now() < $this->cooldown_until;
    }

    /**
     * Check if user has reached daily limit.
     */
    public function hasReachedDailyLimit(): bool
    {
        return $this->claims_count >= $this->hunt->max_per_day;
    }

    /**
     * Check if user can claim.
     */
    public function canClaim(): bool
    {
        return !$this->isOnCooldown() && !$this->hasReachedDailyLimit();
    }

    /**
     * Set cooldown for failed spawn rate.
     */
    public function setCooldown(): void
    {
        $this->cooldown_until = Carbon::now()->addMinutes($this->hunt->cooldown_minutes);
        $this->save();
    }

    /**
     * Record a successful claim.
     */
    public function recordClaim(float $moneyReceived = 0): void
    {
        $this->increment('claims_count');
        $this->money_received_today += $moneyReceived;
        $this->last_claim_at = Carbon::now();
        $this->cooldown_until = Carbon::now()->addMinutes($this->hunt->cooldown_minutes);
        $this->save();
    }

    /**
     * Get remaining claims for today.
     */
    public function getRemainingClaims(): int
    {
        return max(0, $this->hunt->max_per_day - $this->claims_count);
    }

    /**
     * Get cooldown remaining time in minutes.
     */
    public function getCooldownRemainingMinutes(): int
    {
        if (!$this->isOnCooldown()) {
            return 0;
        }

        $remaining = $this->cooldown_until->diffInMinutes(Carbon::now());
        return max(0, $remaining);
    }

    /**
     * Get user's progress for today.
     */
    public function getTodayProgress(): array
    {
        return [
            'claims_today' => $this->claims_count,
            'max_claims' => $this->hunt->max_per_day,
            'remaining_claims' => $this->getRemainingClaims(),
            'money_today' => $this->money_received_today,
            'last_claim' => $this->last_claim_at,
            'on_cooldown' => $this->isOnCooldown(),
            'cooldown_remaining_minutes' => $this->getCooldownRemainingMinutes(),
        ];
    }

    /**
     * Clean up old daily records (older than 30 days).
     */
    public static function cleanup(): int
    {
        return static::where('date', '<', Carbon::now()->subDays(30))->delete();
    }

    /**
     * Get user statistics across all hunts.
     */
    public static function getUserTotalStats(User $user): array
    {
        $records = static::where('user_id', $user->id);

        return [
            'total_claims' => $records->sum('claims_count'),
            'total_money' => $records->sum('money_received_today'),
            'active_hunts' => $records->whereDate('date', today())->count(),
        ];
    }

    /**
     * Get hunt daily statistics.
     */
    public static function getHuntDailyStats(Hunt $hunt, ?Carbon $date = null): array
    {
        $date = $date ?? Carbon::today();
        $records = static::where('hunt_id', $hunt->id)
                        ->where('date', $date->toDateString());

        return [
            'unique_participants' => $records->count(),
            'total_claims' => $records->sum('claims_count'),
            'total_money' => $records->sum('money_received_today'),
        ];
    }
}
