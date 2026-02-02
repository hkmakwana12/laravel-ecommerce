<x-layouts.admin>
    <div class="mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.products.index'),
                    'text' => 'Products',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Products" :addNewAction="route('admin.products.create')" />

        {{-- Products Table --}}
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
                            <a href="{{ route('admin.products.index') }}" class="btn btn-soft">
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
                                    Product Name
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="category_id" :current-sort="request('sort')">
                                    Category
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="brand_id" :current-sort="request('sort')">
                                    Brand
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col" class="text-center">View Count</th>
                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="bg-base-content/10 h-10 w-10 rounded-md">
                                                <img src="{{ $product?->thumbnailURL('thumb') }}"
                                                    alt="{{ $product->name }}" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $product->name }}</div>
                                            <div class="text-sm opacity-50">{{ $product->slug }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->category?->name }}</td>
                                <td>{{ $product->brand?->name }}</td>
                                <td class="text-center">{{ $product->view_count }}</td>

                                {{-- Actions --}}
                                <td class="space-x-1 text-right">
                                    <a href="{{ route('products.show', $product->slug) }}"
                                        class="btn btn-circle btn-text btn-sm" target="_blank">
                                        <span class="icon-[tabler--eye] size-5"></span>
                                    </a>
                                    <x-admin.links.edit :href="route('admin.products.edit', $product)" />
                                    <x-admin.links.delete :action="route('admin.products.destroy', $product)" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($products->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
