<x-layouts.admin>
    <div class="max-w-7xl mx-auto">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.orders.index'),
                    'text' => 'Orders',
                ],
                [
                    'text' => $order->id ? 'Edit' : 'Create',
                ],
            ];
            $title = $order->id ? 'Edit ' . $order->order_number : 'Create Order';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.orders.index')" />

        <form method="post"
            action="{{ $order->id ? route('admin.orders.update', $order) : route('admin.orders.store') }}"
            x-data="orderItems">
            @csrf

            @isset($order->id)
                @method('put')
            @endisset

            <div class="mt-6 overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800">Order Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="space-y-2 col-span-3 md:col-span-1">
                            <label for="order_number" class="control-label sm:pt-1.5">Order #</label>
                            <input type="text" name="order_number" id="order_number"
                                class="form-control @error('order_number') is-invalid @enderror"
                                value="{{ old('order_number', $order->order_number ?? $order->generateOrderNumber()) }}"
                                readonly />
                            @error('order_number')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 col-span-3 md:col-span-1">
                            <label for="order_date" class="control-label sm:pt-1.5">Order Date</label>
                            <input type="date" name="order_date" id="order_date"
                                class="form-control @error('order_date') is-invalid @enderror"
                                value="{{ old('order_date', $order->order_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" />
                            @error('order_date')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 col-span-3 md:col-span-1">
                            <label for="user_id" class="control-label sm:pt-1.5">User</label>
                            <div class="sm:grid sm:grid-cols-6 sm:items-start sm:gap-4">
                                <div class="mt-2 sm:col-span-6 sm:mt-0 grid grid-cols-1">
                                    <select name="user_id" id="user_id"
                                        class="col-start-1 row-start-1 form-select @error('user_id') is-invalid @enderror">
                                        <option value="">Select User</option>
                                        @foreach ($users as $key => $user)
                                            <option value="{{ $key }}" @selected(old('user_id', $order->user_id) == $key)>
                                                {{ $user }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            @error('user_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2 col-span-3 md:col-span-1">
                            <label for="status" class="control-label sm:pt-1.5">Status</label>
                            <div class="sm:grid sm:grid-cols-6 sm:items-start sm:gap-4">
                                <div class="mt-2 sm:col-span-6 sm:mt-0 grid grid-cols-1">
                                    <select name="status" id="status"
                                        class="col-start-1 row-start-1 form-select @error('status') is-invalid @enderror">
                                        <option value="">Select Status</option>
                                        @foreach (\App\Enums\OrderStatus::cases() as $status)
                                            <option value="{{ $status->value }}" @selected(old('status', $order->status->value ?? 'new') == $status->value)>
                                                {{ $status->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            @error('status')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.orders.address', ['address' => $order?->address])

            <div class="mt-6 overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800">Order Items</h3>
                </div>
                <div class="p-6">
                    <div class="-mx-6 -my-6 overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <table class="record-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">
                                            <span class="sr-only">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr>
                                            <td width="50%">
                                                <div class="sm:grid sm:grid-cols-6 sm:items-start sm:gap-4">
                                                    <div class="mt-2 sm:col-span-6 sm:mt-0 grid grid-cols-1">
                                                        <select :name="'items[' + index + '][product_id]'"
                                                            x-model="item.product_id"
                                                            class="col-start-1 row-start-1 form-select"
                                                            :class="getValidationError(index, 'product_id') && 'is-invalid'">
                                                            <option value="">Select Product</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}">
                                                                    {{ $product->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                                            viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"
                                                            data-slot="icon">
                                                            <path fill-rule="evenodd"
                                                                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="text-sm text-red-600"
                                                    x-text="getValidationError(index, 'product_id')">
                                                </p>
                                            </td>
                                            <td>
                                                <input type="number" name="quantity" id="quantity"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    :name="'items[' + index + '][quantity]'" x-model="item.quantity"
                                                    @input="updateTotal(index)" />
                                            </td>
                                            <td>
                                                <input type="number" name="price" id="price"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    :name="'items[' + index + '][price]'" x-model="item.price"
                                                    @input="updateTotal(index)" step="any" />

                                            </td>
                                            <td>
                                                <input type="number" name="total" id="total"
                                                    class="form-control @error('total') is-invalid @enderror"
                                                    :name="'items[' + index + '][total]'" x-model="item.total"
                                                    readonly />
                                            </td>
                                            <td>
                                                <a href="javascript:;" class="link-danger" @click="removeItem(index)"
                                                    x-show="items.length > 1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="size-5">
                                                        <path
                                                            d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div class="border-t border-gray-200 text-center">
                            <button type="button" @click="addItem()" class="btn-secondary my-4">Add Item</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800">Order Summary</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2 col-span-2 md:col-span-1">
                            <label for="sub_total" class="control-label sm:pt-1.5">Sub Total</label>
                            <input type="text" name="sub_total" id="sub_total"
                                class="form-control @error('sub_total') is-invalid @enderror"
                                :value="grandTotal.toFixed(2)" readonly />
                            @error('sub_total')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 col-span-2 md:col-span-1">
                            <label for="grand_total" class="control-label sm:pt-1.5">Grand Total</label>
                            <input type="text" name="grand_total" id="grand_total"
                                class="form-control @error('grand_total') is-invalid @enderror"
                                :value="grandTotal.toFixed(2)" readonly />
                            @error('grand_total')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 col-span-2">
                            <label for="notes" class="control-label sm:pt-1.5">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.orders.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            window.validationErrors = @json($errors->toArray());

            function getValidationError(index, field) {
                const key = `items.${index}.${field}`;
                return window.validationErrors && window.validationErrors[key] ?
                    window.validationErrors[key][0] :
                    '';
            }

            function orderItems() {
                // Initialize items with existing order items or an empty array

                @php
                    $formItems = $order->items->map(function ($item) {
                        return $item->only(['product_id', 'quantity', 'price', 'total']);
                    });
                @endphp

                var formItems = @json(old('items', $formItems->toArray() ?? []));

                if (formItems.length == 0) {
                    formItems.push({
                        product_id: '',
                        quantity: 1,
                        price: 0,
                        total: 0,
                    })
                }

                return {
                    items: formItems, // Array to hold order items

                    // Method to add a new item
                    addItem() {
                        this.items.push({
                            product_id: '',
                            quantity: 1,
                            price: 0,
                            total: 0,
                        });
                    },

                    // Method to remove an item
                    removeItem(index) {
                        this.items.splice(index, 1);
                    },

                    updateTotal(index) {
                        const item = this.items[index];
                        item.total = parseFloat(item.quantity * item.price).toFixed(2);
                    },

                    get grandTotal() {
                        return this.items.reduce((sum, item) => sum + parseFloat(item.total), 0);
                    },
                };
            }
        </script>
    @endpush
</x-layouts.admin>
