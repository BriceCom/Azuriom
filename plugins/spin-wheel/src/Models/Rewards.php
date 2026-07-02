<?php

namespace Azuriom\Plugin\SpinWheel\Models;

use Illuminate\Database\Eloquent\Model;
use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rewards extends Model
{
    use HasFactory;
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'spin_';

    protected $fillable = [
        'name', 
        'chances', 
        'money', 
        'scratch_card_id',
        'need_online',
        'commands',
        'is_enabled',
        'color',
        'textFontSize',
        'textOrientation',
        'textDirection',
        'money_added',
        'send_webhook',
        'servers_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'commands' => 'array',
        'servers_id' => 'array',
        'scratch_card_id' => 'integer',
    ];

    public function getBadgeStyle()
    {
        $color = color_contrast($this->color);

        return "color: {$color}; background: {$this->color};";
    }

    public function getColor() {
        $color = color_contrast($this->color);
        return (object) ['color' => $color, 'background' => $this->color];
    }

    public function getTotalLuck() {
        $globalLuck = 0;

        foreach(Rewards::all() as $reward) {
            if($reward->is_enabled) {
                $globalLuck = $globalLuck + $reward->chances;
            };
        };

        return $globalLuck;
    }

    public function getSize() {
        return ($this->chances * 360) / $this->getTotalLuck();
    }

    public function getServers() {
        return $this->servers_id;
    }
}
