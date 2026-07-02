<?php

namespace Azuriom\Plugin\Suggest\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'suggest_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'color',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the suggestions in this category.
     */
    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }
}
