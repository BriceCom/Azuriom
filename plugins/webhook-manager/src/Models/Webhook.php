<?php

namespace Azuriom\Plugin\WebhookManager\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property int $service_id
 * @property string $event
 * @property array<int|string, mixed> $payload_template
 * @property array<string, string>|null $headers
 * @property string|null $secret
 * @property int $timeout
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Webhook extends Model
{
    use HasTablePrefix;
    use Loggable;
    use Searchable;

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
        'service_id',
        'event',
        'payload_template',
        'headers',
        'secret',
        'timeout',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payload_template' => 'array',
        'headers' => 'array',
        'timeout' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that can be used for search.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'name',
        'event',
        'service.*',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(WebhookService::class, 'service_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(WebhookLog::class);
    }

    public function latestLog(): HasOne
    {
        return $this->hasOne(WebhookLog::class)->latestOfMany('sent_at');
    }

    /**
     * Scope a query to only include active webhooks.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by event.
     */
    public function scopeForEvent(Builder $query, string $event): void
    {
        $query->where('event', $event);
    }
}
