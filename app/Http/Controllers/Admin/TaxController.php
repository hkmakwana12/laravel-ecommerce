<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tax\StoreRequest as TaxStoreRequest;
use App\Http\Requests\Admin\Tax\UpdateRequest as TaxUpdateRequest;
use App\Models\Tax;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taxes = QueryBuilder::for(Tax::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->allowedSorts(['name', 'type', 'rate'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.taxes.index', compact('taxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tax = new Tax();

        return view('admin.taxes.form', compact('tax'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxStoreRequest $request)
    {

        $tax = Tax::create($request->validated());

        return redirect()
            ->route('admin.taxes.index')
            ->with('success', 'Tax created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tax $tax)
    {
        return view('admin.taxes.form', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaxUpdateRequest $request, Tax $tax)
    {
        $tax->fill($request->validated());
        $tax->save();

        return redirect()
            ->route('admin.taxes.index')
            ->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tax $tax)
    {
        $tax->delete();

        return redirect()
            ->route('admin.taxes.index')
            ->with('success', 'Tax deleted successfully.');
    }
}
