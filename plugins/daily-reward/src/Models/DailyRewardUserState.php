<?php

namespace Azuriom\Plugin\DailyReward\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $streak_count
 * @property int $max_streak
 * @property int $next_day_number
 * @property \Carbon\Carbon|null $last_claim_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User $user
 */
class DailyRewardUserState extends Model
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
    protected $table = 'daily_reward_user_states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'streak_count',
        'max_streak',
        'next_day_number',
        'last_claim_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'streak_count' => 'integer',
        'max_streak' => 'integer',
        'next_day_number' => 'integer',
        'last_claim_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
