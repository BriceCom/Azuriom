<?php

namespace Azuriom\Plugin\Hunt\Models;

use Azuriom\Models\Traits\HasImage;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property int $priority
 * @property int $max_per_day
 * @property int|null $global_cap
 * @property float $spawn_rate
 * @property int $cooldown_minutes
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property bool $is_active
 * @property bool $is_archived
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder active()
 * @method static \Illuminate\Database\Eloquent\Builder current()
 * @method static \Illuminate\Database\Eloquent\Builder byPriority()
 */
class Hunt extends Model
{
    use HasImage;
    use HasTablePrefix;
    use Loggable;
    use Searchable;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'hunt_';

    /**
     * The table associated with the model.
     */
    protected $table = 'hunt_hunts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'priority', 'max_per_day',
        'global_cap', 'spawn_rate', 'cooldown_minutes', 'spawn_delay_seconds', 'start_date',
        'end_date', 'is_active', 'is_archived',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'spawn_rate' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'is_archived' => 'boolean',
    ];

    /**
     * The attributes that can be used for search.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'name', 'description',
    ];

    public function rewards()
    {
        return $this->belongsToMany(HuntReward::class, 'hunt_reward_hunt', 'hunt_id', 'reward_id');
    }

    public function logs()
    {
        return $this->hasMany(HuntLog::class);
    }

    public function userDailies()
    {
        return $this->hasMany(HuntUserDaily::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $hunt) {
            if (empty($hunt->slug)) {
                $hunt->slug = Str::slug($hunt->name);
            }

            if (empty($hunt->start_date)) {
                $hunt->start_date = Carbon::now();
            }
        });

        static::updating(function (self $hunt) {
            if (empty($hunt->slug)) {
                $hunt->slug = Str::slug($hunt->name);
            }
        });
    }

    /**
     * Scope a query to only include active hunts.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true)
              ->where('is_archived', false);
    }

    /**
     * Scope a query to only include current hunts (within date range).
     */
    public function scopeCurrent(Builder $query): void
    {
        $now = Carbon::now();
        $query->where('start_date', '<=', $now)
              ->where('end_date', '>=', $now);
    }

    /**
     * Scope a query to order hunts by priority.
     */
    public function scopeByPriority(Builder $query): void
    {
        $query->orderByDesc('priority')
              ->orderBy('created_at');
    }

    /**
     * Check if the hunt is active (not archived).
     */
    public function isActive(): bool
    {
        return $this->is_active && !$this->is_archived;
    }

    /**
     * Check if the hunt is within its date range.
     */
    public function isCurrent(): bool
    {
        $now = Carbon::now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    /**
     * Check if the hunt is currently active and running.
     */
    public function isCurrentlyActive(): bool
    {
        return $this->is_active
               && !$this->is_archived
               && $this->start_date <= Carbon::now()
               && $this->end_date >= Carbon::now();
    }

    /**
     * Check if the hunt has reached its global cap.
     */
    public function hasReachedGlobalCap(): bool
    {
        if ($this->global_cap === null) {
            return false;
        }

        return $this->logs()->count() >= $this->global_cap;
    }

    /**
     * Get the current hunt (highest priority active hunt).
     */
    public static function getCurrentHunt(): ?self
    {
        return static::active()
                    ->current()
                    ->byPriority()
                    ->first();
    }

    /**
     * Get user's daily data for this hunt.
     */
    public function getUserDaily(User $user, ?Carbon $date = null): ?HuntUserDaily
    {
        $date = $date ?? Carbon::today();

        return $this->userDailies()
                   ->where('user_id', $user->id)
                   ->where('date', $date->toDateString())
                   ->first();
    }

    /**
     * Check if user can claim this hunt today.
     */
    public function canUserClaim(User $user): array
    {
        if (!$this->isCurrentlyActive()) {
            return ['can_claim' => false, 'reason' => 'hunt_not_active'];
        }

        if ($this->hasReachedGlobalCap()) {
            return ['can_claim' => false, 'reason' => 'global_cap_reached'];
        }

        $userDaily = $this->getUserDaily($user);

        if ($userDaily) {
            if ($userDaily->claims_count >= $this->max_per_day) {
                return ['can_claim' => false, 'reason' => 'daily_limit_reached'];
            }

            if ($userDaily->cooldown_until && Carbon::now() < $userDaily->cooldown_until) {
                return ['can_claim' => false, 'reason' => 'cooldown_active'];
            }
        }

        return ['can_claim' => true];
    }
}
