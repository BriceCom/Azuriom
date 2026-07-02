<?php

namespace Azuriom\Plugin\Tasks\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Tasks\Models\Tag;
use Azuriom\Plugin\Tasks\Requests\TagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     */
    public function index()
    {
        $tags = Tag::paginate(15);

        return view('tasks::admin.tags.index', [
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create()
    {
        return view('tasks::admin.tags.create');
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(TagRequest $request)
    {
        Tag::create($request->validated());

        return redirect()->route('tasks.admin.tags.index')
            ->with('success', trans('tasks::admin.tags.created'));
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(Tag $tag)
    {
        return view('tasks::admin.tags.edit', [
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified tag in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return redirect()->route('tasks.admin.tags.index')
            ->with('success', trans('tasks::admin.tags.updated'));
    }

    /**
     * Remove the specified tag from storage.
     */
    public function destroy(Tag $tag)
    {
        if ($tag->tasks()->count() > 0) {
            return redirect()->route('tasks.admin.tags.index')
                ->with('error', trans('tasks::admin.tags.delete_error'));
        }

        $tag->delete();

        return redirect()->route('tasks.admin.tags.index')
            ->with('success', trans('tasks::admin.tags.deleted'));
    }
}
