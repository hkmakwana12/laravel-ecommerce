<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\StoreRequest as BannerStoreRequest;
use App\Http\Requests\Admin\Banner\UpdateRequest as BannerUpdateRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = QueryBuilder::for(Banner::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->allowedSorts([])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banner = new Banner();

        return view('admin.banners.form', compact('banner'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerStoreRequest $request)
    {

        $banner = Banner::create($request->validated());

        if ($request->hasFile('image')) {
            $banner->addMediaFromRequest('image')
                ->preservingOriginal()
                ->toMediaCollection($banner->location);
        }

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banners created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.form', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerUpdateRequest $request, Banner $banner)
    {

        $banner->fill($request->validated());
        $banner->save();

        if ($request->hasFile('image')) {

            $banner->clearMediaCollection($banner->location);

            $banner->addMediaFromRequest('image')
                ->preservingOriginal()
                ->toMediaCollection($banner->location);
        }

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->clearMediaCollection($banner->location);

        $banner->delete();

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }
}
