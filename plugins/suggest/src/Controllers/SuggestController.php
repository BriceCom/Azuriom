<?php

namespace Azuriom\Plugin\Suggest\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Suggest\Models\Category;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Suggest\Requests\SuggestionRequest;
use Azuriom\Plugin\Suggest\Requests\VoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestController extends Controller
{
    /**
     * Display a listing of the suggestions.
     * Display a listing of the suggestions.
     */
    public function index(Request $request)
    {
        $query = Suggestion::with(['user', 'category']);

        // Apply filters
        $filter = $request->get('filter', 'pending');

        $categories = Category::orderBy('name')->get();
        $disableCategoryFilters = (bool) setting('suggest.disable_category_filters', false);
        $selectedCategory = $disableCategoryFilters ? null : $request->get('category');

        if (! $disableCategoryFilters && $selectedCategory !== null && $selectedCategory !== '') {
            $selectedCategoryId = (int) $selectedCategory;
            $category = $categories->firstWhere('id', $selectedCategoryId);

            if ($category !== null) {
                $query->where('category_id', $selectedCategoryId);
                $selectedCategory = (string) $selectedCategoryId;
            } else {
                $selectedCategory = null;
            }
        } else {
            $selectedCategory = null;
        }

        $categoryQuery = $selectedCategory !== null ? ['category' => $selectedCategory] : [];

        switch ($filter) {
            case 'all':
                $query->orderByDesc('created_at');
                break;
            case 'pending':
                $query->where('status', 'pending')
                    ->orderByDesc('created_at');
                break;
            case 'popular':
                // Order by most popular (upvotes - downvotes)
                $query->withCount(['upvotes', 'downvotes'])
                    ->orderByRaw('upvotes_count - downvotes_count DESC')
                    ->orderByRaw("CASE WHEN status IN ('approved', 'rejected') THEN 1 ELSE 0 END");
                break;
            case 'unpopular':
                // Order by least popular (upvotes - downvotes)
                $query->withCount(['upvotes', 'downvotes'])
                    ->orderByRaw('upvotes_count - downvotes_count ASC')
                    ->orderByRaw("CASE WHEN status IN ('approved', 'rejected') THEN 1 ELSE 0 END");
                break;
            case 'oldest':
                $query->orderBy('created_at')
                    ->orderByRaw("CASE WHEN status IN ('approved', 'rejected') THEN 1 ELSE 0 END");
                break;
            case 'mine':
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                }
                $query->orderByDesc('created_at')
                    ->orderByRaw("CASE WHEN status IN ('approved', 'rejected') THEN 1 ELSE 0 END");
                break;
            case 'approved':
                // Show only approved suggestions
                $query->where('status', 'approved')
                    ->orderByDesc('created_at');
                break;
            case 'rejected':
                // Show only rejected suggestions
                $query->where('status', 'rejected')
                    ->orderByDesc('created_at');
                break;
            case 'recent':
            default:
                $query->orderByDesc('created_at')
                    ->orderByRaw("CASE WHEN status IN ('approved', 'rejected') THEN 1 ELSE 0 END");
                break;
        }

        // Always load upvotes and downvotes counts for display
        $query->withCount(['upvotes', 'downvotes']);

        $suggestions = $query->paginate(10)->withQueryString();

        // If user is authenticated, check their votes for each suggestion
        if (Auth::check()) {
            $user = Auth::user();
            foreach ($suggestions as $suggestion) {
                $suggestion->hasUpvoted = $suggestion->hasUpvoted($user);
                $suggestion->hasDownvoted = $suggestion->hasDownvoted($user);
            }
        }

        return view('suggest::index', [
            'suggestions' => $suggestions,
            'filter' => $filter,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'categoryQuery' => $categoryQuery,
            'disableCategoryFilters' => $disableCategoryFilters,
        ]);
    }

    /**
     * Show the form for creating a new suggestion.
     */
    public function create(Request $request)
    {
        // Check if the user has reached the maximum number of pending suggestions they can create
        $maxSuggestions = setting('suggest.max_suggestions_per_user', 3);
        if ($maxSuggestions > 0) {
            $userPendingSuggestionsCount = Suggestion::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->count();
            if ($userPendingSuggestionsCount >= $maxSuggestions) {
                return redirect()->route('suggest.index')
                    ->with('error', trans('suggest::messages.max_suggestions_reached', ['max' => $maxSuggestions]));
            }
        }

        $categories = Category::all();
        $indexQuery = array_filter(
            $request->only(['filter', 'category']),
            static fn ($value) => $value !== null && $value !== ''
        );
        $selectedCategoryId = old('category_id', $request->query('category'));
        $maxDescriptionLength = (int) setting('suggest.max_description_length', 600);
        $oldContentDecoded = html_entity_decode((string) old('content', ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $currentDescriptionLength = mb_strlen(trim(strip_tags($oldContentDecoded)));

        return view('suggest::create', [
            'categories' => $categories,
            'indexQuery' => $indexQuery,
            'selectedCategoryId' => $selectedCategoryId,
            'maxDescriptionLength' => $maxDescriptionLength,
            'currentDescriptionLength' => $currentDescriptionLength,
        ]);
    }

    /**
     * Store a newly created suggestion in storage.
     */
    public function store(SuggestionRequest $request)
    {
        // Check if the user has reached the maximum number of pending suggestions they can create
        $maxSuggestions = setting('suggest.max_suggestions_per_user', 3);
        if ($maxSuggestions > 0) {
            $userPendingSuggestionsCount = Suggestion::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->count();
            if ($userPendingSuggestionsCount >= $maxSuggestions) {
                return redirect()->route('suggest.index')
                    ->with('error', trans('suggest::messages.max_suggestions_reached', ['max' => $maxSuggestions]));
            }
        }

        $suggestion = new Suggestion($request->validated());
        $suggestion->user_id = Auth::id();
        $suggestion->status = 'pending';
        $suggestion->save();

        return redirect()->route('suggest.show', $suggestion)
            ->with('success', trans('suggest::messages.created'));
    }

    /**
     * Display the specified suggestion.
     */
    public function show(Suggestion $suggestion)
    {
        $suggestion->load(['user', 'category', 'comments.author']);
        $suggestion->loadCount(['upvotes', 'downvotes']);

        $suggestion->comments->each(function ($comment) {
            $comment->loadCount(['upvotes', 'downvotes']);
        });

        $hasUpvoted = false;
        $hasDownvoted = false;

        if (Auth::check()) {
            $hasUpvoted = $suggestion->hasUpvoted(Auth::user());
            $hasDownvoted = $suggestion->hasDownvoted(Auth::user());
        }

        return view('suggest::show', [
            'suggestion' => $suggestion,
            'hasUpvoted' => $hasUpvoted,
            'hasDownvoted' => $hasDownvoted,
        ]);
    }

    /**
     * Vote for the specified suggestion.
     */
    public function vote(VoteRequest $request, Suggestion $suggestion)
    {
        $user = Auth::user();
        $type = $request->input('type');

        $suggestion->votes()
            ->updateOrCreate(
                ['user_id' => $user->id],
                ['type' => $type]
            );

        return redirect()->route('suggest.show', $suggestion)
            ->with('success', trans('suggest::messages.voted_' . $type));
    }

    /**
     * Remove a vote from the specified suggestion.
     */
    public function unvote(VoteRequest $request, Suggestion $suggestion)
    {
        $user = Auth::user();
        $type = $request->input('type');

        $suggestion->votes()
            ->where('user_id', $user->id)
            ->where('type', $type)
            ->delete();

        return redirect()->route('suggest.show', $suggestion)
            ->with('success', trans('suggest::messages.unvoted_' . $type));
    }

    /**
     * Update the specified suggestion in storage.
     */
    public function update(SuggestionRequest $request, Suggestion $suggestion)
    {
        // Check if the user is authorized to edit this suggestion
        $this->authorize('edit', $suggestion);

        $suggestion->update($request->validated());

        return redirect()->route('suggest.show', $suggestion)
            ->with('success', trans('suggest::messages.updated'));
    }


    /**
     * Remove the specified suggestion from storage.
     */
    public function destroy(Suggestion $suggestion)
    {
        // Check if the user is authorized to delete this suggestion
        $this->authorize('delete', $suggestion);

        $suggestion->delete();

        return redirect()->route('suggest.index')
            ->with('success', trans('suggest::messages.deleted'));
    }
}
