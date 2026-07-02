<?php

namespace Azuriom\Plugin\FAQ\Models;

use Azuriom\Models\Traits\Attachable;
use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $answer
 * @property int $position
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Question extends Model
{
    use Attachable;
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'faq_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'answer', 'position',
    ];

    public function getAttachmentsKey(): string
    {
        return 'answer';
    }

    public function getAttachmentsPath(): string
    {
        return 'faq/questions/attachments';
    }
}
