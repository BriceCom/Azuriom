<?php

namespace Azuriom\Plugin\Hunt\Models;

use Azuriom\Models\Role;
use Azuriom\Models\Server;
use Azuriom\Models\Traits\HasImage;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Models\User;
use Azuriom\Plugin\ScratchGame\Models\ScratchCard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property float $chances
 * @property float|null $money
 * @property int|null $scratch_card_id
 * @property array|null $commands
 * @property bool $need_online
 * @property bool $is_enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Hunt\Models\Hunt[] $hunts
 * @property \Illuminate\Support\Collection|\Azuriom\Models\Role[] $roles
 * @property \Illuminate\Support\Collection|\Azuriom\Models\Server[] $servers
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Hunt\Models\HuntLog[] $logs
 *
 * @method static \Illuminate\Database\Eloquent\Builder enabled()
 */
class HuntReward extends Model
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
    protected $table = 'hunt_rewards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'image', 'chances', 'money', 'commands',
        'scratch_card_id', 'need_online', 'is_enabled',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'chances' => 'decimal:2',
        'money' => 'decimal:2',
        'commands' => 'array',
        'scratch_card_id' => 'integer',
        'need_online' => 'boolean',
        'is_enabled' => 'boolean',
    ];

    /**
     * The attributes that can be used for search.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'name',
    ];

    public function hunts()
    {
        return $this->belongsToMany(Hunt::class, 'hunt_reward_hunt', 'reward_id', 'hunt_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'hunt_reward_role', 'reward_id', 'role_id');
    }

    public function servers()
    {
        return $this->belongsToMany(Server::class, 'hunt_reward_server', 'reward_id', 'server_id');
    }

    public function logs()
    {
        return $this->hasMany(HuntLog::class, 'reward_id');
    }

    /**
     * Scope a query to only include enabled rewards.
     */
    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', true);
    }

    /**
     * Check if user is eligible for this reward based on roles.
     */
    public function isUserEligible(User $user): bool
    {
        if ($this->roles->isEmpty()) {
            return true;
        }

        if ($user->relationLoaded('roles')) {
            $userRoles = $user->getRelation('roles');

            return $userRoles !== null && $userRoles->intersect($this->roles)->isNotEmpty();
        }

        $userRoleId = $user->getAttribute('role_id');

        if ($userRoleId !== null) {
            return $this->roles->contains('id', (int) $userRoleId);
        }

        if ($user->relationLoaded('role')) {
            $userRole = $user->getRelation('role');

            return $userRole !== null && $this->roles->contains('id', $userRole->id);
        }

        return false;
    }

    /**
     * Calculate if this reward should be given based on chances.
     */
    public function shouldBeAwarded(): bool
    {
        if ($this->chances >= 100) {
            return true;
        }

        $random = mt_rand(1, 10000) / 100;
        return $random <= $this->chances;
    }

    /**
     * Dispatch the reward to the user.
     */
    public function dispatch(User $user, Hunt $hunt): array
    {
        $result = [
            'success' => true,
            'money_given' => 0,
            'commands_executed' => [],
            'errors' => [],
        ];

        if ($this->money && $this->money > 0) {
            try {
                $user->addMoney($this->money);
                $result['money_given'] = $this->money;
            } catch (\Exception $e) {
                $result['errors'][] = trans('hunt::messages.errors.reward_money_failed', [
                    'error' => $e->getMessage(),
                ]);
                $result['success'] = false;
            }
        }

        if (! empty($this->scratch_card_id)
            && function_exists('scratch_game_give_ticket')
            && class_exists(ScratchCard::class)
        ) {
            $card = ScratchCard::query()->whereKey($this->scratch_card_id)->first();

            if ($card !== null && $card->is_enabled) {
                rescue(function () use ($card, $user) {
                    scratch_game_give_ticket($card, $user, 0.0, null, true);
                });
            }
        }

        $commands = $this->commands ?? [];

        if (!empty($commands)) {
            $processedCommands = array_map(function (string $command) use ($user, $hunt) {
                return str_replace([
                    '{player}', '{user}', '{hunt}', '{reward}', '{steam_id}', '{steam_id_32}',
                ], [
                    $user->name, $user->name, $hunt->name, $this->name,
                    $user->steam_id ?? '', $user->steam_id_32 ?? '',
                ], $command);
            }, $commands);

            try {
                foreach ($this->servers as $server) {
                    $server->bridge()->sendCommands($processedCommands, $user, $this->need_online);
                }
                $result['commands_executed'] = $processedCommands;
            } catch (\Exception $e) {
                $result['errors'][] = trans('hunt::messages.errors.reward_commands_failed', [
                    'error' => $e->getMessage(),
                ]);
                $result['success'] = false;
            }
        }

        return $result;
    }

    /**
     * Get eligible rewards for a user from a hunt.
     */
    public static function getEligibleRewards(Hunt $hunt, User $user): \Illuminate\Support\Collection
    {
        return $hunt->rewards()
                   ->enabled()
                   ->get()
                   ->filter(function (self $reward) use ($user) {
                       return $reward->isUserEligible($user);
                   });
    }

    /**
     * Select a random reward based on chances.
     */
    public static function selectRandomReward(\Illuminate\Support\Collection $rewards): ?self
    {
        $eligibleRewards = $rewards->filter(function (self $reward) {
            return $reward->shouldBeAwarded();
        });

        if ($eligibleRewards->isEmpty()) {
            return null;
        }

        $totalChances = $eligibleRewards->sum('chances');
        $random = mt_rand(1, $totalChances * 100) / 100;

        $currentSum = 0;
        foreach ($eligibleRewards as $reward) {
            $currentSum += $reward->chances;
            if ($random <= $currentSum) {
                return $reward;
            }
        }

        return $eligibleRewards->first();
    }
}
