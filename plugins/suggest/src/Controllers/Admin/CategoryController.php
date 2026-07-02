<?php

namespace Azuriom\Plugin\Suggest\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Suggest\Models\Category;
use Azuriom\Plugin\Suggest\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::paginate(15);

        return view('suggest::admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('suggest::admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('suggest.admin.categories.index')
            ->with('success', trans('suggest::admin.categories.created'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('suggest::admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('suggest.admin.categories.index')
            ->with('success', trans('suggest::admin.categories.updated'));
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->suggestions()->exists()) {
            return redirect()->route('suggest.admin.categories.index')
                ->with('error', trans('suggest::admin.categories.delete_error'));
        }

        $category->delete();

        return redirect()->route('suggest.admin.categories.index')
            ->with('success', trans('suggest::admin.categories.deleted'));
    }
}
