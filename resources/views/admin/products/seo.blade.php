<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
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
                    'text' => 'SEO',
                ],
            ];
            $title = 'Edit ' . $product->name;
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.products.index')" />

        @include('admin.products._stepper')

        <form method="post" action="{{ route('admin.products.storeSeo', $product) }}" class="space-y-6">
            @csrf

            @method('put')

            <div class="card">
                <div class="card-body space-y-4">
                    <x-form.input label="SEO Title" name="seo_title" :value="$product->seo_title" />


                    <x-form.textarea label="SEO Description" name="seo_description" :value="$product->seo_description" rows="3" />
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
