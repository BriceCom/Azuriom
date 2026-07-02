<?php

namespace Azuriom\Plugin\ScratchGame\Models;

use Azuriom\Models\Server;
use Azuriom\Models\Traits\HasImage;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ScratchReward extends Model
{
    use HasImage;
    use HasTablePrefix;
    use Loggable;
    use Searchable;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'scratch_game_';

    /**
     * The table associated with the model.
     */
    protected $table = 'scratch_game_rewards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'image', 'chance', 'money', 'commands', 'need_online', 'is_enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'chance' => 'decimal:2',
        'money' => 'decimal:2',
        'commands' => 'array',
        'need_online' => 'boolean',
        'is_enabled' => 'boolean',
    ];

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'name',
    ];

    public function cards()
    {
        return $this->belongsToMany(ScratchCard::class, 'scratch_game_card_reward', 'reward_id', 'card_id');
    }

    public function servers()
    {
        return $this->belongsToMany(Server::class, 'scratch_game_reward_server', 'reward_id', 'server_id');
    }

    public function logs()
    {
        return $this->hasMany(ScratchLog::class, 'reward_id');
    }

    /**
     * Scope a query to only include enabled rewards.
     */
    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', true);
    }

    /**
     * Dispatch this reward to a user.
     *
     * @return array<string, mixed>
     */
    public function dispatch(User $user, ScratchCard $card): array
    {
        $result = [
            'success' => true,
            'money_given' => 0,
            'commands_executed' => [],
            'warnings' => [],
            'errors' => [],
        ];

        if ($this->money !== null && (float) $this->money > 0) {
            try {
                $user->addMoney((float) $this->money);
                $result['money_given'] = (float) $this->money;
            } catch (Exception $exception) {
                $result['errors'][] = trans('scratch-game::messages.errors.reward_money_failed', [
                    'error' => $exception->getMessage(),
                ]);
                $result['success'] = false;
            }
        }

        $commands = self::normalizeCommands($this->commands);

        if (! empty($commands)) {
            $commandsToExecute = [];
            $executedCommands = [];

            foreach ($commands as $entry) {
                $processedCommand = str_replace([
                    '{player}', '{user}', '{scratch}', '{card}', '{reward}', '{steam_id}', '{steam_id_32}',
                ], [
                    $user->name,
                    $user->name,
                    $card->name,
                    $card->name,
                    $this->name,
                    $user->steam_id ?? '',
                    $user->steam_id_32 ?? '',
                ], $entry['command']);

                $commandsToExecute[] = $processedCommand;
                $executedCommands[] = [
                    'name' => $entry['name'] ?: Str::limit($processedCommand, 120),
                    'command' => $processedCommand,
                ];
            }

            if ($this->servers->isEmpty()) {
                $result['errors'][] = trans('scratch-game::messages.errors.reward_commands_no_server');
                $result['success'] = false;

                return $result;
            }

            try {
                foreach ($this->servers as $server) {
                    $isAzLinkServer = Str::endsWith($server->type, 'azlink');
                    $needOnline = $this->need_online && $isAzLinkServer;

                    if ($this->need_online && ! $isAzLinkServer) {
                        $result['warnings'][] = trans('scratch-game::messages.errors.need_online_ignored', [
                            'server' => $server->name,
                        ]);
                    }

                    $server->bridge()->sendCommands($commandsToExecute, $user, $needOnline);
                }

                $result['commands_executed'] = $executedCommands;
            } catch (Exception $exception) {
                $result['errors'][] = trans('scratch-game::messages.errors.reward_commands_failed', [
                    'error' => $exception->getMessage(),
                ]);
                $result['success'] = false;
            }
        }

        return $result;
    }

    /**
     * Normalize commands from database/form payload.
     *
     * @param  mixed  $commands
     * @return array<int, array{name: string, command: string}>
     */
    public static function normalizeCommands(mixed $commands): array
    {
        if (! is_array($commands)) {
            return [];
        }

        $normalized = [];

        foreach ($commands as $entry) {
            if (is_string($entry)) {
                $command = trim($entry);

                if ($command === '') {
                    continue;
                }

                $normalized[] = [
                    'name' => '',
                    'command' => $command,
                ];

                continue;
            }

            if (! is_array($entry)) {
                continue;
            }

            $command = trim((string) ($entry['command'] ?? ''));
            $name = trim((string) ($entry['name'] ?? ''));

            if ($command === '') {
                continue;
            }

            $normalized[] = [
                'name' => $name,
                'command' => $command,
            ];
        }

        return $normalized;
    }

    /**
     * Pick a random reward based on the configured chance.
     */
    public static function selectRandomReward(Collection $rewards): ?self
    {
        $available = $rewards
            ->filter(fn (self $reward) => $reward->is_enabled)
            ->filter(fn (self $reward) => (float) $reward->chance > 0)
            ->values();

        if ($available->isEmpty()) {
            return null;
        }

        $total = (float) $available->sum(fn (self $reward) => (float) $reward->chance);

        if ($total <= 0) {
            return $available->random();
        }

        $random = mt_rand(1, 1000000) / 1000000 * $total;

        $cursor = 0;
        foreach ($available as $reward) {
            $cursor += (float) $reward->chance;

            if ($random <= $cursor) {
                return $reward;
            }
        }

        return $available->first();
    }
}
