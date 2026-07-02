<?php

namespace Azuriom\Plugin\Achievement\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $objective_id
 * @property int $progress
 * @property string $status
 * @property \Carbon\Carbon|null $completed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Models\User $user
 * @property \Azuriom\Plugin\Achievement\Models\Objective $objective
 *
 * @method static \Illuminate\Database\Eloquent\Builder completed()
 * @method static \Illuminate\Database\Eloquent\Builder inProgress()
 * @method static \Illuminate\Database\Eloquent\Builder notStarted()
 */
class UserObjective extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'achievement_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'objective_id', 'progress', 'status', 'completed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed_at' => 'datetime',
    ];

    /**
     * The status values.
     *
     * @var array<string>
     */
    public const STATUS_NOT_STARTED = 'not_started';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CLAIMED = 'claimed';


    /**
     * Get the user that owns this objective progress.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the objective that this progress is for.
     */
    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }

    /**
     * Update the progress of this objective.
     */
    public function updateProgress(int $progress): void
    {
        $this->progress = $progress;

        // Don't change the status if it's already claimed
        if ($this->status === self::STATUS_CLAIMED) {
            $this->save();
            return;
        }

        if ($progress === 0) {
            $this->status = self::STATUS_NOT_STARTED;
        } elseif ($progress >= $this->objective->amount) {
            $this->status = self::STATUS_COMPLETED;
            $this->completed_at = now();
        } else {
            $this->status = self::STATUS_IN_PROGRESS;
        }

        $this->save();
    }

    /**
     * Get the progress percentage of this objective.
     */
    public function getProgressPercentage(): int
    {
        if ($this->objective->amount === 0) {
            return 0;
        }

        return min(100, (int) ($this->progress / $this->objective->amount * 100));
    }

    /**
     * Scope a query to only include completed objectives.
     */
    public function scopeCompleted(Builder $query): void
    {
        $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include in-progress objectives.
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('status', self::STATUS_IN_PROGRESS);
    }

    /**
     * Scope a query to only include not-started objectives.
     */
    public function scopeNotStarted(Builder $query): void
    {
        $query->where('status', self::STATUS_NOT_STARTED);
    }

    /**
     * Scope a query to only include claimed objectives.
     */
    public function scopeClaimed(Builder $query): void
    {
        $query->where('status', self::STATUS_CLAIMED);
    }

}
