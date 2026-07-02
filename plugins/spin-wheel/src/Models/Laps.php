<?php

namespace Azuriom\Plugin\SpinWheel\Models;

use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;
use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laps extends Model
{
    use HasTablePrefix;
    use HasFactory;
    use HasUser;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'spin_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'reward_id', 'reward_name', 'created_at', "updated_at", 'spin_price', 'money_added'
    ];

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $playerKey = 'user_id';

    /**
     * Get the user who created this ticket.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
