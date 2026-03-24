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
                    'text' => 'Image',
                ],
            ];
            $title = 'Edit ' . $product->name;
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.products.index')" />

        @include('admin.products._stepper')



        @if ($product?->getMedia('product-images')->count() > 0)
            <h3 class="text-base font-semibold text-base-content">Product Gallery Images</h3>
            <div role="list" class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($product?->getMedia('product-images') as $attachment)
                    <div class="rounded-box bg-base-100 shadow-base-300/20 relative mt-2 p-2 shadow flex items-center">
                        <img class="mb-2 w-full rounded-lg object-cover" src="{{ $attachment->getUrl() }}" />
                        <div class="flex items-center gap-x-2 absolute top-0 right-0">
                            <form method="POST" action="{{ route('admin.products.deleteImage', $product) }}"
                                onsubmit="return confirm('Are you sure want to delete?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-circle btn-text btn-error">
                                    <input type="hidden" name="media_id" value="{{ $attachment->id }}" />
                                    <span class="icon-[tabler--trash] size-4 shrink-0"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <form method="post" action="{{ route('admin.products.storeImage', $product) }}" class="space-y-6"
            enctype="multipart/form-data">
            @csrf

            @method('put')
            <div class="card">
                <div class="card-body grid md:grid-cols-2 gap-4">
                    <x-form.input type="file" label="Featured Image" name="featured-image" />
                    <x-form.input type="file" label="Product Gallery Images" name="product-images[]" multiple />
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-soft">Cancel</a>
            </div>
        </form>
    </div>

</x-layouts.admin>
