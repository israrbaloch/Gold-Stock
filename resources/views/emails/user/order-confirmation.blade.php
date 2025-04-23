@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 24px;">Order Number #{{ $order->orderid }}</h1>
        <h2 style="font-size: 18px; font-weight: 600;">ORDER > CONFIRM</h2>

        <p>Hi,</p>
        <p><strong>{{ $order->nameuser }}!</strong></p>
        <p>
            <strong>Your order is confirmed</strong>
            <img src="{{ asset('email-icons/confirm.svg') }}" alt="" width="20px" style="vertical-align: middle;">
        </p>
        <p>
            You’ll receive a notification when your order is ready for pickup or shipping. If any further steps are required, our team will contact you.
        </p>

        <h3>Order Detail:</h3>
        <p>Order Number: <strong>#{{ $order->orderid }}</strong></p>
        <p>Order Date: <strong>
                @php
                    $date = new DateTime($order->created_at);
                    echo $date->format('d-m-Y');
                @endphp
            </strong></p>
        <p>Items Ordered:</p>

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="border-bottom: 1px solid #636363;">
                    <th style="text-align: left; padding: 8px; width:50%">Product</th>
                    <th style="text-align: center; padding: 8px; width:20%">Quantity</th>
                    <th style="text-align: right; padding: 8px; width:30%">Price</th>
                </tr>
            </thead>


            <tbody>
                @foreach ($order->products as $product)
                    <tr style="border-bottom: 1px solid #636363;">
                        <td style="padding: 8px;">
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
                                style="width: 50px; height: auto; vertical-align: middle; margin-right: 10px;">
                            {{ $product->name }}
                        </td>
                        <td style="padding: 8px; text-align: center;">
                            {{ $product->quantity }}
                        </td>
                        <td style="padding: 8px; text-align: right;">
                            ${{ number_format($product->price, 2) }}
                            {{ $order->currency }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @php

            $subTotal = $order->products->sum(function ($product) {
                return $product->price * $product->quantity;
            });

            $fee = 0;
            $total = $subTotal;
            $dueNow = 0;
            $pending = 0;

            $promoCodeDiscount = $order->promo_code_discount;
            $total -= $promoCodeDiscount;

            $shippingOption = $order->shippingOption()->first();

            $paymentMethod = $order->payment_method;

            if ($paymentMethod == 2) {
                $initialDeposit = floor($total * 0.1 * 100) / 100;
                $fee = floor($initialDeposit * 0.0375 * 100) / 100;
            } else {
                $initialDeposit = $total;
                $fee = 0;
            }

            // $initialDeposit = floor($subTotal * 0.1 * 100) / 100;
            if ($subTotal > $shippingOption->free_from) {
                $initialDeposit += $shippingOption->price * 0.1;
            }

            // $fee = floor($initialDeposit * 0.0375 * 100) / 100;

            // $dueNow = $initialDeposit + $fee - $userBalance;
            $dueNow = $initialDeposit + $fee;
            if ($subTotal > $shippingOption->free_from) {
                // $dueNow += $shippingOption->price * 0.1;
                $total += $shippingOption->price;
            }
            $pending = $total - $order->payed;
            // if ($subTotal > $shippingOption->free_from) {
            //     $pending -= $shippingOption->price * 0.1;
            // }
            $total += $fee;

        @endphp

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px; text-align: left;">Sub Total:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($subTotal, 2) }}
                        {{ $order->currency }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">Shipping Service:</td>
                <td style="padding: 8px; text-align: right;">
                    <strong>
                        {{ $shippingOption->name }}
                        @if ($subTotal > $shippingOption->free_from && $shippingOption->price > 0)
                            (${{ number_format($shippingOption->price, 2) }} {{ $order->currency }})
                        @else
                            (Free)
                        @endif
                    </strong>
                </td>
            </tr>
            @if ($order->payment_method == 2)
                <tr>
                    <td colspan="2" style="padding: 8px;">
                        <h4 style="margin: 0;">Paid</h4>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: left; padding-left: 20px;">10% Deposit:</td>
                    <td style="padding: 8px; text-align: right;"><strong>-${{ number_format($initialDeposit, 2) }}
                            {{ $order->currency }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: left; padding-left: 20px;">3.75% Processing Fee:</td>
                    <td style="padding: 8px; text-align: right;"><strong>${{ number_format($fee, 2) }}
                            {{ $order->currency }}</strong></td>
                </tr>
            @endif
            {{-- promo code discount --}}
            @if ($promoCodeDiscount > 0)
                <tr>
                    <td style="padding: 8px; text-align: left;">Promo Code Discount:</td>
                    <td style="padding: 8px; text-align: right;"><strong>-${{ number_format($promoCodeDiscount, 2) }}
                            {{ $order->currency }}</strong></td>
                </tr>
            @endif

            <tr>
                <td style="padding: 8px; text-align: left;">Total:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($total, 2) }}
                        {{ $order->currency }}</strong></td>
            </tr>
            @if ($pending > 0 && $order->payment_method != 3)
                <tr>
                    <td style="padding: 8px; text-align: left;">Outstanding balance:</td>
                    <td style="padding: 8px; text-align: right;"><strong>(${{ number_format($pending, 2) }}
                            {{ $order->currency }})</strong></td>
                </tr>
            @endif
        </table>

        <div style="text-align: center; margin: 20px 0;">
            @component('components.button', ['url' => '#'])
                View your Receipt
            @endcomponent
        </div>

        <hr>

        @include('components.assistance')

        @include('components.social')

        @include('components.footer')
    </div>
@endcomponent
