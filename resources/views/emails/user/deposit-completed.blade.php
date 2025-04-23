@component('components.base')
    <style>

    </style>

    <x-banner />


    <p>Order date {{ $orderDate }}</p>
    <h1>
        Order Number #{{ $orderid }}
    </h1>
    <p class="subtitle">
        Your recent order has been completed.
    </p>

    <br>

    <table style="border-collapse: separate; border-spacing: 0 0.5rem;">
        <thead>
            <tr>
                <th align="left">Product</th>
                <th>Quantity</th>
                <th align="right">Price</th>
            </tr>
        </thead>
        @foreach ($products as $product)
            <tr>
                <td align="left">
                    <div class="gray" style="font-size: 1rem;color: #4F4F4F">
                        {{ $product->name }}
                    </div>
                </td>
                <td align="center">
                    <div class="gray" style="color: #4F4F4F">
                        {{ $product->quantity }}
                    </div>
                </td>
                <td align="right">
                    <div style="font-weight: 500;color: #4F4F4F; font-weight: 400">
                        ${{ number_format($product->price, 2) }} {{ $currency }}
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

    <br>
    <hr>
    <br>

    <table style="border-collapse: separate; border-spacing: 0 0.75rem;">
        <tr>
            <td class="important">
                Total
            </td>
            <td class="important" style="text-align: right;">
                ${{ number_format($totalprice + $fedex_price + $fee, 2) }} {{ $currency }}
            </td>
        </tr>
        <tr>
            <td>
                Shipping
            </td>
            <td style="text-align: right;">
                @if ($shipping_options == 'Delivery')
                    ${{ $fedex_price }}{{ $currency }}
                @else
                    {{ $shipping_options }}
                @endif
            </td>
        </tr>
        <tr>
            <td>
                Subtotal
            </td>
            <td style="text-align: right;">
                ${{ number_format($totalprice + $fedex_price, 2) }} {{ $currency }}
            </td>
        </tr>
        @if ($fee > 0)
            <tr>
                <td>
                    Fee
                </td>
                <td style="text-align: right;">
                    ${{ number_format($fee, 2) }} {{ $currency }}
                </td>
            </tr>
        @endif

        @php
            $pending = $totalprice + $fedex_price - $due;
        @endphp
        @if ($pending > 0)
            <tr>
                <td class="important">
                    Paid
                </td>
                <td class="important" style="text-align: right;">
                    - ${{ number_format($due + $fee, 2) }} {{ $currency }}
                </td>
            </tr>
            <tr>
                <td class="important">
                    Outstanding Balance
                </td>
                <td class="important" style="text-align: right;">
                    (${{ number_format($pending, 2) }} {{ $currency }})
                </td>
            </tr>
        @endif
    </table>

    <br>
    <hr>
    <br>

    <table style="border-collapse: separate; border-spacing: 0 0.75rem;">
        <tr>
            <td valign="top">
                Billing address
            </td>
            <td style="text-align: right;">
                <div>{{ $fname }}</div>
                <div>{{ $address }}</div>
                <div>{{ $city }}</div>
                <div>{{ $phone }}</div>
            </td>
        </tr>
        <tr>
            <td>
                Account Number
            </td>
            <td style="text-align: right;">
                {{ $account_number }}
            </td>
        </tr>
        <tr>
            <td>
                Email
            </td>
            <td style="text-align: right;">
                <a class="mailto" href="mailto:{{ $email }}">
                    {{ $email }}
                </a>
            </td>
        </tr>
    </table>



    @component('components.footer')
    @endcomponent
@endcomponent
