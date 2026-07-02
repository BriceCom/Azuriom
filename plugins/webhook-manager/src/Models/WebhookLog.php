<?php

namespace Azuriom\Plugin\WebhookManager\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $webhook_id
 * @property string $event
 * @property array<int|string, mixed> $payload_sent
 * @property array<string, string>|null $headers_sent
 * @property int|null $response_status
 * @property string|null $response_body
 * @property \Carbon\Carbon $sent_at
 */
class WebhookLog extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'webhook_manager_';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'webhook_id',
        'event',
        'payload_sent',
        'headers_sent',
        'response_status',
        'response_body',
        'sent_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payload_sent' => 'array',
        'headers_sent' => 'array',
        'response_status' => 'integer',
        'sent_at' => 'datetime',
    ];

    public function webhook(): BelongsTo
    {
        return $this->belongsTo(Webhook::class);
    }
}
