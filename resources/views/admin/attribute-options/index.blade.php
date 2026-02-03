<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.attribute-options.index'),
                    'text' => 'Attribute Options',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Attribute Options" :addNewAction="route('admin.attribute-options.create')" />

        {{-- Attribute Options Table --}}
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
                            <a href="{{ route('admin.attribute-options.index') }}" class="btn btn-soft">
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
                                <x-admin.table.sortable-header field="attribute_id" :current-sort="request('sort')">
                                    Attribute
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="value" :current-sort="request('sort')">
                                    Value
                                </x-admin.table.sortable-header>
                            </th>

                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attributeOptions as $attributeOption)
                            <tr>
                                <td class="font-semibold">{{ $attributeOption->attribute->name }}</td>
                                <td>{{ $attributeOption->value }}</td>

                                {{-- Actions --}}
                                <td class="space-x-1 text-right">
                                    <x-admin.links.edit :href="route('admin.attribute-options.edit', $attributeOption)" />

                                    <x-admin.links.delete :action="route('admin.attribute-options.destroy', $attributeOption)" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($attributeOptions->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {!! $attributeOptions->links() !!}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
