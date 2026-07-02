<?php

namespace Azuriom\Plugin\ScratchGame\Models;

use Azuriom\Models\Role;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScratchCard extends Model
{
    use HasTablePrefix;
    use Loggable;
    use Searchable;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'scratch_game_';

    /**
     * The table associated with the model.
     */
    protected $table = 'scratch_game_cards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'cover_image', 'background_image', 'price', 'free_interval_minutes', 'is_enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'free_interval_minutes' => 'integer',
        'is_enabled' => 'boolean',
    ];

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'name',
    ];

    protected static function booted(): void
    {
        static::deleted(function (self $card) {
            $card->deleteCoverImage();
            $card->deleteBackgroundImage();
        });
    }

    public function rewards()
    {
        return $this->belongsToMany(ScratchReward::class, 'scratch_game_card_reward', 'card_id', 'reward_id');
    }

    public function enabledRewards()
    {
        return $this->belongsToMany(ScratchReward::class, 'scratch_game_card_reward', 'card_id', 'reward_id')
            ->where('scratch_game_rewards.is_enabled', true);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'scratch_game_card_role', 'card_id', 'role_id');
    }

    public function logs()
    {
        return $this->hasMany(ScratchLog::class, 'card_id');
    }

    /**
     * Scope a query to only include enabled cards.
     */
    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', true);
    }

    /**
     * Check if a user can access this card based on roles.
     */
    public function isUserEligible(?User $user): bool
    {
        if ($this->roles->isEmpty()) {
            return true;
        }

        if ($user === null) {
            return false;
        }

        return $this->roles->contains('id', $user->role_id);
    }

    public function coverImageUrl(): ?string
    {
        if ($this->cover_image === null) {
            return null;
        }

        if (Str::contains($this->cover_image, '/')) {
            return url(Storage::disk('public')->url($this->cover_image));
        }

        return image_url($this->cover_image);
    }

    public function backgroundImageUrl(): ?string
    {
        if ($this->background_image === null) {
            return null;
        }

        if (Str::contains($this->background_image, '/')) {
            return url(Storage::disk('public')->url($this->background_image));
        }

        return image_url($this->background_image);
    }

    public function storeCoverImage(UploadedFile $file, bool $save = false): ?string
    {
        return $this->storeCustomImage('cover_image', 'scratch-game/cards/covers', $file, $save);
    }

    public function storeBackgroundImage(UploadedFile $file, bool $save = false): ?string
    {
        return $this->storeCustomImage('background_image', 'scratch-game/cards/backgrounds', $file, $save);
    }

    public function deleteCoverImage(bool $save = false): bool
    {
        return $this->deleteCustomImage('cover_image', $save);
    }

    public function deleteBackgroundImage(bool $save = false): bool
    {
        return $this->deleteCustomImage('background_image', $save);
    }

    protected function storeCustomImage(string $key, string $path, UploadedFile $file, bool $save = false): ?string
    {
        $this->deleteCustomImage($key);

        $storedPath = $file->storePublicly($path, 'public');

        $this->setAttribute($key, $storedPath);

        if ($save) {
            $this->save();
        }

        $attribute = $this->getAttribute($key);

        if ($attribute === null) {
            return null;
        }

        return url(Storage::disk('public')->url($attribute));
    }

    protected function deleteCustomImage(string $key, bool $save = false): bool
    {
        $image = $this->getAttribute($key);

        if ($image === null) {
            return false;
        }

        if (Str::startsWith($image, 'scratch-game/')) {
            Storage::disk('public')->delete($image);
        }

        $this->setAttribute($key, null);

        if ($save) {
            $this->save();
        }

        return true;
    }
}
