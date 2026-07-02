<?php

namespace Azuriom\Plugin\Suggest\Observers;

use Azuriom\Plugin\Suggest\Controllers\Admin\DiscordController;
use Azuriom\Plugin\Suggest\Models\Suggestion;

class SuggestionObserver
{
    /**
     * Handle the Suggestion "created" event.
     */
    public function created(Suggestion $suggestion): void
    {
        // Load relationships needed for webhook
        $suggestion->load(['user', 'category']);

        // Send Discord webhook for new suggestion
        DiscordController::sendSuggestionWebhook($suggestion, 'created');
    }

    /**
     * Handle the Suggestion "updated" event.
     */
    public function updated(Suggestion $suggestion): void
    {
        // Check if the status has changed
        // Load relationships needed for webhook
        $suggestion->load(['user', 'category']);

        // Send Discord webhook for status change
        DiscordController::sendSuggestionWebhook($suggestion, $suggestion->status);
    }
}
