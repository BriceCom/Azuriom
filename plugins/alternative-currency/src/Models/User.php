<?php

namespace Azuriom\Plugin\AlternativeCurrency\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Plugin\AlternativeCurrency\Models\Traits\InteractsWithAmount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $coin_id
 * @property int $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model
{
    use HasTablePrefix;
    use HasUser;
    use Searchable;
    use InteractsWithAmount;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'alternative_currency_';

    /**
     * The attributes that can be used for search.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'user.*'
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    protected $fillable = [
        'user_id', 'coin_id', 'amount'
    ];

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'user_id';

    /**
     * Get the user who created this ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\Azuriom\Models\User::class, 'user_id');
    }

    /**
     * Get coin related
     */
    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
