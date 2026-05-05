<form action="{{ route('account.updateCart') }}" method="POST">
    @csrf
    <!-- Activity Drawer Content  -->
    <div id="cart-drawer" class="overlay overlay-open:translate-x-0 drawer drawer-end hidden sm:max-w-104" role="dialog"
        tabindex="-1">
        <div class="drawer-header border-base-content/20 border-b p-4">
            <h3 class="drawer-title text-xl font-semibold">Cart</h3>
            <button type="button" class="btn btn-text btn-square btn-sm" aria-label="Close" data-overlay="#cart-drawer">
                <span class="icon-[tabler--x] size-5"></span>
            </button>
        </div>
        <div class="drawer-body">
            <ul class="space-y-0 mb-12">
                @foreach (cart()->items as $product)
                    <li class="flex items-center justify-between py-4 gap-4">
                        <div class="flex items-center gap-4">
                            <div class="size-18 shrink-0">
                                <a href="{{ route('products.show', $product->product) }}">
                                    <img src="{{ $product->product?->thumbnailURL('thumb') }}"
                                        class="rounded-box bg-contain w-full shrink-0 h-full"
                                        alt="{{ $product->product->name }}" />
                                </a>
                            </div>
                            <div class="flex flex-col justify-between gap-2">
                                <div class="space-y-3">
                                    <div class="text-base-content font-medium line-clamp-1">
                                        <a
                                            href="{{ route('products.show', $product->product) }}">{{ $product->product->name }}</a>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <div class="max-w-24" data-input-number='{ "min": 1 }'>
                                            <div class="input input-sm items-center">
                                                <button type="button"
                                                    class="btn btn-primary btn-soft size-5.5 min-h-0 rounded-sm p-0"
                                                    aria-label="Decrement button" data-input-number-decrement>
                                                    <span class="icon-[tabler--minus] size-3.5 shrink-0"></span>
                                                </button>
                                                <input class="text-center" type="text"
                                                    value="{{ $product->quantity }}"
                                                    name="quantity[{{ $product->variant_id }}]"
                                                    aria-label="Mini stacked buttons" data-input-number-input
                                                    id="number-input-mini" readonly />
                                                <button type="button"
                                                    class="btn btn-primary btn-soft size-5.5 min-h-0 rounded-sm p-0"
                                                    aria-label="Increment button" data-input-number-increment>
                                                    <span class="icon-[tabler--plus] size-3.5 shrink-0"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <div class="text-base-content text-lg font-medium whitespace-nowrap">@money($product->total)
                            </div>
                            <a href="{{ route('account.removeFromCart', $product->variant_id) }}"
                                class="btn btn-square btn-text btn-sm" aria-label="Delete Item">
                                <span class="icon-[tabler--trash] size-6 shrink-0"></span>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="drawer-footer flex-col">

            @if (cart()->items->isNotEmpty())
                <div class="mb-6 w-full">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-base-content/80">Sub Total</span>
                        <span class="text-base-content font-medium whitespace-nowrap">@money(cart()->total)</span>
                    </div>
                    @foreach (cart()->tax_breakdown as $tax)
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-base-content/80">{{ $tax['name'] }}</span>
                            <span class="text-base-content font-medium whitespace-nowrap">@money($tax['total_amount'])</span>
                        </div>
                    @endforeach
                    <div class="divider mb-3"></div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-base-content text-lg font-semibold">Grand Total</span>
                        <span class="text-base-content text-lg font-semibold whitespace-nowrap">@money(cart()->total + cart()->total_tax_amount)</span>
                    </div>
                </div>
                <button class="btn btn-primary mb-2 w-full">Checkout</button>
            @endif
            <button type="button" class="btn btn-primary btn-outline w-full" data-overlay="#cart-drawer">Continue
                Shopping</button>
        </div>
    </div>
</form>
