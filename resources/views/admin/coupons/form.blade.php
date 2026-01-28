<x-layouts.admin>
    <div class="max-w-7xl mx-auto space-y-6">
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
            <div class="card">
                <div class="card-body">
                    <div class="grid md:grid-cols-2 gap-4 py-2">

                        <x-form.input label="Coupon Code" name="code" :value="$coupon->code" required autofocus />

                        <x-form.textarea label="Description" name="description" :value="$coupon->description" rows="3"
                            wrapperClass="col-span-2" />
                    </div>

                    <div class="grid md:grid-cols-3 gap-4 py-2">
                        <div class="space-y-1">
                            <label for="type" class="label-text">Discount Type</label>
                            <select name="type" id="type" class="select @error('type') is-invalid @enderror">
                                <option value="flat" @selected(old('type', $coupon->type) == 'flat')>Flat</option>
                                <option value="percent" @selected(old('type', $coupon->type) == 'percent')>Percent</option>
                            </select>
                            @error('type')
                                <span class="helper-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <x-form.input label="Discount Value" type="number" name="value" :value="$coupon->value ?? 0" required />

                        <x-form.input label="Maximum Discount Amount" type="number" name="max_discount_value"
                            :value="$coupon->max_discount_value ?? 0" required />
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 py-2">
                        <x-form.input label="Start Date" type="date" name="start_date" :value="$coupon->start_date?->format('Y-m-d') ?? now()->format('Y-m-d')" required />

                        <x-form.input label="End Date" type="date" name="end_date" :value="$coupon->end_date?->format('Y-m-d') ?? now()->addDays(10)->format('Y-m-d')" required />
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 py-2">
                        <x-form.input label="Maximum usage limit" type="number" name="total_quantity" :value="$coupon->total_quantity ?? 0"
                            required />

                        <x-form.input label="Maximum usage limit per user" type="number" name="use_per_user"
                            :value="$coupon->use_per_user ?? 0" required />

                    </div>

                    <div class="grid md:grid-cols-2 gap-4 py-2 ">
                        <x-form.input label="Minimum Amount in cart required" type="number" name="min_cart_value"
                            :value="$coupon->min_cart_value ?? 0" />

                        <x-form.input label="Maximum Amount in cart required" type="number" name="max_cart_value"
                            :value="$coupon->max_cart_value ?? 0" />



                        <input type="hidden" name="is_for_new_user" value="0" />

                        <x-form.checkbox label="Is For New User Only" name="is_for_new_user" :checked="$coupon->is_for_new_user" />

                    </div>
                </div>
            </div>

            <div class="mt-6 space-x-2">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-soft">Cancel</a>
            </div>

        </form>
    </div>

</x-layouts.admin>
