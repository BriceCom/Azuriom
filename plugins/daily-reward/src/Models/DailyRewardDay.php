<?php

namespace Azuriom\Plugin\DailyReward\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $day_number
 * @property string|null $label
 * @property bool $is_enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static Builder enabled()
 */
class DailyRewardDay extends Model
{
    use HasTablePrefix;
    use Loggable;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'daily_reward_';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_reward_days';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'day_number',
        'label',
        'is_enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'day_number' => 'integer',
        'is_enabled' => 'boolean',
    ];

    public function rewards()
    {
        return $this->hasMany(DailyRewardReward::class, 'day_id');
    }

    /**
     * Scope a query to only include enabled days.
     */
    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', true);
    }
}
