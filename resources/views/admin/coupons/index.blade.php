<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.coupons.index'),
                    'text' => 'Coupons',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Coupons" :addNewAction="route('admin.coupons.create')" />

        {{-- Coupons Table --}}
        <div class="card">
            <div class="card-header">
                <form method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                        <div class="space-y-1">
                            <label class="label-text sr-only" for="search-filter">Search</label>
                            <div class="input">
                                <span
                                    class="icon-[tabler--search] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                                <input type="search" id="search-filter" name="filter[search]"
                                    value="{{ request('filter.search') }}" placeholder="Search here..."
                                    class="grow" />
                            </div>
                        </div>

                        <div class="flex items-end gap-2">
                            <button class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-soft">
                                Clear
                            </a>
                        </div>

                    </div>
                </form>
            </div>
            <div class="overflow-x-auto border-t border-base-content/20">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">
                                <x-admin.table.sortable-header field="code" :current-sort="request('sort')">
                                    Coupon Code
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">Type</th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="value" :current-sort="request('sort')">
                                    Value
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="start_date" :current-sort="request('sort')">
                                    Start Date
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="end_date" :current-sort="request('sort')">
                                    End Date
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons as $coupon)
                            <tr>
                                <td class="font-semibold">{{ $coupon->code }}</td>
                                <td>{{ $coupon->type }}</td>
                                <td>{{ $coupon->value }}</td>
                                <td>{{ $coupon->start_date->format(setting('general.date_format')) }}</td>
                                <td>{{ $coupon->end_date->format(setting('general.date_format')) }}</td>

                                {{-- Actions --}}
                                <td class="space-x-1 text-right">
                                    <x-admin.links.edit :href="route('admin.coupons.edit', $coupon)" />
                                    <x-admin.links.delete :action="route('admin.coupons.destroy', $coupon)" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($coupons->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {!! $coupons->links() !!}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
