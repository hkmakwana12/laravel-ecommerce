<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.categories.index'),
                    'text' => 'Categories',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Categories" :addNewAction="route('admin.categories.create')" />

        {{-- Category Table --}}
        <div class="card">
            <div class="overflow-x-auto">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">
                                <x-admin.table.sortable-header field="name" :current-sort="request('sort')">
                                    Category Name
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="parent_id" :current-sort="request('sort')">
                                    Parent Category
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="slug" :current-sort="request('sort')">
                                    Slug
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col" class="text-center">
                                Products Count
                            </th>
                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="font-semibold">{{ $category->name }}</td>
                                <td>
                                    @if ($category->parent)
                                        <span class="inline-flex items-center gap-1">
                                            {{ $category->parent->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td>{{ $category->slug }}</td>
                                <td class="text-center">{{ $category->products_count }}</td>

                                {{-- Actions --}}
                                <td class="space-x-1 text-right">
                                    <x-admin.links.edit :href="route('admin.categories.edit', $category)" />
                                    <x-admin.links.delete :action="route('admin.categories.destroy', $category)" />
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
            @if ($categories->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {!! $categories->links() !!}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
