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
                    'text' => $brand->id ? 'Edit' : 'Create',
                ],
            ];
            $title = $brand->id ? 'Edit ' . $brand->name : 'Create Brand';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.brands.index')" />


        <form method="post"
            action="{{ $brand->id ? route('admin.brands.update', $brand) : route('admin.brands.store') }}"
            enctype="multipart/form-data">
            @csrf

            @isset($brand->id)
                @method('put')
            @endisset
            <div class="card">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-4" x-data="{
                        title: '{{ addslashes(old('name', $brand->name)) }}',
                        slug: '{{ old('slug', $brand->slug) }}'
                    }">
                        <x-form.input label="Name" name="name" :value="$brand->name" x-model="title"
                            @input="slug = slugify(title)" autofocus required />

                        <x-form.input label="Slug" name="slug" :value="$brand->slug" x-model="slug" required
                            readonly />

                        <x-form.textarea label="Description" name="description" :value="$brand->description" rows="3"
                            wrapperClass="col-span-2" />

                        <x-form.input type="file" label="Featured Image" name="featured_image" :value="$brand->featured_image" />
                    </div>
                </div>
            </div>
            <div class="card mt-6">
                <div class="card-body">
                    <h3 class="text-base-content text-lg font-medium">SEO</h3>
                    <div class="grid gap-4">
                        <x-form.input label="SEO Title" name="seo_title" :value="$brand->seo_title" />
                        <x-form.textarea label="SEO Description" name="seo_description" :value="$brand->seo_description"
                            rows="3" />
                    </div>
                </div>
            </div>
            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function slugify(str) {
            return str
                .trim()
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    </script>
</x-layouts.admin>
