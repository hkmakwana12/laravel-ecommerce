<form method="post" action="{{ route('admin.payments.store', $order) }}">
    @csrf

    <div class="mt-6 overflow-hidden rounded-xl bg-white shadow-sm">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-base-content text-lg font-medium">Record Payment</h3>
                <div class="grid md:grid-cols-2 gap-4">

                    <x-form.input label="Payment Number" name="payment_number" :value="$payment->payment_number ?? $payment->generatePaymentNumber()" required readonly />
                    <x-form.input label="Reference" name="reference" required />
                    <x-form.input label="Amount" name="amount" :value="$order->grand_total - $order->paid_amount" required />

                    <div class="space-y-1">
                        <label for="method" class="label-text">Method</label>
                        <select name="method" id="method" class="select @error('method') is-invalid @enderror">
                            <option value="">Select method</option>
                            @foreach (\App\Enums\PaymentType::cases() as $method)
                                <option value="{{ $method->value }}" @selected(old('method', $order->method->value ?? 'cash') == $method->value)>
                                    {{ $method->label() }}
                                </option>
                            @endforeach
                        </select>

                        @error('method')
                            <span class="helper-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-form.textarea label="Note" name="notes" rows="3" wrapperClass="col-span-2" />

                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
