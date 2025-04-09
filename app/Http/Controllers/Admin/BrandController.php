<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()
            ->simplePaginate()
            ->withQueryString();

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['required', 'string', 'max:255'],
            'is_active'         => ['boolean', 'default(true)'],
            'seo_title'         => ['string', 'max:255'],
            'seo_description'   => ['string', 'max:255'],
        ]);

        $brand = Brand::create($validated);
        $brand->save();

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
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['required', 'string', 'max:255'],
            'is_active'         => ['boolean', 'default(true)'],
            'seo_title'         => ['string', 'max:255'],
            'seo_description'   => ['string', 'max:255'],
        ]);

        $brand->fill($validated);
        $brand->save();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
