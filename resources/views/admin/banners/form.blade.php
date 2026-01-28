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
                    'text' => $banner->id ? 'Edit' : 'Create',
                ],
            ];
            $title = $banner->id ? 'Edit ' . $banner->name : 'Create Banner';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.banners.index')" />


        <form method="post"
            action="{{ $banner->id ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
            enctype="multipart/form-data">
            @csrf

            @isset($banner->id)
                @method('put')
            @endisset

            <div class="card">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-4">
                        <x-form.input label="Name" name="name" :value="$banner->name" required autofocus />
                        <x-form.input type="file" label="Image" name="image" required />

                        <x-form.input label="Destination Link" name="link" :value="$banner->link" />
                        <x-form.input label="Location" name="location" :value="$banner->location" list="locationOption" />
                        <datalist id="locationOption">
                            <option value="slider">
                        </datalist>

                        <input type="hidden" name="is_new_tab" value="0" />
                        <x-form.checkbox label="Open in New Tab" name="is_new_tab" :checked="$banner->is_new_tab" />

                        <input type="hidden" name="is_active" value="0" />
                        <x-form.checkbox label="Active" name="is_active" :checked="$banner->is_active" />
                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
