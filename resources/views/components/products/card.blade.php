<div class="card card-border hover:border-primary shadow-none">
    <figure class="bg-base-200 pt-5">
        <a href="{{ route('products.show', $product) }}">
            <img src="{{ $product->thumbnailURL('thumb') }}" alt="{{ $product?->name }}" class="h-60 w-auto" />
        </a>
    </figure>
    <div class="card-body gap-3 p-5">

        <h3 class="text-base-content text-lg font-medium line-clamp-2">
            <a href="{{ route('products.show', $product) }}">
                {{ $product?->name }}
            </a>
        </h3>
        <div class="divider"></div>
        <p class="text-base-content text-lg font-medium">@money($product->selling_price)</p>
        <div class="card-actions flex items-center gap-2">
            <form action="{{ route('products.addToCart') }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="quantity" value="1" />
                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                <button class="btn btn-primary" data-product-name="{{ $product->name }}"
                    aria-label="Add {{ $product->name }} to cart">
                    <span class="icon-[tabler--shopping-cart] size-5.5 shrink-0"></span>
                    Add to Cart
                </button>
            </form>
            <a href="{{ route('account.addToWishlist', $product) }}" class="btn btn-outline btn-square btn-primary"
                data-product-name="{{ $product->name }}" aria-label="Add {{ $product->name }} to wishlist">
                <span class="icon-[tabler--heart] size-5.5 shrink-0"></span>
            </a>
        </div>
    </div>
</div>
