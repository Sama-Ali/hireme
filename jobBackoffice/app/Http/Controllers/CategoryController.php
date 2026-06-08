<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $showArchived = request()->boolean('archived');

        $categories = $showArchived
            ? Category::onlyTrashed()->orderBy('name')->get()
            : Category::orderBy('name')->get();

        return view('category.index', compact('categories', 'showArchived'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index')->with('status', 'Category created successfully');
    }

    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        if ($category->trashed()) {
            return redirect()->route('categories.show', $category);
        }

        return view('category.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {

        $category->update($request->validated());

        return redirect()->route('categories.show', $category)->with('status', "Category \"{$category->name}\" has been updated.");
    }

    public function destroy(Category $category)
    {

        $category->delete();

        return redirect()->route('categories.index')->with('status', "Category \"{$category->name}\" has been archived.");
    }

    public function restore(string $category)
    {
        $model = Category::onlyTrashed()->whereKey($category)->firstOrFail();

        $name = $model->name;
        $model->restore();

        return redirect()
            ->route('categories.index', ['archived' => true])
            ->with('status', __('Category ":name" has been restored.', ['name' => $name]));
    }
}
