<?php

namespace Azuriom\Plugin\Achievement\Models;

use Azuriom\Models\Role;
use Azuriom\Models\Traits\HasImage;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @property int $id
 * @property string $name
 * @property string $hook
 * @property string $trigger
 * @property int $amount
 * @property string $description
 * @property array|null $rewards
 * @property bool $is_enabled
 * @property \Carbon\Carbon|null $start_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Achievement\Models\UserObjective[] $userObjectives
 *
 * @method static \Illuminate\Database\Eloquent\Builder enabled()
 */
class Objective extends Model
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
        'name', 'hook', 'trigger', 'amount', 'description', 'rewards', 'is_enabled', 'visibility', 'start_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rewards' => 'array',
        'is_enabled' => 'boolean',
        'start_date' => 'datetime',
    ];

    /**
     * Get the user objectives for this objective.
     */
    public function userObjectives()
    {
        return $this->hasMany(UserObjective::class);
    }

    /**
     * Get the user objective for the given user.
     */
    public function userObjective(User $user)
    {
        return $this->userObjectives()->where('user_id', $user->id)->first();
    }

    /**
     * Get the roles that can view this objective.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'achievement_objective_roles');
    }

    /**
     * Scope a query to only include enabled objectives.
     */
    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', true);
    }

    /**
     * Scope a query to only include objectives visible to the given user.
     */
    public function scopeVisibleToUser(Builder $query, User $user): void
    {
        $query->where(function ($q) use ($user) {
            $q->where('visibility', 'public')
              ->orWhere(function ($roleQuery) use ($user) {
                  $roleQuery->where('visibility', 'role')
                           ->whereHas('roles', function ($roleSubQuery) use ($user) {
                               $roleSubQuery->where('role_id', $user->role_id);
                           });
              });
        });
    }

}
