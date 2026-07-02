<?php

namespace Azuriom\Plugin\Suggest\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function show()
    {
        return view('suggest::admin.settings', [
            'maxSuggestionsPerUser' => setting('suggest.max_suggestions_per_user', 3),
            'maxDescriptionLength' => setting('suggest.max_description_length', 600),
            'indexTitle' => setting('suggest.index.title', trans('suggest::messages.title')),
            'indexSubtitle' => setting('suggest.index.subtitle', trans('suggest::messages.description')),
            'enableComments' => setting('suggest.enable_comments', true),
            'disableCategoryFilters' => setting('suggest.disable_category_filters', false),
            'filterAll' => setting('suggest.filters.all', true),
            'filterPending' => setting('suggest.filters.pending', true),
            'filterApproved' => setting('suggest.filters.approved', true),
            'filterRejected' => setting('suggest.filters.rejected', true),
            'filterRecent' => setting('suggest.filters.recent', true),
            'filterOldest' => setting('suggest.filters.oldest', true),
            'filterPopular' => setting('suggest.filters.popular', true),
            'filterUnpopular' => setting('suggest.filters.unpopular', true),
            'filterMine' => setting('suggest.filters.mine', true),
        ]);
    }

    /**
     * Update the settings.
     */
    public function save(Request $request)
    {
        $validated = $request->validate([
            'max_suggestions_per_user' => ['nullable', 'integer', 'min:1'],
            'max_description_length' => ['nullable', 'integer', 'min:50', 'max:4000'],
            'index_title' => ['nullable', 'string', 'max:100'],
            'index_subtitle' => ['nullable', 'string', 'max:255'],
            'enable_comments' => ['nullable', 'boolean'],
            'disable_category_filters' => ['nullable', 'boolean'],
            'filter_all' => ['nullable', 'boolean'],
            'filter_pending' => ['nullable', 'boolean'],
            'filter_approved' => ['nullable', 'boolean'],
            'filter_rejected' => ['nullable', 'boolean'],
            'filter_recent' => ['nullable', 'boolean'],
            'filter_oldest' => ['nullable', 'boolean'],
            'filter_popular' => ['nullable', 'boolean'],
            'filter_unpopular' => ['nullable', 'boolean'],
            'filter_mine' => ['nullable', 'boolean'],
        ]);

        Setting::updateSettings([
            'suggest.max_suggestions_per_user' => $validated['max_suggestions_per_user'],
            'suggest.max_description_length' => $validated['max_description_length'],
            'suggest.index.title' => $validated['index_title'],
            'suggest.index.subtitle' => $validated['index_subtitle'],
            'suggest.enable_comments' => $validated['enable_comments'] ?? false,
            'suggest.disable_category_filters' => $validated['disable_category_filters'] ?? false,
            'suggest.filters.all' => $validated['filter_all'] ?? false,
            'suggest.filters.pending' => $validated['filter_pending'] ?? false,
            'suggest.filters.approved' => $validated['filter_approved'] ?? false,
            'suggest.filters.rejected' => $validated['filter_rejected'] ?? false,
            'suggest.filters.recent' => $validated['filter_recent'] ?? false,
            'suggest.filters.oldest' => $validated['filter_oldest'] ?? false,
            'suggest.filters.popular' => $validated['filter_popular'] ?? false,
            'suggest.filters.unpopular' => $validated['filter_unpopular'] ?? false,
            'suggest.filters.mine' => $validated['filter_mine'] ?? false,
        ]);


        return redirect()->route('suggest.admin.settings')
            ->with('success', trans('admin.settings.updated'));
    }
}
