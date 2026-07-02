<?php

namespace Azuriom\Plugin\Quiz\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix for this model.
     *
     * @var string
     */
    protected $tablePrefix = 'quiz_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 'difficulty', 'reward', 'time_limit', 'activation_date', 'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'activation_date' => 'date',
        'time_limit' => 'integer',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
