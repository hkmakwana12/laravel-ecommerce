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
                    'text' => 'Variants',
                ],
            ];
            $title = 'Edit ' . $product->name;
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.products.index')" />

        @include('admin.products._stepper')

        <form method="post" action="{{ route('admin.products.storeVariant', $product) }}" class="space-y-6">
            @csrf

            @method('put')

            <div class="card">
                <div class="card-body grid md:grid-cols-2 gap-4">
                    <x-form.input label="SKU (Stock Keeping Unit)" name="sku" :value="$product->defaultVariant->sku" />
                    <x-form.input label="Barcode (ISBN, UPC, GTIN, etc.)" name="barcode" :value="$product->defaultVariant->barcode" />

                    <x-form.input label="Regular Price" name="regular_price" :value="$product->defaultVariant->regular_price" required />
                    <x-form.input label="Selling Price" name="selling_price" :value="$product->defaultVariant->selling_price" required />
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
