<?php

namespace Modules\Categories\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Traits\HasSearchable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Categories\Http\Controllers\Traits\HasValidation;
use Modules\Categories\Models\Category;

class CategoryController extends Controller
{
    use HasValidation, HasSearchable;
    public function index()
    {
        $paginate = Category::select(
            'categories.id',
            'categories.name as name',
            'parent.name as parent_name',
            'categories.status'
        )
            ->leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')->paginate(12);
        return Inertia::render('Category/Index', [
            'paginate' => $paginate
        ]);
    }

    public function create()
    {
        return Inertia::render('Category/Create');
    }

    public function store(Request $request)
    {
        $validator = $this->validate($request->all());
        if ($validator->fails()) {
            return redirect()->route('categories.create')->withErrors($validator)->withInput();
        }

        Category::create($validator->validated());
        return redirect()->route('categories.create')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        $category->load('parent');
        return Inertia::render('Category/Edit', [
            'category' => $category
        ]);
    }

    public function update(Category $category, Request $request)
    {
        $validator = $this->validate($request->all(), $category->id);
        if ($validator->fails()) {
            return redirect()->route('categories.edit', $category->id)->withErrors($validator)->withInput();
        }
        $category->update($validator->validated());
        return redirect()->route('categories.edit', $category->id)->with('success', 'Category updated successfully');
    }

    public function bulkDestroy(Request $request)
    {
        Category::destroy($request->ids);
        return redirect()->route('categories.index')->with('success', 'Categories deleted successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
