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
                    'text' => $blog_category->id ? 'Edit' : 'Create',
                ],
            ];
            $title = $blog_category->id ? 'Edit ' . $blog_category->name : 'Create Blog Category';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.blogs.categories.index')" />

        <form method="post"
            action="{{ $blog_category->id ? route('admin.blogs.categories.update', $blog_category) : route('admin.blogs.categories.store') }}"
            enctype="multipart/form-data" class="space-y-6">
            @csrf

            @isset($blog_category->id)
                @method('put')
            @endisset
            <div class="card">
                <div class="card-body" x-data="{
                    title: '{{ addslashes(old('name', $blog_category->name)) }}',
                    slug: '{{ old('slug', $blog_category->slug) }}'
                }">
                    <div class="grid md:grid-cols-2 gap-4">
                        <x-form.input label="Name" name="name" :value="$blog_category->name" x-model="title"
                            @input="slug = slugify(title)" required autofocus />

                        <x-form.input label="Slug" name="slug" :value="$blog_category->slug" x-model="slug" required
                            readonly />

                        <x-form.textarea label="Description" name="description" :value="$blog_category->description" rows="3"
                            wrapperClass="col-span-2" />
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="text-base-content text-lg font-medium">SEO</h3>
                    <div class="grid gap-4">
                        <x-form.input label="SEO Title" name="seo_title" :value="$blog_category->seo_title" />

                        <x-form.textarea label="SEO Description" name="seo_description" :value="$blog_category->seo_description"
                            rows="3" />
                    </div>
                </div>
            </div>
            <div class="space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.blogs.categories.index') }}" class="btn btn-soft">Cancel</a>
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
