<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">

        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.blogs.categories.index'),
                    'text' => 'Blog Categories',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Blog Categories" :addNewAction="route('admin.blogs.categories.create')" />

        {{-- Blog-Categories Table --}}
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
                            <a href="{{ route('admin.blogs.categories.index') }}" class="btn btn-soft">
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
                                    Category Name
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="slug" :current-sort="request('sort')">
                                    Slug
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col" class="text-center">Blogs</th>

                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blog_categories as $blog_category)
                            <tr>
                                <td class="font-semibold">{{ $blog_category->name }}</td>
                                <td>{{ $blog_category->slug }}</td>
                                <td class="text-center">{{ $blog_category->posts_count }}</td>

                                {{-- Actions --}}

                                <td class="space-x-1 text-right">
                                    <x-admin.links.edit :href="route('admin.blogs.categories.edit', $blog_category)" />

                                    <x-admin.links.delete :action="route('admin.blogs.categories.destroy', $blog_category)" />
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
            @if ($blog_categories->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {!! $blog_categories->links() !!}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
