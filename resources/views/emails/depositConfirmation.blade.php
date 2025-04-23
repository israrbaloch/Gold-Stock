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
        font-size: 1em;
        font-weight: bold;
        text-align: center;
        padding: 5px 0;
    }

</style>

<x-banner />

<div class="container">
    <div class="body">
        <p>New Deposit Request from {{ $data['fname'] }} ({{ $data['email'] }}).</p>
        <table>
            <tr>
                <td class="title-table" colspan="2" style="font-size: 1.3em; padding: 20px 0;">
                    <strong>Deposit</strong> details</td>
            </tr>
            <tr>
                <td style="text-align: left;" class="title-table">Date</td>
                <td style="text-align: right;">{{ $data['date'] }}</td>
            </tr>
            <tr>
                <td style="text-align: left;" class="title-table">Order Type</td>
                <td style="text-align: right;">{{ $data['ordertype'] }}</td>
            </tr>
            @if ($data['ordertype'] == 'Metal')
                <tr>
                    <td style="text-align: left;" class="title-table">Metal</td>
                    <td style="text-align: right;">{{ $data['curr_or_metal'] }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;" class="title-table">Deposit Total</td>
                    <td style="text-align: right;">{{ number_format($data['total'],4) }} Oz</td>
                </tr>
            @else
                <tr>
                    <td style="text-align: left;" class="title-table">Deposit Currency</td>
                    <td style="text-align: right;">{{ $data['curr_or_metal'] }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;" class="title-table">Deposit Total</td>
                    <td style="text-align: right;"> $ {{ number_format($data['total'],2) }}</td>
                </tr>
            @endif
        </table>
    </div>
</div>

<x-footer />
