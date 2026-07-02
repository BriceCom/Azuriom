<?php

namespace Azuriom\Plugin\Achievement\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $trophy_points
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Models\User $user
 */
class UserTrophyPoints extends Model
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
        'user_id', 'trophy_points',
    ];

    /**
     * Get the user that owns these trophy points.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get trophy points for a user, creating record if it doesn't exist.
     */
    public static function getTrophyPoints(int $userId): int
    {
        $record = static::firstOrCreate(
            ['user_id' => $userId],
            ['trophy_points' => 0]
        );

        return $record->trophy_points;
    }

    /**
     * Add trophy points to a user.
     */
    public static function addTrophyPoints(int $userId, int $points): void
    {
        if ($points <= 0) {
            return;
        }

        $record = static::firstOrCreate(
            ['user_id' => $userId],
            ['trophy_points' => 0]
        );

        $record->increment('trophy_points', $points);
    }
}
