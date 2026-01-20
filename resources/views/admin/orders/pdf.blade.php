<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $order->order_number }}</title>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ public_path('css/print.css') }}">


</head>

<body>
    <h1 class="text-center">INVOICE</h1>
    <table width="100%" class="table-bordered">
        <tr>
            <td width="50%">
                <img src="{{ setting('general.logo') ? public_path('storage/' . setting('general.logo')) : public_path('assets/logo.png') }}"
                    alt="{{ setting('general.app_name') }}" height="50px;" />
            </td>
            <td width="50%">
                <b>Order # :</b> {{ $order->order_number }} <br>
                <b>Order Date :</b>
                {{ $order->order_date->format(setting('general.date_format')) }}
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <b>{{ setting('company.name') }}</b> <br>
                    {{ setting('company.address') }} , <br>
                    {{ $state }},{{ $country }} - {{ setting('company.zipcode') }}, <br>
                    Phone #: {{ setting('company.phone') }}
                </p>
            </td>
            <td>
                <p>
                    <b>{{ $order->address?->contact_name }}</b> <br>
                    {{ $order->address?->address_line_1 }} , {{ $order->address?->address_line_2 }}
                    {{ $order->address?->city }}
                    <br>{{ $order->address?->state?->name }},
                    {{ $order->address?->country?->iso2 }} -
                    {{ $order->address?->zip_code }}<br>
                    Phone #: {{ $order->address?->phone }}
                </p>
            </td>
        </tr>
    </table>

    <table class="table-bordered">
        <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="60%" class="text-center">Product</th>
                <th class="text-right">Rate</th>
                <th class="text-center">QTY</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-right">@money($item->price)</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">@money($item->total)</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2" rowspan="5" class="text-left" style="vertical-align: top">
                    {{ $order->notes }}
                </td>
                <th colspan="2" class="text-right">Sub Total</th>
                <td class="text-right">@money($order->sub_total)</td>
            </tr>
            <tr>
                <th colspan="2" class="text-right">Total Tax</th>
                <td class="text-right">@money($order->total_tax_amount)</td>
            </tr>
            <tr>
                <th colspan="2" class="text-right">Delivery Charge</th>
                <td class="text-right"><b>@money($order->delivery_charge)</b></td>
            </tr>

            <tr>
                <th colspan="2" class="text-right">Discount</th>
                <td class="text-right">@money($order->coupon_discount)</td>
            </tr>

            <tr>
                <th colspan="2" class="text-right">Grand Total</th>
                <td class="text-right"><b>@money($order->grand_total)</b></td>
            </tr>
        </tfoot>
    </table>
    @if ($order->taxes()->exists())
        <table class="table-bordered" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Tax Type</th>
                    <th class="text-right">Tax Rate</th>
                    <th class="text-right">Taxable Amount</th>
                    <th class="text-right">Tax Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->getTaxBreakdown() as $tax)
                    <tr>
                        <td>{{ $tax['type'] }}</td>
                        <td class="text-right">{{ $tax['rate'] }} %</td>
                        <td class="text-right">@money($tax['total_taxable_amount'])</td>
                        <td class="text-right">@money($tax['total_amount'])</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</body>

</html>
