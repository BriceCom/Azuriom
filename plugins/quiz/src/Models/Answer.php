<?php

namespace Azuriom\Plugin\Quiz\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasTablePrefix;

    protected $tablePrefix = 'quiz_';

    protected $fillable = [
        'question_id', 'answer', 'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
