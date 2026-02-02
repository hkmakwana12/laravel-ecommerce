<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\Post\StoreRequest as BlogPostStoreRequest;
use App\Http\Requests\Admin\Blog\Post\UpdateRequest as BlogPostUpdateRequest;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Blog\Post as BlogPost;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog_posts = QueryBuilder::for(BlogPost::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->with('blogCategory')
            ->allowedSorts(['title', 'slug', 'blog_category_id'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.blogs.posts.index', compact('blog_posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blog_post = new BlogPost();

        $blog_categories = BlogCategory::all()->pluck('name', 'id');

        return view('admin.blogs.posts.form', compact('blog_post', 'blog_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostStoreRequest $request)
    {

        $blog_post = BlogPost::create($request->validated());

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');

            $blog_post->addMedia(storage_path("app/public/$path"))
                ->preservingOriginal()
                ->toMediaCollection('featured-image');
        }

        return redirect()
            ->route('admin.blogs.posts.index')
            ->with('success', 'Blog Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blog_post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blog_post)
    {

        $blog_categories = BlogCategory::all()->pluck('name', 'id');

        return view('admin.blogs.posts.form', compact('blog_post', 'blog_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostUpdateRequest $request, BlogPost $blog_post)
    {

        $blog_post->fill($request->validated());
        $blog_post->save();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');

            $blog_post->clearMediaCollection('featured-image');

            $blog_post->addMedia(storage_path("app/public/$path"))
                ->preservingOriginal()
                ->toMediaCollection('featured-image');
        }

        return redirect()
            ->route('admin.blogs.posts.index')
            ->with('success', 'Blog Posts updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blog_post)
    {
        $blog_post->clearMediaCollection('featured-image');

        $blog_post->delete();

        return redirect()
            ->route('admin.blogs.posts.index')
            ->with('success', 'Blog Post deleted successfully.');
    }
}
