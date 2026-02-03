<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AttributeOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributeOptions = QueryBuilder::for(AttributeOption::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->allowedSorts(['attribute_id', 'value'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.attribute-options.index', compact('attributeOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributes = Attribute::all()->pluck("name", "id");

        $attributeOption = new AttributeOption();

        return view('admin.attribute-options.form', compact('attributeOption', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => ['required', 'exists:attributes,id'],
            'value' => ['required', 'string', 'max:255'],
        ]);

        AttributeOption::create($request->only('attribute_id', 'value'));

        return redirect()->route('admin.attribute-options.index')
            ->with('success', 'Attribute Option created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeOption $attributeOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeOption $attributeOption)
    {
        $attributes = Attribute::all()->pluck("name", "id");

        return view('admin.attribute-options.form', compact('attributeOption', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttributeOption $attributeOption)
    {
        $request->validate([
            'attribute_id' => ['required', 'exists:attributes,id'],
            'value' => ['required', 'string', 'max:255'],
        ]);

        $attributeOption->update($request->only('attribute_id', 'value'));

        return redirect()->route('admin.attribute-options.index')
            ->with('success', 'Attribute Option updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeOption $attributeOption)
    {
        $attributeOption->delete();

        return redirect()
            ->route('admin.attribute-options.index')
            ->with('success', __('Attribute deleted successfully.'));
    }
}
