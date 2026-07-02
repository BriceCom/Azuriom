<?php

namespace Azuriom\Plugin\WebhookManager\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $url
 * @property string|null $bot_name
 * @property string|null $bot_avatar
 * @property string|null $default_color
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class WebhookService extends Model
{
    use HasTablePrefix;
    use Loggable;
    use Searchable;

    public const TYPE_DISCORD = 'discord';
    public const TYPE_CUSTOM = 'custom';

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'webhook_manager_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'url',
        'bot_name',
        'bot_avatar',
        'default_color',
    ];

    /**
     * The attributes that can be used for search.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'name',
        'type',
        'url',
    ];

    public function webhooks(): HasMany
    {
        return $this->hasMany(Webhook::class, 'service_id');
    }

    /**
     * @return array<int, string>
     */
    public static function types(): array
    {
        return [
            self::TYPE_DISCORD,
            self::TYPE_CUSTOM,
        ];
    }

    public function isDiscord(): bool
    {
        return $this->type === self::TYPE_DISCORD;
    }
}
