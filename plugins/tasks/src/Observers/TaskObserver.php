<?php

namespace Azuriom\Plugin\Tasks\Observers;

use Azuriom\Plugin\Tasks\Models\Status;
use Azuriom\Plugin\Tasks\Models\Task;
use Azuriom\Plugin\Tasks\Models\TaskLog;
use Azuriom\Plugin\Tasks\Services\DiscordWebhookService;
use Illuminate\Support\Facades\Auth;

class TaskObserver
{
    /**
     * The Discord webhook service.
     */
    protected DiscordWebhookService $discordWebhookService;

    /**
     * Create a new observer instance.
     */
    public function __construct(DiscordWebhookService $discordWebhookService)
    {
        $this->discordWebhookService = $discordWebhookService;
    }

    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $this->logAction($task, 'created', null, json_encode($task->toArray()));

        $this->discordWebhookService->sendTaskWebhook($task, 'created');
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $changes = $task->getChanges();

        // Remove timestamps from changes
        unset($changes['updated_at']);

        if (empty($changes)) {
            return;
        }

        $original = $task->getOriginal();
        $statusChanged = false;
        $startedChanged = false;
        $completedChanged = false;
        $archivedChanged = false;

        foreach ($changes as $key => $newValue) {
            $oldValue = $original[$key] ?? null;

            if ($oldValue == $newValue) {
                continue;
            }

            $this->logAction($task, 'updated_' . $key, $oldValue, $newValue);

            if ($key === 'status_id') {
                $statusChanged = true;

                $oldStatus = null;
                $newStatus = null;

                if ($oldValue) {
                    $oldStatusModel = Status::find($oldValue);
                    if ($oldStatusModel) {
                        $oldStatus = $oldStatusModel->name;
                    }
                }

                if ($newValue) {
                    $newStatusModel = Status::find($newValue);
                    if ($newStatusModel) {
                        $newStatus = $newStatusModel->name;
                    }
                }

                // Check if the task was started (moved to an "in progress" status)
                $inProgressStatuses = json_decode(setting('tasks.in_progress_statuses', '[]'), true) ?? [];
                if (in_array($newValue, $inProgressStatuses) && !in_array($oldValue, $inProgressStatuses)) {
                    $startedChanged = true;
                }

                // Check if the task was completed
                $completedStatuses = json_decode(setting('tasks.completed_statuses', '[]'), true) ?? [];
                if (in_array($newValue, $completedStatuses) && !in_array($oldValue, $completedStatuses)) {
                    $completedChanged = true;
                }

                if ($newStatus === 'Archived' || $newStatus === 'Closed') {
                    $archivedChanged = true;
                }

                $this->discordWebhookService->sendLogWebhook(
                    $task,
                    'updated_status',
                    $oldStatus,
                    $newStatus,
                    Auth::user() ? Auth::user()->name : null
                );
            } else {
                $this->discordWebhookService->sendLogWebhook(
                    $task,
                    'updated_' . $key,
                    $oldValue,
                    $newValue,
                    Auth::user() ? Auth::user()->name : null
                );
            }
        }

        if ($startedChanged) {
            $this->discordWebhookService->sendTaskWebhook($task, 'started');
        }

        if ($completedChanged) {
            $this->discordWebhookService->sendTaskWebhook($task, 'completed');
        }

        if ($archivedChanged) {
            $this->discordWebhookService->sendTaskWebhook($task, 'archived');
        }
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        $this->logAction($task, 'restored', null, json_encode($task->toArray()));

        $this->discordWebhookService->sendLogWebhook(
            $task,
            'restored',
            null,
            null,
            Auth::user() ? Auth::user()->name : null
        );
    }

    /**
     * Log an action on a task.
     */
    protected function logAction(Task $task, string $action, $oldValue, $newValue): void
    {
        TaskLog::create([
            'task_id' => $task->id,
            'action' => $action,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'user_id' => Auth::id(),
        ]);
    }
}
