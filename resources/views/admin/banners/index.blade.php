<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.banners.index'),
                    'text' => 'Banners',
                ],
                [
                    'text' => 'List',
                ],
            ];
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks title="Banners" :addNewAction="route('admin.banners.create')" />

        {{-- Banners Table --}}
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
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-soft">
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
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Location</th>
                            <th scope="col" class="text-center">Click Count</th>
                            <th scope="col" class="text-center">View Count</th>
                            <th scope="col" class="relative">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($banners as $banner)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="bg-base-content/10 h-10 w-10 rounded-md">
                                                <img src="{{ $banner?->getMedia($banner->location)->first()?->getUrl() }}"
                                                    alt="{{ $banner->name }}" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $banner->name }}</div>
                                            <div class="text-sm opacity-50">{{ $banner->link }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $banner->location }}</td>
                                <td class="text-center">{{ $banner->click_count }}</td>
                                <td class="text-center">{{ $banner->view_count }}</td>

                                {{-- Actions --}}
                                <td class="space-x-1 text-right">
                                    <x-admin.links.edit :href="route('admin.banners.edit', $banner)" />
                                    <x-admin.links.delete :action="route('admin.banners.destroy', $banner)" />
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
            @if ($banners->hasPages())
                <div class="card-footer border-t border-gray-200 p-4">
                    {!! $banners->links() !!}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
