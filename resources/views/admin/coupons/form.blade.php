<x-layouts.admin>
    <div class="max-w-7xl mx-auto">
        @php
            $breadcrumbLinks = [
                [
                    'url' => route('admin.dashboard'),
                    'text' => 'Dashboard',
                ],
                [
                    'url' => route('admin.coupons.index'),
                    'text' => 'Coupons',
                ],
                [
                    'text' => $coupon->id ? 'Edit' : 'Create',
                ],
            ];
            $title = $coupon->id ? 'Edit ' . $coupon->code : 'Create Coupon';
        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.coupons.index')" />

        <form method="post"
            action="{{ $coupon->id ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}">
            @csrf

            @isset($coupon->id)
                @method('put')
            @endisset
            <div class="mt-6 overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-4 py-2">

                        <div class="space-y-2">
                            <label for="code" class="control-label">Coupon Code</label>
                            <input type="text" name="code" id="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $coupon->code) }}" />
                            @error('code')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 col-span-2">
                            <label for="description" class="control-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description', $coupon->description) }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4 py-2">
                        <div class="space-y-2">
                            <label for="type" class="control-label">Discount Type</label>
                            <div class="sm:grid sm:grid-cols-6 sm:items-start sm:gap-4">
                                <div class="mt-2 sm:col-span-6 sm:mt-0 grid grid-cols-1">
                                    <select name="type" id="type"
                                        class="col-start-1 row-start-1 form-select @error('type') is-invalid @enderror">
                                        <option value="flat" @selected(old('type', $coupon->type) == 'flat')>Flat</option>
                                        <option value="percent" @selected(old('type', $coupon->type) == 'percent')>Percent</option>
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            @error('type')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="value" class="control-label">Discount Value</label>
                            <input type="text" name="value" id="value"
                                class="form-control @error('value') is-invalid @enderror"
                                value="{{ old('value', $coupon->value ?? 0) }}" />
                            @error('value')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="max_discount_value" class="control-label">
                                Maximum Discount Amount
                            </label>
                            <input type="text" name="max_discount_value" id="max_discount_value"
                                class="form-control @error('max_discount_value') is-invalid @enderror"
                                value="{{ old('max_discount_value', $coupon->max_discount_value ?? 0) }}" />
                            @error('max_discount_value')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 py-2">
                        <div class="space-y-2">
                            <label for="start_date" class="control-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date"
                                class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', $coupon->start_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" />
                            @error('start_date')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="end_date" class="control-label">End Date</label>
                            <input type="date" name="end_date" id="end_date"
                                class="form-control @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date', $coupon->end_date?->format('Y-m-d') ?? now()->addDays(10)->format('Y-m-d')) }}" />
                            @error('end_date')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 py-2">
                        <div class="space-y-2">
                            <label for="total_quantity" class="control-label">Maximum usage limit</label>
                            <input type="text" name="total_quantity" id="total_quantity"
                                class="form-control @error('total_quantity') is-invalid @enderror"
                                value="{{ old('total_quantity', $coupon->total_quantity ?? 0) }}" />
                            <p class="text-gray-600 text-xs">
                                Total coupon to create. Enter 0 to unlimited
                            </p>
                            @error('total_quantity')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="use_per_user" class="control-label">Maximum usage limit per user</label>
                            <input type="text" name="use_per_user" id="use_per_user"
                                class="form-control @error('use_per_user') is-invalid @enderror"
                                value="{{ old('use_per_user', $coupon->use_per_user ?? 0) }}" />
                            <p class="text-gray-600 text-xs">
                                How many times customer can use this coupon?
                            </p>
                            @error('use_per_user')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 py-2 ">
                        <div class="space-y-2">
                            <label for="min_cart_value" class="control-label">Minimum Amount in cart required</label>
                            <input type="text" name="min_cart_value" id="min_cart_value"
                                class="form-control @error('min_cart_value') is-invalid @enderror"
                                value="{{ old('min_cart_value', $coupon->min_cart_value ?? 0) }}" />
                            @error('min_cart_value')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="max_cart_value" class="control-label">Maximum Amount in cart required</label>
                            <input type="text" name="max_cart_value" id="max_cart_value"
                                class="form-control @error('max_cart_value') is-invalid @enderror"
                                value="{{ old('max_cart_value', $coupon->max_cart_value ?? 0) }}" />
                            @error('max_cart_value')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-1 gap-4 py-2 ">

                        <div class="space-y-2 mt-4">
                            <script>
                                var is_for_new_user = '{{ old('is_for_new_user', $coupon->is_for_new_user) }}';
                            </script>
                            <div class="flex items-center" x-data="{
                                isForNewUser: is_for_new_user == 1 ? true : false,
                            }">
                                <button type="button" :class="isForNewUser ? 'bg-primary-600' : 'bg-gray-200'"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 focus:outline-hidden"
                                    role="switch" :aria-checked="isForNewUser" aria-labelledby="annual-billing-label"
                                    @click="isForNewUser = !isForNewUser">
                                    <span aria-hidden="true" :class="isForNewUser ? 'translate-x-5' : 'translate-x-0'"
                                        class="pointer-events-none inline-block size-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out"></span>
                                </button>
                                <span class="ml-3 text-sm" id="annual-billing-label">
                                    <span class="font-medium text-gray-900"> Check for New User Only</span>
                                </span>
                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="is_for_new_user" :value="isForNewUser ? 1 : 0" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn-primary">Submit</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn-secondary">Cancel</a>
            </div>

        </form>
    </div>

</x-layouts.admin>
