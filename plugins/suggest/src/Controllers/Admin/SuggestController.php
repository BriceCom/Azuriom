<?php

namespace Azuriom\Plugin\Suggest\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Plugin\Suggest\Models\Category;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Suggest\Requests\SuggestionRequest;
use Azuriom\Plugin\Suggest\Requests\StatusRequest;
use Illuminate\Http\Request;

class SuggestController extends Controller
{
    /**
     * Display a listing of the suggestions.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $suggestions = Suggestion::with('user')
            ->where('status', $status)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('suggest::admin.index', [
            'suggestions' => $suggestions,
            'currentStatus' => $status
        ]);
    }

    /**
     * Display archived suggestions (approved and rejected).
     */
    public function archive(Request $request)
    {
        $status = $request->get('status');

        $query = Suggestion::with('user');

        if ($status && in_array($status, ['approved', 'rejected'])) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['approved', 'rejected']);
        }

        $suggestions = $query->orderByDesc('created_at')->paginate(15);

        return view('suggest::admin.index', [
            'suggestions' => $suggestions,
            'currentStatus' => $status ?: 'archived',
            'isArchive' => true
        ]);
    }

    /**
     * Show the form for editing the specified suggestion.
     */
    public function edit(Suggestion $suggestion)
    {
        $categories = Category::all();

        return view('suggest::admin.edit', [
            'suggestion' => $suggestion,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified suggestion in storage.
     */
    public function update(SuggestionRequest $request, Suggestion $suggestion)
    {
        // Load relationships for logging before update
        $suggestion->load(['user', 'category']);

        // Store original data for logging
        $originalData = [
            'title' => $suggestion->title,
            'category' => $suggestion->category->name ?? null,
            'author' => $suggestion->user->name,
        ];

        $suggestion->update($request->validated());

        // Log the admin edit action
        ActionLog::log('suggest.edited', $suggestion, $originalData);

        return redirect()->route('suggest.admin.index')
            ->with('success', trans('suggest::admin.suggestions.updated'));
    }

    /**
     * Remove the specified suggestion from storage.
     */
    public function destroy(Suggestion $suggestion)
    {
        // Load relationships for logging before deletion
        $suggestion->load(['user', 'category']);

        // Store data for logging before deletion
        $suggestionData = [
            'title' => $suggestion->title,
            'category' => $suggestion->category->name ?? null,
            'author' => $suggestion->user->name,
        ];

        // Log the action before deletion
        ActionLog::log('suggest.deleted', $suggestion, $suggestionData);

        $suggestion->delete();

        return redirect()->route('suggest.admin.index')
            ->with('success', trans('suggest::admin.suggestions.deleted'));
    }

    /**
     * Update the status of the specified suggestion.
     */
    public function updateStatus(StatusRequest $request, Suggestion $suggestion)
    {
        $suggestion->update($request->validated());

        return redirect()->route('suggest.admin.index')
            ->with('success', trans('suggest::admin.suggestions.status_updated'));
    }
}
