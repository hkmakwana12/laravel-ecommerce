<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscriber\StoreRequest as SubscriberStoreRequest;
use App\Http\Requests\Admin\Subscriber\UpdateRequest as SubscriberUpdateRequest;
use App\Models\Subscriber;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = QueryBuilder::for(Subscriber::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->allowedSorts(['name', 'email'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.subscribers.index', compact('subscribers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subscriber = new Subscriber();

        return view('admin.subscribers.form', compact('subscriber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriberStoreRequest $request)
    {
        $subscriber = Subscriber::updateOrCreate($request->validated());

        return redirect()
            ->route('admin.subscribers.index')
            ->with('success', 'Subscriber created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscriber $subscriber)
    {
        return view('admin.subscribers.form', compact('subscriber'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriberUpdateRequest $request, Subscriber $subscriber)
    {
        $subscriber->fill($request->validated());
        $subscriber->save();

        return redirect()
            ->route('admin.subscribers.index')
            ->with('success', 'Subscriber updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()
            ->route('admin.subscribers.index')
            ->with('success', __('Subscriber deleted successfully.'));
    }
}
