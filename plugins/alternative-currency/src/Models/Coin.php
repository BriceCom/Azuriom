<?php

namespace Azuriom\Plugin\AlternativeCurrency\Models;

use Azuriom\Models\Traits\HasImage;
use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $image
 */
class Coin extends Model
{
    use HasTablePrefix, HasImage;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'alternative_currency_';

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
    ];

    protected $fillable = [
        'name', 'image', 'shop_currency'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->shop_currency) {
                // Vérifier s'il existe déjà un autre enregistrement avec `shop_currency = true`
                $existing = static::where('shop_currency', true)->first();

                $existing->shop_currency = false;
                $existing->save();
//                if ($existing && $existing->id !== $model->id) {
//                    throw new \Exception('Un seul coin peu être défini comme monnaie alternative pour le shop.');
//                }
            }
        });
    }

    /**
     * Scope a query to only shop_currency.
     */
    public function scopeShopCurrency(Builder $query): void
    {
        $query->whereShopCurrency(true)->first();
    }
}
