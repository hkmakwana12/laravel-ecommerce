<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.brands.index'),
                    'text' => 'Brands',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Brands" :addNewAction="route('admin.brands.create')" />

        {{-- Brands Table --}}
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
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-soft">
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
                                <x-admin.table.sortable-header field="name" :current-sort="request('sort')">
                                    Brand Name
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="slug" :current-sort="request('sort')">
                                    Slug
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col" class="text-center">Products</th>
                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                            <tr>
                                <td class="font-semibold">{{ $brand->name }}</td>
                                <td>{{ $brand->slug }}</td>
                                <td class="text-center">{{ $brand->products_count }}</td>

                                {{-- Actions --}}
                                <td class="space-x-1 text-right">
                                    <x-admin.links.edit :href="route('admin.brands.edit', $brand)" />
                                    <x-admin.links.delete :action="route('admin.brands.destroy', $brand)" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($brands->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {!! $brands->links() !!}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
