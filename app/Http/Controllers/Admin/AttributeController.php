<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attribute\StoreRequest;
use App\Http\Requests\Admin\Attribute\UpdateRequest;
use App\Models\Attribute;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = QueryBuilder::for(Attribute::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->allowedSorts(['name'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.attributes.index', compact('attributes'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attribute = new Attribute();

        return view('admin.attributes.form', compact('attribute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $attribute = Attribute::updateOrCreate($request->validated());

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.form', compact('attribute'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Attribute $attribute)
    {
        $attribute->fill($request->validated());
        $attribute->save();

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', __('Attribute deleted successfully.'));
    }
}
