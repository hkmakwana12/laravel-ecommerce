<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Brand\StoreRequest as BrandStoreRequest;
use App\Http\Requests\Admin\Brand\UpdateRequest as BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = QueryBuilder::for(Brand::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->withCount("products")
            ->allowedSorts(['name', 'slug'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand = new Brand();

        return view('admin.brands.form', compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request)
    {

        $brand = Brand::create($request->validated());

        if ($request->hasFile('featured-image')) {
            $brand->addMediaFromRequest('featured-image')
                ->preservingOriginal()
                ->toMediaCollection();
        }

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.form', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandUpdateRequest $request, Brand $brand)
    {

        $brand->fill($request->validated());
        $brand->save();

        if ($request->hasFile('featured-image')) {
            $brand->clearMediaCollection();

            $brand->addMediaFromRequest('featured-image')
                ->preservingOriginal()
                ->toMediaCollection();
        }

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->clearMediaCollection();

        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }

    /**
     * Search Brand by name
     */
    public function search(Request $request)
    {
        $brands = Brand::where('name', 'like', '%' . $request->q . '%')
            ->select(['id', 'name'])
            ->latest()
            ->take(10)
            ->get();

        return response()->json($brands);
    }
}
