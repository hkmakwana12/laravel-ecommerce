<div class="space-y-6">
    @foreach (auth()->user()->wishlists as $product)
        <div class="card card-border shadow-none sm:card-side max-w-sm sm:max-w-full">
            <figure class="max-w-48">
                <a href="{{ route('products.show', $product) }}">
                    <img src="{{ $product?->thumbnailURL('thumb') }}" alt="{{ $product->name }}" />
                </a>
            </figure>
            <div class="card-body">
                <a href="{{ route('products.show', $product) }}">
                    <h5 class="card-title mb-0.5 line-clamp-2">{{ $product->name }}</h5>
                </a>
                <p class="mb-2">@money($product->selling_price)
                    @if ($product->regular_price > $product->selling_price)
                        <span class="line-through">@money($product->regular_price)</span>
                        <span class="badge badge-soft badge-success">
                            {{ round((($product->regular_price - $product->selling_price) / $product->regular_price) * 100) }}%
                            OFF
                        </span>
                    @endif
                </p>
                <div class="card-actions">
                    <form action="{{ route('products.addToCart') }}" method="POST" class="flex justify-end">
                        @csrf
                        <input type="hidden" name="quantity" value="1" />
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        <input type="hidden" name="variant_id" value="{{ $product->defaultVariant?->id }}" />

                        <button class="btn btn-primary">
                            <span class="icon-[tabler--shopping-bag] size-5"></span>
                            Add to cart
                        </button>
                    </form>

                    <a href="{{ route('account.removeFromWishlist', $product->id) }}" class="btn btn-outline btn-error">
                        <span class="icon-[tabler--trash] size-5"></span>
                        Remove from Wishlist
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
