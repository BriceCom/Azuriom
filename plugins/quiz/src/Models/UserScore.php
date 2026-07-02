<?php

namespace Azuriom\Plugin\Quiz\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
    use HasTablePrefix;

    protected $tablePrefix = 'quiz_';

    protected $fillable = [
        'user_id', 'score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
