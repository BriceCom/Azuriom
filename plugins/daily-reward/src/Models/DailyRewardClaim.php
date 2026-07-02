<?php

namespace Azuriom\Plugin\DailyReward\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $day_number
 * @property int $streak_before
 * @property int $streak_after
 * @property array|null $rewards_snapshot
 * @property \Carbon\Carbon $claimed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User $user
 */
class DailyRewardClaim extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'daily_reward_';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_reward_claims';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'day_number',
        'streak_before',
        'streak_after',
        'rewards_snapshot',
        'claimed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'day_number' => 'integer',
        'streak_before' => 'integer',
        'streak_after' => 'integer',
        'rewards_snapshot' => 'array',
        'claimed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
