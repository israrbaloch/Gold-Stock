<style>
    .container {
        width: 80%;
        margin: 0 auto;
        border-radius: 0 0 10px 10px;
        border: 1px solid #A9954C;
    }

    .body {
        margin: 8%;
    }

    table {
        width: 100%;
    }

    .title-table {
        color: #35571A;
        font-size: 1.3em;
        font-weight: bold;
        text-align: center;
        padding: 20px 0;
    }
</style>

<x-banner />

<div class="container">

    <div class="body">
        Hi there. Your recent order on GoldStockCanada.com has been completed. Your order details are shown below for your reference:
        <br><br>
        <table>
            <tbody>
                <tr>
                    <td colspan="3" class="title-table">
                        Order Number: {{ $data['orderid'] }}
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="title-table">User billing details</td>
                </tr>
                <tr>
                    <td colspan="3">
                        Account number: {{ $data['account_number'] }} <br>
                        Email: {{ $data['email'] }} <br>
                        <strong> {{ $data['fname'] }} </strong> <br>
                        {{ $data['address'] }} <br>
                        {{ $data['city'] }} <br>
                        Phone number: {{ $data['phone'] }} <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="title-table" style="padding-top: 40px;">Order Details</td>
                </tr>

                <tr>
                    <td style="text-align: left;" class="title-table">Order Type</td>
                    <td style="text-align: right;">{{ $data['ordertype'] }}</td>
                </tr>

                <tr>
                    <td colspan="3">

                        <table style="margin-bottom: 30px">
                            <tr>
                                <td class="title-table"
                                    style="font-size: 1.2em; text-align: left; padding-bottom: 5px; border-bottom: solid 1px rgb(160, 151, 151);">
                                    Product</th>
                                <th class="title-table"
                                    style="font-size: 1.2em; padding-bottom: 5px; border-bottom: solid 1px rgb(160, 151, 151);">
                                    Quantity</th>
                                <th class="title-table"
                                    style="font-size: 1.2em; text-align: right; padding-bottom: 5px; border-bottom: solid 1px rgb(160, 151, 151);">
                                    Price</th>
                            </tr>

                            <tr>
                                <td>{{ $data['metal'] }}</td>
                                <td style="text-align: center;">{{ number_format($data['totalmetal'],5) }}</td>
                                <td style="text-align: right;">${{ number_format($data['price_per_oz'],2) }}</td> {{ $data['currency'] }}
                                </td>
                            </tr>

                        </table>

                    </td>
                </tr>
                @if($data['fee'] > 0)
                <tr>
                    <td class="title-table" style="text-align: left; font-size: 1em;">SUBTOTAL:</td>
                    <td colspan="2" style="text-align: right;">${{ number_format($data['totalprice'],2) }} {{ $data['currency'] }}</td>
                </tr>
                <tr>
                    <td class="title-table" style="text-align: left; font-size: 1em;">3.75% PROCESSING FEE:</td>
                    <td colspan="2" style="text-align: right;">${{ number_format($data['fee'],2) }} {{ $data['currency'] }}</td>
                </tr>
                @endif
                <tr>
                    <td class="title-table" style="text-align: left; font-size: 1em;">TOTAL:</td>
                    <td colspan="2" style="text-align: right;">${{ number_format($data['totalprice'] + $data['fee'], 2) }} {{ $data['currency'] }}</td>
                </tr>
                @if($data['pending'] > 0)
                    <tr>
                        <td class="title-table" style="text-align: left; font-size: 1em;">DUE NOW:</td>
                        <td colspan="2" style="text-align: right;">${{ number_format($data['due'] + $data['fee'], 2) }} {{ $data['currency'] }}</td>
                    </tr>
                    <tr>
                        <td class="title-table" style="text-align: left; font-size: 1em;">PENDING BALANCE:</td>
                        <td colspan="2" style="text-align: right;">${{ number_format($pending,2) }} {{ $data['currency'] }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>

</div>

<x-footer />
