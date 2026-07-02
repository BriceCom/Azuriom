<?php

namespace Azuriom\Plugin\Quiz\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasTablePrefix;

    protected $tablePrefix = 'quiz_';

    protected $fillable = [
        'user_id', 'question_id', 'answer_id', 'status', 'reward_payload',
    ];

    protected $casts = [
        'reward_payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
