<x-layouts.admin>
    <div class="mx-auto space-y-6">

        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.blogs.posts.index'),
                    'text' => 'Blog Posts',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Blog Posts" :addNewAction="route('admin.blogs.posts.create')" />

        {{-- Blog Posts Table --}}
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
                            <a href="{{ route('admin.blogs.posts.index') }}" class="btn btn-soft">
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
                                <x-admin.table.sortable-header field="title" :current-sort="request('sort')">
                                    Title
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="slug" :current-sort="request('sort')">
                                    Slug
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">
                                <x-admin.table.sortable-header field="blog_category_id" :current-sort="request('sort')">
                                    Category
                                </x-admin.table.sortable-header>
                            </th>
                            <th scope="col">Status</th>

                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blog_posts as $blog_post)
                            <tr>
                                <td class="font-semibold">{{ $blog_post->title }}</td>
                                <td>{{ $blog_post->slug }}</td>
                                <td>{{ $blog_post->blogCategory?->name }}</td>
                                <td>{{ $blog_post->status }}</td>

                                {{-- Actions --}}

                                <td class="space-x-1 text-right">
                                    <x-admin.links.edit :href="route('admin.blogs.posts.edit', $blog_post)" />

                                    <x-admin.links.delete :action="route('admin.blogs.posts.destroy', $blog_post)" />
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
            @if ($blog_posts->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {!! $blog_posts->links() !!}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
