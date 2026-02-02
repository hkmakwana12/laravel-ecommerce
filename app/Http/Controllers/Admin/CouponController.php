<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\StoreRequest as CouponStoreRequest;
use App\Http\Requests\Admin\Coupon\UpdateRequest as CouponUpdateRequest;
use App\Models\Coupon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = QueryBuilder::for(Coupon::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->allowedSorts(['code', 'value', 'start_date', 'end_date'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coupon = new Coupon();

        return view('admin.coupons.form', compact('coupon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponStoreRequest $request)
    {

        $coupon = Coupon::create($request->validated());

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.form', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {

        $coupon->fill($request->validated());
        $coupon->save();

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', __('Coupon deleted successfully.'));
    }
}
