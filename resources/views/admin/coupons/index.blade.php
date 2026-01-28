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
            <div class="overflow-x-auto">
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
