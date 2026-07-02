<?php

namespace Azuriom\Plugin\Trackurl\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasTablePrefix;
    use HasUser;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'trackurl_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'short_code',
        'destination_url',
        'blocked',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'blocked' => 'boolean',
    ];

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'user_id';

    /**
     * Get the user who created this link.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the clicks for this link.
     */
    public function clicks()
    {
        return $this->hasMany(Click::class);
    }

    /**
     * Get the number of clicks for this link.
     */
    public function getClicksCountAttribute()
    {
        return $this->clicks()->count();
    }
}
