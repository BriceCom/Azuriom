<?php

namespace Azuriom\Plugin\Tasks\Services;

use Azuriom\Plugin\Tasks\Models\DiscordWebhookSetting;
use Azuriom\Plugin\Tasks\Models\Task;
use Azuriom\Plugin\Tasks\Models\TaskComment;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Support\Discord\Embed;
use Illuminate\Support\Str;

class DiscordWebhookService
{
    /**
     * Send a Discord webhook for a task.
     *
     * @param Task $task The task
     * @param string $action The action (created, started, completed, archived)
     * @return void
     */
    public function sendTaskWebhook(Task $task, string $action): void
    {
        $settings = DiscordWebhookSetting::getInstance();

        if (!$settings->shouldSendForAction($action)) {
            return;
        }

        $webhookUrl = $settings->getWebhookUrlForAction($action);
        if (empty($webhookUrl)) {
            return;
        }

        try {
            $color = $settings->getColorForAction($action);

            $variables = [
                'title' => $task->title,
                'author' => $task->author->name,
                'status' => $task->status->name ?? trans('tasks::admin.discord.none'),
                'url' => route('tasks.admin.show', $task),
                'description' => $task->description,
            ];

            $template = $settings->getTemplateForAction($action);
            $content = $template
                ? $settings->replaceVariables($template, $variables)
                : '📝 **' . $settings->getDefaultActionText($action) . '**';

            $embed = Embed::create()
                ->title($task->title)
                ->color($color)
                ->url(route('tasks.admin.show', $task))
                ->timestamp($task->created_at);

            if ($settings->show_description) {
                $descLength = $settings->description_length ?? 200;
                $description = strip_tags($task->description);
                $description = strlen($description) > $descLength
                    ? Str::limit($description, $descLength)
                    : $description;
                $embed->description($description);
            }

            if ($settings->show_author) {
                $embed->author($task->author->name, null, $task->author->getAvatar());
            }

            if ($settings->show_tags && $task->tags->isNotEmpty()) {
                $tagNames = $task->tags->pluck('name')->implode(', ');
                $embed->addField(trans('tasks::admin.discord.tags'), $tagNames, true);
            }

            if ($settings->show_assignees && $task->assignees->isNotEmpty()) {
                $assigneeNames = $task->assignees->pluck('name')->implode(', ');
                $embed->addField(trans('tasks::admin.discord.assignees'), $assigneeNames, true);
            }

            $embed->addField(trans('tasks::admin.discord.status'), $task->status->name ?? trans('tasks::admin.discord.none'), true);

            $embed->addField(trans('tasks::admin.discord.priority'), $task->priority, true);

            if ($task->started_at) {
                $embed->addField(trans('tasks::admin.discord.started'), $task->started_at->format('Y-m-d'), true);
            }

            if ($task->limited_at) {
                $embed->addField(trans('tasks::admin.discord.due_date'), $task->limited_at->format('Y-m-d'), true);
            }

            $webhook = DiscordWebhook::create()->content($content)->addEmbed($embed);

            if ($settings->custom_username) {
                $webhook->username($settings->custom_username);
            }

            if ($settings->custom_avatar_url) {
                $webhook->avatarUrl($settings->custom_avatar_url);
            }

            $webhook->send($webhookUrl, false);
        } catch (\Exception $e) {
            logger()->error('Discord webhook failed: ' . $e->getMessage());
        }
    }

    /**
     * Send a Discord webhook for a task comment.
     *
     * @param TaskComment $comment The comment
     * @return void
     */
    public function sendCommentWebhook(TaskComment $comment): void
    {
        $settings = DiscordWebhookSetting::getInstance();

        if (!$settings->shouldSendForAction('comment')) {
            return;
        }

        $webhookUrl = $settings->getWebhookUrlForAction('comment');
        if (empty($webhookUrl)) {
            return;
        }

        try {
            $task = $comment->task;
            $color = $settings->getColorForAction('comment');

            $variables = [
                'title' => $task->title,
                'author' => $comment->author->name,
                'status' => $task->status->name ?? trans('tasks::admin.discord.none'),
                'url' => route('tasks.admin.show', $task),
                'description' => $comment->content,
            ];

            // Get custom template or use default
            $template = $settings->getTemplateForAction('comment');
            $content = $template
                ? $settings->replaceVariables($template, $variables)
                : '💬 **' . $settings->getDefaultActionText('comment') . '**';

            $embed = Embed::create()
                ->title(trans('tasks::admin.discord.comment_on') . ' ' . $task->title)
                ->color($color)
                ->url(route('tasks.admin.show', $task))
                ->timestamp($comment->created_at);

            $descLength = $settings->description_length ?? 200;
            $commentContent = strip_tags($comment->content);
            $commentContent = strlen($commentContent) > $descLength
                ? Str::limit($commentContent, $descLength)
                : $commentContent;
            $embed->description($commentContent);

            $embed->author($comment->author->name, null, $comment->author->getAvatar());

            $embed->addField(trans('tasks::admin.discord.task_status'), $task->status->name ?? trans('tasks::admin.discord.none'), true);

            $webhook = DiscordWebhook::create()->content($content)->addEmbed($embed);

            if ($settings->custom_username) {
                $webhook->username($settings->custom_username);
            }

            if ($settings->custom_avatar_url) {
                $webhook->avatarUrl($settings->custom_avatar_url);
            }

            $webhook->send($webhookUrl, false);
        } catch (\Exception $e) {
            logger()->error('Discord webhook failed: ' . $e->getMessage());
        }
    }

    /**
     * Send a Discord webhook for a task log.
     *
     * @param Task $task The task
     * @param string $action The log action
     * @param string|null $oldValue The old value
     * @param string|null $newValue The new value
     * @param string|null $username The username who performed the action
     * @return void
     */
    public function sendLogWebhook(Task $task, string $action, ?string $oldValue = null, ?string $newValue = null, ?string $username = null): void
    {
        $settings = DiscordWebhookSetting::getInstance();

        if (!$settings->shouldSendForAction('logs')) {
            return;
        }

        $webhookUrl = $settings->getWebhookUrlForAction('logs');
        if (empty($webhookUrl)) {
            return;
        }

        try {
            $color = $settings->getColorForAction('logs');

            $variables = [
                'title' => $task->title,
                'author' => $username ?? trans('tasks::admin.discord.system'),
                'status' => $task->status->name ?? trans('tasks::admin.discord.none'),
                'url' => route('tasks.admin.show', $task),
                'description' => trans('tasks::admin.discord.action') . ' ' . ucfirst(str_replace('_', ' ', $action)),
            ];

            $template = $settings->getTemplateForAction('logs');
            $content = $template
                ? $settings->replaceVariables($template, $variables)
                : '📋 **' . trans('tasks::admin.discord.task_log_update') . '**';

            $embed = Embed::create()
                ->title(trans('tasks::admin.discord.log_for') . ' ' . $task->title)
                ->color($color)
                ->url(route('tasks.admin.show', $task))
                ->timestamp(now());

            $actionDesc = trans('tasks::admin.discord.action') . ' ' . ucfirst(str_replace('_', ' ', $action));
            if ($username) {
                $actionDesc .= ' ' . trans('tasks::admin.discord.by') . ' ' . $username;
            }
            $embed->description($actionDesc);

            if ($oldValue !== null) {
                $embed->addField(trans('tasks::admin.discord.old_value'), $oldValue, true);
            }

            if ($newValue !== null) {
                $embed->addField(trans('tasks::admin.discord.new_value'), $newValue, true);
            }

            $embed->addField(trans('tasks::admin.discord.task_status'), $task->status->name ?? trans('tasks::admin.discord.none'), true);

            $webhook = DiscordWebhook::create()->content($content)->addEmbed($embed);

            if ($settings->custom_username) {
                $webhook->username($settings->custom_username);
            }

            if ($settings->custom_avatar_url) {
                $webhook->avatarUrl($settings->custom_avatar_url);
            }

            $webhook->send($webhookUrl, false);
        } catch (\Exception $e) {
            logger()->error('Discord webhook failed: ' . $e->getMessage());
        }
    }
}
