<x-layouts.admin>
    <div class="mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.orders.index'),
                    'text' => 'Orders',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Orders" />

        {{-- Orders Table --}}
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
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-soft">
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
                                <x-admin.table.sortable-header field="order_number" :current-sort="request('sort')">
                                    Order #
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="user_id" :current-sort="request('sort')">
                                    Customer
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="order_date" :current-sort="request('sort')">
                                    Order Date
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Payment Status</th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="grand_total" :current-sort="request('sort')">
                                    Grand Total
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="font-semibold">
                                    <a class="link link-primary font-semibold"
                                        href="{{ route('admin.orders.show', $order) }}">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->order_date->format(setting('general.date_format')) }}</td>
                                <td>
                                    <span class="badge badge-soft badge-{{ $order->status->color() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-soft badge-{{ $order->payment_status->color() }}">
                                        {{ $order->payment_status->label() }}
                                    </span>
                                </td>
                                <td>@money($order->grand_total)</td>

                                {{-- Actions --}}
                                <td class="space-x-1 text-right">
                                    <a target="_blank" href="{{ route('admin.orders.pdf', $order) }}"
                                        class="link-primary relative inline-flex">
                                        <i data-lucide="file-text" class="size-5"></i>
                                    </a>
                                    <x-admin.links.delete :action="route('admin.orders.destroy', $order)" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No Records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($orders->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {!! $orders->links() !!}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
