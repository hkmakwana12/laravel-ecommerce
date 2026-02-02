<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactQuery;
use App\Notifications\ContactCreatedNotification;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContactQueryController extends Controller
{
    public function index()
    {
        $contactQueries = QueryBuilder::for(ContactQuery::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->allowedSorts(['name', 'email', 'phone'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());

        return view('admin.contactQueries.index', compact('contactQueries'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactQuery $contactQuery)
    {
        $contactQuery->delete();

        return redirect()
            ->route('admin.contactQueries.index')
            ->with('success', __('Contact Query deleted successfully.'));
    }
}
