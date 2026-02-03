<x-layouts.admin>

    <div class="max-w-7xl mx-auto space-y-6">
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
                    'text' => $order->id ? 'Show' : '',
                ],
            ];

            $title = 'Order # : ' . $order->order_number;

        @endphp

        <x-admin.breadcrumb :links=$breadcrumbLinks :title=$title :goBackAction="route('admin.orders.index')" />

        <div class="lg:grid lg:grid-cols-3 content-center gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="card-header flex justify-between items-center">
                        <h3 class="card-title text-base-content text-lg font-medium">Order Detail</h3>
                        <a target="_blank" href="{{ route('admin.orders.pdf', $order) }}"
                            class="btn btn-sm btn-soft btn-primary">
                            <span class="icon-[tabler--file-dollar] size-4"></span>
                            PDF
                        </a>
                    </div>
                    <div class="overflow-x-auto border-t border-base-content/20">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Products</th>
                                    <th scope="col" class="text-right">Price</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="font-semibold">{{ $item->product->name }}</td>
                                        <td class="text-right">@money($item->price)</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">@money($item->total)</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row" colspan="3" class="text-right font-semibold">
                                        Subtotal</th>
                                    <td class="text-right">@money($order->sub_total)</td>
                                </tr>
                                @foreach ($order->tax_breakdown as $tax)
                                    <tr>
                                        <th scope="row" colspan="3" class="text-right font-semibold">
                                            {{ $tax['name'] }}</th>
                                        <td class="text-right">@money($tax['total_amount'])</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th scope="row" colspan="3" class="text-right font-semibold">
                                        Delivery Charge</th>
                                    <td class="text-right">@money($order->delivery_charge)</td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" class="text-right font-semibold">
                                        Grandtotal</th>
                                    <td class="text-right">@money($order->grand_total)</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-------- payment table ----------->

                @if ($order->payments->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-base-content text-lg font-medium">Order Detail</h3>
                        </div>
                        <div class="overflow-x-auto border-t border-base-content/20">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Payment #</th>
                                        <th scope="col">Reference</th>
                                        <th scope="col">Method</th>
                                        <th scope="col" class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="font-semibold">{{ $paymentObj->payment_number }}</td>
                                            <td>{{ $paymentObj->reference }}</td>
                                            <td>{{ $paymentObj->method }}</td>
                                            <td class="text-right">@money($paymentObj->amount)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <!-------- payment form ----------->

                @includeUnless(
                    $order->payment_status === \App\Enums\PaymentStatus::PAID,
                    'admin.orders.payment_form')

            </div>

            <div class="space-y-6">
                <!-- Customer Detail Card -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-base-content text-lg font-medium">Customer Detail</h3>
                        <dl class="space-y-4">
                            <div class="flex items-center gap-4">
                                <dt class="flex-none">
                                    <span class="sr-only">Client</span>
                                    <span class="icon-[tabler--user-circle] size-6 text-base-content/40"></span>
                                </dt>
                                <dd class="font-medium text-base-content">{{ $order->user->name }}</dd>
                            </div>

                            <div class="flex items-center gap-4">
                                <dt class="flex-none">
                                    <span class="sr-only">Total Orders</span>
                                    <span class="icon-[tabler--shopping-cart] size-6 text-base-content/40"></span>
                                </dt>
                                <dd class="font-medium text-base-content">
                                    {{ $order->user->orders->count() }} Orders
                                </dd>
                            </div>

                            <div class="flex items-center gap-4">
                                <dt class="flex-none">
                                    <span class="sr-only">Order date</span>
                                    <span class="icon-[tabler--calendar] size-6 text-base-content/40"></span>
                                </dt>
                                <dd class="text-sm text-base-content">
                                    <time
                                        datetime="2023-01-31">{{ $order->order_date->format(setting('general.date_format')) }}</time>
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-4 pt-4 border-t border-base-content/10">
                            <h3 class="card-title text-base-content text-lg font-medium">Contact Info</h3>
                            <p class="text-base-content/70">
                                <span class="font-semibold">Email:</span>
                                {{ $order->user->email }}
                            </p>
                            <p class="text-base-content/70 mt-1">
                                <span class="font-semibold">Mobile:</span> {{ $order->user->phone }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address Card -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-base-content text-lg font-medium">Shipping address</h3>
                        <p class="text-base-content/70">
                            <span class="font-semibold">{{ $order->address?->contact_name }}</span>
                            <br>
                            {{ $order->address?->address_line_1 }}, {{ $order->address?->address_line_2 }}
                            {{ $order->address?->city }}<br>
                            {{ $order->address?->state?->name }}, {{ $order->address?->country?->iso2 }} -
                            {{ $order->address?->zip_code }}<br>
                            Phone Number: {{ $order->address?->phone }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
