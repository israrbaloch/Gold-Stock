@component('components.base')
    <style>
        .important {
            color: #1E2026;
            font-size: 0.875rem;
            font-style: normal;
            font-weight: 600;
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
        Thank you for choosing Gold Stock Canada! Your order is now in progress, and we'll notify you once it ships. Below
        are the
        details of your purchase:
    </p>

    <br>

    <table style="border-collapse: separate; border-spacing: 0 2rem;">
        @foreach ($products as $product)
            <tr>
                <td align="center">
                    @php
                        $imagesData = json_decode($product->getImages());

                        // Check if the decoded value is an array
                        if (is_array($imagesData) && count($imagesData) > 0) {
                            // Select the first image in the array
                            $image = $imagesData[0];
                            // Replace backslashes with forward slashes in the image path and prepend the 'storage/' directory
                            $image = asset('storage/' . str_replace('\\', '/', $image));
                        } else {
                            // Assume the decoded value is a comma-separated list of image paths
                            $exp = explode(',', $product->images);
                            // Select the first image in the list
                            $image = asset($exp[0]);
                        }
                    @endphp
                    <img src="{{ $image }}" alt="{{ $product->name }}"
                        style="max-width: 100px;max-height: 100px;margin-right: 1rem">
                </td>
                <td>
                    <div class="gray" style="font-size: 1rem;color: #4F4F4F">
                        {{ $product->name }}
                    </div>
                    <div class="gray" style="font-size: 0.8rem;color: #4F4F4F">
                        Quantity: {{ $product->quantity }}
                    </div>
                </td>
                <td align="right">
                    <div class="title important">
                        ${{ number_format($product->quantity * $product->price, 2) }} {{ $currency }}
                    </div>
                    <div style="font-weight: 500;color: #4F4F4F; font-weight: 400; font-size: 0.75rem">
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
        {{-- $promoCodeDiscount --}}
        @if ($promoCodeDiscount > 0)
            <tr>
                <td>
                    Promo Code Discount
                </td>
                <td style="text-align: right;">
                    - ${{ number_format($promoCodeDiscount, 2) }}
                </td>
            </tr>
        @endif
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

        @if ($pending > 0)
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

    <x-goodbye />

    @component('components.footer')
    @endcomponent
@endcomponent
