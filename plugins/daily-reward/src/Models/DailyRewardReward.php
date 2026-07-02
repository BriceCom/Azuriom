<?php

namespace Azuriom\Plugin\DailyReward\Models;

use Azuriom\Models\Server;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $day_id
 * @property string $name
 * @property string $type
 * @property float|null $money
 * @property array|null $commands
 * @property bool $need_online
 * @property bool $is_enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static Builder enabled()
 */
class DailyRewardReward extends Model
{
    use HasTablePrefix;
    use Loggable;

    public const TYPE_MONEY = 'money';
    public const TYPE_COMMAND = 'command';

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'daily_reward_';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_reward_rewards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'day_id',
        'name',
        'type',
        'money',
        'commands',
        'need_online',
        'is_enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'day_id' => 'integer',
        'money' => 'decimal:2',
        'commands' => 'array',
        'need_online' => 'boolean',
        'is_enabled' => 'boolean',
    ];

    public function day()
    {
        return $this->belongsTo(DailyRewardDay::class, 'day_id');
    }

    public function servers()
    {
        return $this->belongsToMany(Server::class, 'daily_reward_reward_server', 'reward_id', 'server_id');
    }

    /**
     * Scope a query to only include enabled rewards.
     */
    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', true);
    }
}
