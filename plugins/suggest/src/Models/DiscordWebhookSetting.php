<?php

namespace Azuriom\Plugin\Suggest\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class DiscordWebhookSetting extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'suggest_';

    /**
     * The table associated with the model.
     */
    protected $table = 'suggest_discord_webhook_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'webhook_url',
        'enabled',
        'send_on_create',
        'send_on_accept',
        'send_on_refuse',
        'color_created',
        'color_accepted',
        'color_refused',
        'template_created',
        'template_accepted',
        'template_refused',
        'custom_username',
        'custom_avatar_url',
        'show_author',
        'show_category',
        'show_votes',
        'show_description',
        'description_length',
        'custom_variables',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enabled' => 'boolean',
        'send_on_create' => 'boolean',
        'send_on_accept' => 'boolean',
        'send_on_refuse' => 'boolean',
        'show_author' => 'boolean',
        'show_category' => 'boolean',
        'show_votes' => 'boolean',
        'show_description' => 'boolean',
        'description_length' => 'integer',
        'custom_variables' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the singleton instance of Discord webhook settings.
     * Creates a new record if none exists.
     */
    public static function getInstance(): self
    {
        $settings = self::first();

        if (!$settings) {
            $settings = self::create([
                'webhook_url' => null,
                'enabled' => false,
                'send_on_create' => false,
                'send_on_accept' => false,
                'send_on_refuse' => false,
                'color_created' => '#00ff00',
                'color_accepted' => '#0099ff',
                'color_refused' => '#ff0000',
                'template_created' => null,
                'template_accepted' => null,
                'template_refused' => null,
                'custom_username' => null,
                'custom_avatar_url' => null,
                'show_author' => true,
                'show_category' => true,
                'show_votes' => true,
                'show_description' => true,
                'description_length' => 200,
                'custom_variables' => null,
            ]);
        }

        return $settings;
    }

    /**
     * Check if webhooks are enabled.
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Check if webhook should be sent for the given action.
     */
    public function shouldSendForAction(string $action): bool
    {
        if (!$this->isEnabled() || empty($this->webhook_url)) {
            return false;
        }

        return match ($action) {
            'created' => $this->send_on_create,
            'approved' => $this->send_on_accept,
            'rejected' => $this->send_on_refuse,
            default => false,
        };
    }

    /**
     * Get the color for a specific action.
     */
    public function getColorForAction(string $action): string
    {
        return match ($action) {
            'created' => $this->color_created ?? '#00ff00',
            'approved' => $this->color_accepted ?? '#0099ff',
            'rejected' => $this->color_refused ?? '#ff0000',
            default => '#666666',
        };
    }

    /**
     * Get the template for a specific action.
     */
    public function getTemplateForAction(string $action): ?string
    {
        return match ($action) {
            'created' => $this->template_created,
            'approved' => $this->template_accepted,
            'rejected' => $this->template_refused,
            default => null,
        };
    }

    /**
     * Get the default action text for a specific action.
     */
    public function getDefaultActionText(string $action): string
    {
        return match ($action) {
            'created' => 'New Suggestion',
            'approved' => 'Suggestion approved',
            'rejected' => 'Suggestion rejected',
            'pending' => 'Suggestion Pending',
            default => 'Suggestion Update',
        };
    }

    /**
     * Replace variables in a template string.
     */
    public function replaceVariables(string $template, array $variables): string
    {
        $replacements = [];

        // Add custom variables if they exist
        if ($this->custom_variables) {
            $replacements = array_merge($replacements, $this->custom_variables);
        }

        // Add provided variables
        $replacements = array_merge($replacements, $variables);

        // Replace variables in the format {variable_name}
        foreach ($replacements as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }

        return $template;
    }
}
