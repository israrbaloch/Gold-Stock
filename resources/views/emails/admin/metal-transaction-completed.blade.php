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
        New physical conversion from {{ $fname }} -
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
        <tr>
            <td align="left">
                <div class="gray" style="font-size: 1rem;color: #4F4F4F">
                    {{ $metal }}
                </div>
            </td>
            <td align="center">
                <div class="gray" style="color: #4F4F4F">
                    {{ number_format($totalmetal, 5) }}
                </div>
            </td>
            <td align="right">
                <div style="font-weight: 500;color: #4F4F4F; font-weight: 400">
                    ${{ number_format($price_per_oz, 2) }} {{ $currency }}
                </div>
            </td>
        </tr>
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
                ${{ number_format($totalprice + $fee, 2) }} {{ $currency }}
            </td>
        </tr>
        <tr>
            <td>
                Order Type
            </td>
            <td style="text-align: right;">
                {{ $ordertype }}
            </td>
        </tr>
        @if ($fee > 0)
            <tr>
                <td>
                    Subtotal
                </td>
                <td style="text-align: right;">
                    ${{ number_format($totalprice, 2) }} {{ $currency }}</td>
                </td>
            </tr>
            <tr>
                <td>
                    Fee
                </td>
                <td style="text-align: right;">
                    ${{ number_format($fee, 2) }} {{ $currency }}
                </td>
            </tr>
        @endif
        
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

    @component('components.footer')
    @endcomponent
@endcomponent
