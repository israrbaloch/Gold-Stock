@component('components.base')
    <style>
        h2 {
            margin-bottom: 0.5rem;
            color: #1E2026;
            font-size: 1.125rem;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }

        table td {
            font-size: 0.875rem;
            color: #4F4F4F;
        }
    </style>

    <x-banner />

    <p>Order date {{ $orderDate }}</p>
    <h1>
        Order Number #{{ $orderid }}
    </h1>
    <p class="subtitle">
        You have received an order from {{ $fname }} -
        <a class="mailto" href="mailto:{{ $email }}">
            {{ $email }}
        </a>
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
            <td>
                Sub Total:
            </td>
            <td style="text-align: right;">
                ${{ number_format($subTotal, 2) }} {{ $currency }}
            </td>
        </tr>
        <tr>
            <td>
                Shipping Service
            </td>
            <td style="text-align: right;">
                {{ $shippingOption->name }}
                @if ($subTotal > $shippingOption->free_from && $shippingOption->price > 0)
                    (${{ number_format($shippingOption->price, 2) }} {{ $currency }})
                @else
                    (Free)
                @endif
            </td>
        </tr>

        @if ($pending > 0)
            <tr>
                <td class="important">
                    Paid
                </td>
                <td class="important" style="text-align: right;">
                    - ${{ number_format($dueNow, 2) }} {{ $currency }}
                </td>
            </tr>
        @endif
        @if ($dueNow > 0 && $paymentMethod == 2)
            <tr>
                <td style="text-indent: 1rem">
                    10% Deposit
                </td>
                <td style="text-align: right;">
                    ${{ number_format($initialDeposit, 2) }} {{ $currency }}
                </td>
            </tr>
        @endif
        @if ($fee > 0 && $paymentMethod == 2)
            <tr>
                <td style="text-indent: 1rem">
                    3.75% Processing Fee
                </td>
                <td style="text-align: right;">
                    ${{ number_format($fee, 2) }} {{ $currency }}
                </td>
            </tr>
        @endif
        {{-- @if ($total > $shippingOption->free_from && $shippingOption->price > 0)
            <tr>
                <td style="text-indent: 1rem">
                    10% Shipping Fee
                </td>
                <td style="text-align: right;">
                    ${{ number_format($shippingOption->price * 0.1, 2) . ' ' . $currency }}
                </td>
            </tr>
        @endif --}}

        <tr>
            <td class="important">
                Total
            </td>
            <td class="important" style="text-align: right;">
                ${{ number_format($total, 2) }} {{ $currency }}
            </td>
        </tr>

        @if ($pending > 0 && $paymentMethod == 2)
            <tr>
                <td class="important">
                    Outstanding Balance
                </td>
                <td class="important" style="text-align: right;">
                    (${{ number_format($pending, 2) }} {{ $currency }})
                </td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <a href="{{ URL::to('/') }}/funds" class="button" style="width: 100%">
                        Payment Options
                    </a>
                </td>
            </tr>
        @endif
    </table>

    <br>
    <hr>
    <br>

    <table style="border-collapse: separate; border-spacing: 0 0.75rem;">
        <tr>
            <td>
                Shipping Method
            </td>
            <td style="text-align: right;">
                {{ $shippingOption->name }}
            </td>
        </tr>
        @if ($shippingOption->show_address)
            <tr>
                <td valign="top">
                    Store Address
                </td>
                <td style="text-align: right;">
                    <div>3rd Floor - 55 Dundas St East</div>
                    <div>Toronto</div>
                    <div>Ontario</div>
                    <div>M5B-1C6</div>
                </td>
            </tr>
        @else
            <tr>
                <td valign="top">
                    Shipping Address
                </td>
                <td style="text-align: right;">
                    <div>{{ $fname }}</div>
                    <div>{{ $address }}</div>
                    <div>{{ $city }}</div>
                    <div>{{ $phone }}</div>
                </td>
            </tr>
        @endif
    </table>

    @component('components.footer')
    @endcomponent
@endcomponent
