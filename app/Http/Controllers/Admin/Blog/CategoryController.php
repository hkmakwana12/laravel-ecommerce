<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\Category\StoreRequest as BlogCategoryStoreRequest;
use App\Http\Requests\Admin\Blog\Category\UpdateRequest as BlogCategoryUpdateRequest;
use App\Models\Blog\Category as BlogCategory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog_categories = QueryBuilder::for(BlogCategory::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->withCount('posts')
            ->allowedSorts(['title', 'slug', 'blog_category_id'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.blogs.categories.index', compact('blog_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blog_category = new BlogCategory();

        return view('admin.blogs.categories.form', compact('blog_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryStoreRequest $request)
    {

        $blog_category = BlogCategory::create($request->validated());

        return redirect()
            ->route('admin.blogs.categories.index')
            ->with('success', 'Blog Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blog_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blog_category)
    {

        return view('admin.blogs.categories.form', compact('blog_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryUpdateRequest $request, BlogCategory $blog_category)
    {

        $blog_category->fill($request->validated());
        $blog_category->save();

        return redirect()
            ->route('admin.blogs.categories.index')
            ->with('success', 'Blog Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blog_category)
    {
        $blog_category->delete();

        return redirect()
            ->route('admin.blogs.categories.index')
            ->with('success', 'Blog Category deleted successfully.');
    }

    /**
     * Search Blog Category by name
     */
    public function search(Request $request)
    {
        $blog_categories = BlogCategory::where('name', 'like', '%' . $request->q . '%')
            ->select(['id', 'name'])
            ->latest()
            ->take(10)
            ->get();

        return response()->json($blog_categories);
    }
}
