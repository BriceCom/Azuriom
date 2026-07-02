<?php

namespace Azuriom\Plugin\Tasks\Models;

use Illuminate\Support\Facades\DB;

class DiscordWebhookSetting
{
    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'tasks_';

    /**
     * The table associated with the model.
     */
    protected $table = 'tasks_discord_settings';

    protected array $settings = [];
    protected static ?self $instance = null;

    /**
     * Keys and their default values.
     * @return array<string, mixed>
     */
    protected static function defaults(): array
    {
        return [
            'webhook_url' => null,
            'enabled' => false,
            'webhook_url_created' => null,
            'send_on_created' => false,
            'webhook_url_started' => null,
            'send_on_started' => false,
            'webhook_url_completed' => null,
            'send_on_completed' => false,
            'webhook_url_archived' => null,
            'send_on_archived' => false,
            'webhook_url_comment' => null,
            'send_on_comment' => false,
            'webhook_url_logs' => null,
            'send_on_logs' => false,
            'color_created' => '#00ff00',
            'color_started' => '#0099ff',
            'color_completed' => '#00ff00',
            'color_archived' => '#666666',
            'color_comment' => '#ff9900',
            'color_logs' => '#ff00ff',
            'template_created' => null,
            'template_started' => null,
            'template_completed' => null,
            'template_archived' => null,
            'template_comment' => null,
            'template_logs' => null,
            'custom_username' => null,
            'custom_avatar_url' => null,
            'show_author' => true,
            'show_assignees' => true,
            'show_tags' => true,
            'show_description' => true,
            'description_length' => 200,
        ];
    }

    /**
     * Boolean keys for casting.
     * @return string[]
     */
    protected static function booleanKeys(): array
    {
        return [
            'enabled',
            'send_on_created',
            'send_on_started',
            'send_on_completed',
            'send_on_archived',
            'send_on_comment',
            'send_on_logs',
            'show_author',
            'show_assignees',
            'show_tags',
            'show_description',
        ];
    }

    protected static function integerKeys(): array
    {
        return ['description_length'];
    }

    protected function __construct()
    {
        $this->settings = static::defaults();

        if (DB::getSchemaBuilder()->hasTable($this->table)) {
            $rows = DB::table($this->table)->select(['key', 'value'])->get();

            foreach ($rows as $row) {
                $this->settings[$row->key] = $this->castIn($row->key, $row->value);
            }
        }
    }


    /**
     * Get singleton instance.
     */
    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * Update settings in the KV table (batch upsert) and refresh in-memory values.
     * @param array<string, mixed> $data
     */
    public function update(array $data): void
    {
        $now = now();

        foreach ($data as $key => $value) {
            $store = $this->castOut($key, $value);

            DB::table($this->table)->updateOrInsert(
                ['key' => $key],
                ['value' => $store, 'updated_at' => $now, 'created_at' => $now]
            );

            $this->settings[$key] = $this->castIn($key, $store);
        }
    }

    /** Magic getter for property-like access in views/controllers. */
    public function __get(string $name)
    {
        return $this->settings[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->settings);
    }

    protected function castIn(string $key, $value)
    {
        if ($value === null) {
            return null;
        }
        if (in_array($key, static::booleanKeys(), true)) {
            return $value === '1' || $value === 1 || $value === true || $value === 'true';
        }
        if (in_array($key, static::integerKeys(), true)) {
            return (int) $value;
        }
        return (string) $value;
    }

    protected function castOut(string $key, $value): ?string
    {
        if ($value === null) {
            return null;
        }
        if (in_array($key, static::booleanKeys(), true)) {
            return $value ? '1' : '0';
        }
        if (in_array($key, static::integerKeys(), true)) {
            return (string) ((int) $value);
        }
        return (string) $value;
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
        if (!$this->isEnabled()) {
            return false;
        }

        $webhookUrl = $this->getWebhookUrlForAction($action);
        if (empty($webhookUrl)) {
            if (empty($this->webhook_url)) {
                return false;
            }
        }

        return match ($action) {
            'created' => $this->send_on_created,
            'started' => $this->send_on_started,
            'completed' => $this->send_on_completed,
            'archived' => $this->send_on_archived,
            'restored' => $this->send_on_archived,
            'updated' => $this->send_on_logs,
            'comment' => $this->send_on_comment,
            'logs' => $this->send_on_logs,
            default => false,
        };
    }

    /**
     * Get the webhook URL for a specific action.
     * Falls back to the global webhook URL if no specific URL is set.
     */
    public function getWebhookUrlForAction(string $action): ?string
    {
        $specificUrl = match ($action) {
            'created' => $this->webhook_url_created,
            'started' => $this->webhook_url_started,
            'completed' => $this->webhook_url_completed,
            'archived' => $this->webhook_url_archived,
            'restored' => $this->webhook_url_archived,
            'updated' => $this->webhook_url_logs,
            'comment' => $this->webhook_url_comment,
            'logs' => $this->webhook_url_logs,
            default => null,
        };

        return $specificUrl ?: $this->webhook_url;
    }

    /**
     * Get the color for a specific action.
     */
    public function getColorForAction(string $action): string
    {
        return match ($action) {
            'created' => $this->color_created ?? '#00ff00',
            'started' => $this->color_started ?? '#0099ff',
            'completed' => $this->color_completed ?? '#00ff00',
            'archived' => $this->color_archived ?? '#666666',
            'restored' => $this->color_archived ?? '#666666',
            'updated' => $this->color_logs ?? '#ff00ff',
            'comment' => $this->color_comment ?? '#ff9900',
            'logs' => $this->color_logs ?? '#ff00ff',
            default => '#666666',
        };
    }

    /**
     * Get the default action text for a specific action.
     */
    public function getDefaultActionText(string $action): string
    {
        return match ($action) {
            'created' => trans('tasks::admin.logs.created'),
            'started' => trans('tasks::admin.settings.discord.event_started'),
            'completed' => trans('tasks::admin.settings.discord.event_completed'),
            'archived' => trans('tasks::admin.settings.discord.event_archived'),
            'restored' => trans('tasks::admin.logs.restored'),
            'updated' => trans('tasks::admin.logs.updated'),
            'comment' => trans('tasks::admin.settings.discord.event_comment'),
            'logs' => trans('tasks::admin.settings.discord.event_logs'),
            default => 'Task Update',
        };
    }

    /**
     * Get the template for a specific action.
     */
    public function getTemplateForAction(string $action): ?string
    {
        return match ($action) {
            'created' => $this->template_created,
            'started' => $this->template_started,
            'completed' => $this->template_completed,
            'archived' => $this->template_archived,
            'restored' => $this->template_archived,
            'updated' => $this->template_logs,
            'comment' => $this->template_comment,
            'logs' => $this->template_logs,
            default => null,
        };
    }

    /**
     * Replace variables in a template string.
     */
    public function replaceVariables(string $template, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }

        return $template;
    }
}
