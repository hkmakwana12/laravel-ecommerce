<form action="{{ route('account.updateCart') }}" method="POST">
    @csrf
    <!-- Activity Drawer Content  -->
    <div id="cart-drawer" class="overlay overlay-open:translate-x-0 drawer drawer-end hidden sm:max-w-104" role="dialog"
        tabindex="-1" x-data>
        <div class="drawer-header border-base-content/20 border-b p-4">
            <h3 class="drawer-title text-xl font-semibold">Cart</h3>
            <button type="button" class="btn btn-text btn-square btn-sm" aria-label="Close" data-overlay="#cart-drawer">
                <span class="icon-[tabler--x] size-5"></span>
            </button>
        </div>
        <div class="drawer-body">
            <ul class="space-y-0 mb-12">
                <template x-for="item in $store.cart.items" :key="item.variant_id">
                    <li class="flex items-center justify-between py-4 gap-4">
                        <div class="flex items-center gap-4">
                            <div class="size-18 shrink-0">
                                <a :href="item.item_url">
                                    <img :src="item.image" class="rounded-box bg-contain w-full shrink-0 h-full"
                                        :alt="item.name" />
                                </a>
                            </div>
                            <div class="flex flex-col justify-between gap-2">
                                <div class="space-y-3">
                                    <div class="text-base-content font-medium line-clamp-1">
                                        <a :href="item.item_url">
                                            <span x-text="item.name"></span>
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <div class="max-w-24">
                                            <div class="input input-sm items-center">

                                                <!-- Decrement / Remove -->
                                                <button type="button"
                                                    @click="
                                                        item.quantity === 1 
                                                            ? $store.cart.remove(item.variant_id)
                                                            : $store.cart.decrement(item.product_id, item.variant_id)
                                                    "
                                                    :disabled="$store.cart.loading"
                                                    class="btn btn-soft size-5.5 min-h-0 rounded-sm p-0"
                                                    :class="item.quantity === 1 ? 'btn-error' : 'btn-primary'">
                                                    <span class="size-3.5 shrink-0"
                                                        :class="item.quantity === 1 ?
                                                            'icon-[tabler--trash]' :
                                                            'icon-[tabler--minus]'"></span>
                                                </button>

                                                <!-- Quantity -->
                                                <input class="text-center" type="text" :value="item.quantity"
                                                    readonly />

                                                <!-- Increment -->
                                                <button type="button"
                                                    @click="$store.cart.increment(item.product_id, item.variant_id)"
                                                    :disabled="$store.cart.loading"
                                                    class="btn btn-primary btn-soft size-5.5 min-h-0 rounded-sm p-0">
                                                    <span class="icon-[tabler--plus] size-3.5 shrink-0"></span>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <div class="text-base-content text-lg font-medium whitespace-nowrap">
                                <span x-text="formatCurrency(item.total)"></span>
                            </div>
                            <button type="button" @click="$store.cart.remove(item.variant_id)"
                                class="btn btn-square btn-text btn-sm" aria-label="Delete Item">
                                <span class="icon-[tabler--trash] size-6 shrink-0"></span>
                            </button>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
        <div class="drawer-footer flex-col">

            <template x-if="$store.cart.count !== 0">
                <div class="mb-6 w-full">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-base-content/80">Sub Total</span>
                            <span class="text-base-content font-medium whitespace-nowrap"
                                x-text="formatCurrency($store.cart.sub_total)"></span>
                        </div>

                        <template x-for="(tax, index) in $store.cart.taxes" :key="index">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-base-content/80" x-text="tax.name"></span>
                                <span class="text-base-content font-medium whitespace-nowrap"
                                    x-text="formatCurrency(tax.total_amount)"></span>
                            </div>
                        </template>
                        <div class="divider mb-3"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-base-content text-lg font-semibold">Grand Total</span>
                            <span class="text-base-content text-lg font-semibold whitespace-nowrap"
                                x-text="formatCurrency($store.cart.grand_total)"></span>
                        </div>
                    </div>
                    <button class="btn btn-primary mb-2 w-full">Checkout</button>
                </div>
            </template>
        </div>
    </div>
</form>
