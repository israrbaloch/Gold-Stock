@component('components.base')
    <style>

    </style>

    <x-banner />

    <h1>
        New Withdrawal Confirmation
    </h1>
    <p class="subtitle">
        from {{ $fname }} -
        <a class="mailto" href="mailto:{{ $email }}">
            {{ $email }}
        </a>
    </p>

    <br>

    <table>
        <tr>
            <td style="text-align: left;">Date</td>
            <td style="text-align: right;">{{ $date }}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Order Type</td>
            <td style="text-align: right;">{{ $ordertype }}</td>
        </tr>
        @if ($ordertype == 'Metal')
            <tr>
                <td style="text-align: left;">Metal</td>
                <td style="text-align: right;">{{ $curr_or_metal }}</td>
            </tr>
            <tr>
                <td style="text-align: left;">Whitdrawall Total</td>
                <td style="text-align: right;">{{ number_format($total, 4) }} Oz</td>
            </tr>
        @else
            <tr>
                <td style="text-align: left;">Whitdrawall Currency</td>
                <td style="text-align: right;">{{ $curr_or_metal }}</td>
            </tr>
            <tr>
                <td style="text-align: left;">Whitdrawall Total</td>
                <td style="text-align: right;">$ {{ number_format($total, 2) }}</td>
            </tr>
        @endif
    </table>

    @component('components.footer')
    @endcomponent
@endcomponent
