@include('header.index')
@php
$user = Auth::user();
@endphp
<!--<script src="https://api.convergepay.com/hosted-payments/PayWithConverge.js"></script>-->
<link href="{{ URL::to('/') }}/css/cart.css?ver=1.0.0" rel="stylesheet">
<script type="text/javascript" src="{{ URL::to('/') }}/js/cart.js?ver=1.0.0"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/elavon.js?ver=1.0.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://api.convergepay.com/hosted-payments/PayWithConverge.js"></script>


@php
if ($type == 'product'){
    $subTotal = $order->priceproduct;
} elseif ($type == 'metal'){
    $subTotal = $order->quantity_oz * $order->price_per_oz;
} else {
    $subTotal = $order->value;
}
$shipping_price = $fedex ? $fedex->price : 0;
$shipping_name = $fedex ? $fedex->service : $order->shipping_option;
$minDeposit = $order->has_fee ? round(($subTotal+$shipping_price)*0.1, 2) : 0;
$fee = $order->has_fee ? round($minDeposit * 0.0375, 2) : 0;
$total = $type == 'cash' ? $subTotal : round($order->subtotal, 2);
$dueNow = $order->has_fee ? $order->paid + $fee : $order->paid;
$pending = $order->has_fee ? $total + $fee - $dueNow : $total - $dueNow;
$currency = $order->currency;
$fromBalance = 0;
//dd($products->name);
@endphp
<div class="page-container page-container-checkout">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2 text-bold color-dark-green checkout-title text-center">
            <h3>ORDER SUMMARY</h3>
            <b>Order number: {{ $type != 'cash' ? $order->order_id : 'CD' . $order->id }}</b>
        </div>
        <div class="order-summary col-12 col-md-8 offset-md-2">
            @if($type == 'product')
                @foreach ($products as $item)
                <div class="row checkout-product-box">
                    <div class="product-thumbnail col-4 col-md-4">
                        @php
                            $exp = explode(",", $item->images);
                            $thumbnail = $exp[0];
                        @endphp
                        <img src="{{$thumbnail}}">
                    </div>
                    <div class="name col-4">
                        <b>{{ $item->name }}</b>
                        <b>&nbsp;&nbsp;x{{ $item->quantity }}</b>
                    </div>
                    <div class="total col-4">
                        {{ $currency }} ${{ number_format($item->price * $item->quantity, 2) }}				
                    </div>
                </div>
                @endforeach
            @elseif ($type == 'metal')
                <div class="row checkout-product-box">
                    <div class="product-thumbnail col-4 col-md-4">
                        @php
                            $thumbnail = '/img/' . $products->name . '.png';
                        @endphp
                        <img src="{{$thumbnail}}">
                    </div>
                    <div class="name col-4">
                        <b>{{ $products->name }}</b>
                        <b>&nbsp;&nbsp;x{{ $order->quantity_oz }}</b>
                    </div>
                    <div class="total col-4">
                        {{ $currency }} ${{ number_format($order->price_per_oz * $order->quantity_oz, 2) }}				
                    </div>
                </div>
            @else
                <div class="row checkout-product-box">
                    <div class="product-thumbnail col-4 col-md-4">
                        @php
                            $thumbnail = '/img/money_sign.svg';
                        @endphp
                        <img src="{{$thumbnail}}">
                    </div>
                    <div class="name col-4">
                        <b>{{ $products['name'] }}</b>
                    </div>
                    <div class="total col-4">
                        {{ $products['currency'] }} ${{ number_format($order->value , 2) }}				
                    </div>
                </div>
            @endif
        </div>
        <div class="col-12 col-md-8 offset-md-2">
            <br>
            <br class='d-none d-md-block'>
            <div class="order-desc row">
                <div class="col-12">
                    <div id="order_review" class="checkout-review-order">
                        <table class="shop_table checkout-review-order-table">
                            <tbody>
                                    <tr class="cart_item">
                                        <td class="product-name left-side-td">
                                            Subtotal:							
                                        </td>
                                        <td class="product-total right-side-td">
                                            ${{ number_format($subTotal, 2) }} {{ $currency }}
                                        </td>
                                    </tr>
                                @if($type == 'product')
                                    <tr class="shipping cart_item">
                                        <td class="product-name left-side-td">
                                            Shipping:
                                        </td>
                                        <td align="right" class="right-side-td" data-title="Shipping">
                                            {{ $shipping_name }} / ${{ number_format($shipping_price,2) . ' ' . $currency }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($type != 'cash')
                                    @foreach($order->payments as $payment)
                                        @php $fromBalance += $payment['payment_method_id'] == 5 ? $payment['value'] : 0; @endphp
                                        @if ($payment['payment_method_id'] == 3)
                                            <tr class="cart_item">
                                                <td class="product-name left-side-td">
                                                    10% Deposit:							
                                                </td>
                                                <td class="product-total right-side-td">
                                                    ${{ number_format($minDeposit,2) }} {{ $currency }}
                                                </td>
                                            </tr>
                                            <tr class="cart_item">
                                                <td class="product-name left-side-td">
                                                    3.75% processing fee:								
                                                </td>
                                                <td class="product-total right-side-td">
                                                    ${{ number_format($fee,2) }} {{ $currency }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr class="cart_item">
                                        <td class="product-name left-side-td">
                                            3.75% processing fee:								
                                        </td>
                                        <td class="product-total right-side-td">
                                            ${{ number_format($order->value * 0.0375,2) }} {{ $currency }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($type != 'cash')
                                <tr class="shipping cart_item order-total" style="border-bottom: solid 1px #A9954B;">
                                    <td class="product-name left-side-td">Total:</td>
                                    <td class="right-side-td">
                                        ${{ number_format(($total + $fee),2) }} {{ $currency }}
                                    </td>
                                </tr>
                                @endif
                                <tr class="cart_item" style="border-bottom: solid 1px #A9954B;">
                                    <td class="product-name left-side-td">
                                        Paid:
                                    </td>
                                    <td class="product-total right-side-td">
                                        <span class="price-amount amount">- ${{ $type != 'cash' ? number_format($dueNow,2) : number_format($total + $fee * 10 ,2) }}</span> {{ $currency }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                @if ($type != 'cash')
                                    @if ($fromBalance > 0)
                                    <tr class="cart-subtotal">
                                        <th>From Balance on account:</th>
                                        <td>
                                            ${{ number_format($fromBalance,2) }} {{ $currency }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr class="cart-subtotal">
                                        <th>
                                            Balance Pending:
                                        </th>
                                        <td>
                                            ${{ number_format(($pending),2) }} {{ $currency }}
                                        </td>
                                    </tr>                                
                                @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')