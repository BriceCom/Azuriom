<?php

namespace Azuriom\Plugin\ScratchGame\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ScratchLog extends Model
{
    use HasTablePrefix;

    private static ?bool $hasClaimedAtColumn = null;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'scratch_game_';

    /**
     * The table associated with the model.
     */
    protected $table = 'scratch_game_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'card_id',
        'user_id',
        'reward_id',
        'price_paid',
        'money_given',
        'commands_executed',
        'ip_address',
        'user_agent',
        'claimed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_paid' => 'decimal:2',
        'money_given' => 'decimal:2',
        'commands_executed' => 'array',
        'claimed_at' => 'datetime',
    ];

    public function card()
    {
        return $this->belongsTo(ScratchCard::class, 'card_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reward()
    {
        return $this->belongsTo(ScratchReward::class, 'reward_id');
    }

    /**
     * Return normalized executed commands for display.
     *
     * @return array<int, array{name: string, command: string}>
     */
    public function executedCommands(): array
    {
        $commands = $this->commands_executed;

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
                    'name' => $command,
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
                'name' => $name !== '' ? $name : $command,
                'command' => $command,
            ];
        }

        return $normalized;
    }

    /**
     * Scope a query to only include logs pending scratch reveal.
     */
    public function scopePending(Builder $query): void
    {
        if (self::hasClaimedAtColumn()) {
            $query->whereNull('claimed_at')
                ->where('money_given', '<=', 0)
                ->whereNull('commands_executed');

            return;
        }

        $query->where('money_given', '<=', 0)
            ->whereNull('commands_executed');
    }

    /**
     * Determine if this log has already been claimed.
     */
    public function isClaimed(): bool
    {
        if (self::hasClaimedAtColumn() && $this->claimed_at !== null) {
            return true;
        }

        return (float) $this->money_given > 0 || ! empty($this->commands_executed);
    }

    /**
     * Determine if scratch_game_logs table has the claimed_at column.
     */
    public static function hasClaimedAtColumn(): bool
    {
        if (self::$hasClaimedAtColumn === null) {
            self::$hasClaimedAtColumn = Schema::hasColumn((new self())->getTable(), 'claimed_at');
        }

        return self::$hasClaimedAtColumn;
    }

    public static function logPlay(
        ScratchCard $card,
        User $user,
        ?ScratchReward $reward,
        float $pricePaid,
        float $moneyGiven,
        array $commandsExecuted = [],
        ?string $ip = null,
        ?string $userAgent = null
    ): self {
        return self::create([
            'card_id' => $card->id,
            'user_id' => $user->id,
            'reward_id' => $reward?->id,
            'price_paid' => $pricePaid,
            'money_given' => $moneyGiven,
            'commands_executed' => ! empty($commandsExecuted) ? $commandsExecuted : null,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
        ]);
    }
}
