@component('components.base')
    <style>

    </style>

    <x-banner />

    <h1>
        New Physical Conversion Received
    </h1>
    <p class="subtitle">
        from {{ $fname }}
    </p>

    <br>

    <table style="margin-bottom: 30px">
        <thead>
            <tr>
                <th align="left">Product</th>
                <th>Quantity</th>
                <th align="right">Price</th>
            </tr>
        </thead>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product['name'] }}</td>
                <td style="text-align: center;">
                    {{ $product['quantity'] }}
                </td>
                <td style="text-align: right;">
                    ${{ number_format($product['price'], 2) }} {{ $currency }}
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
                Total Price
            </td>
            <td class="important" style="text-align: right;">
                ${{ number_format($totalprice, 2) }} {{ $currency }}
            </td>
        </tr>
        <tr>
            <td class="important">
                Total Converted
            </td>
            <td style="text-align: right;">
                {{ number_format($totalmetal, 5) }} Oz
            </td>
        </tr>
        <tr>
            <td class="important">
                Paid
            </td>
            <td class="important" style="text-align: right;">
                - ${{ $due }} {{ $currency }}
            </td>
        </tr>
        <tr>
            <td>
                Delivery
            </td>
            <td style="text-align: right;">
                {{ $delivery }}
            </td>
        </tr>
    </table>

    <br>
    <hr>
    <br>

    <table style="border-collapse: separate; border-spacing: 0 0.75rem;">
        <tr>
            <td>
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
