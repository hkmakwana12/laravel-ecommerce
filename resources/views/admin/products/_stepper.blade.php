<nav class="tabs overflow-x-auto space-x-1 p-1" aria-label="Tabs">

    <a href="{{ $product->id ? route('admin.products.edit', $product) : route('admin.products.create') }}"
        @class([
            'btn btn-text gap-2',
            'bg-primary text-white active' =>
                request()->routeIs('admin.products.create') ||
                request()->routeIs('admin.products.edit'),
            'hover:text-primary hover:bg-primary/20' =>
                !request()->routeIs('admin.products.create') &&
                !request()->routeIs('admin.products.edit'),
        ])>
        <span class="icon-[tabler--server] size-5 shrink-0"></span>
        <span class="hidden sm:inline">Basic Information</span>
    </a>

    <a href="{{ route('admin.products.variant', $product) }}" @disabled(!$product->id) @class([
        'btn btn-text gap-2',
        'bg-primary text-white active' => request()->routeIs(
            'admin.products.variant'),
        'hover:text-primary hover:bg-primary/20' => !request()->routeIs(
            'admin.products.variant'),
    ])>
        <span class="icon-[tabler--versions] size-5 shrink-0"></span>
        <span class="hidden sm:inline">Product Variants</span>
    </a>

    <a href="{{ route('admin.products.image', $product) }}" @disabled(!$product->id) @class([
        'btn btn-text gap-2',
        'bg-primary text-white active' => request()->routeIs(
            'admin.products.image'),
        'hover:text-primary hover:bg-primary/20' => !request()->routeIs(
            'admin.products.image'),
    ])>
        <span class="icon-[tabler--file-upload] size-5 shrink-0"></span>
        <span class="hidden sm:inline">Product Image</span>
    </a>

    <a href="{{ route('admin.products.seo', $product) }}" @disabled(!$product->id) @class([
        'btn btn-text gap-2',
        'bg-primary text-white active' => request()->routeIs('admin.products.seo'),
        'hover:text-primary hover:bg-primary/20' => !request()->routeIs(
            'admin.products.seo'),
    ])>
        <span class="icon-[tabler--seo] size-5 shrink-0"></span>
        <span class="hidden sm:inline">SEO Information</span>
    </a>
</nav>
