<style>
    td a {
        padding: 10px 0px;
        color: #1E2026;
        font-size: 1rem;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-transform: uppercase;
        text-align: center;
    }
</style>

<table style="border-collapse: separate; border-spacing: 0 1rem;">
    <tr>
        <td align="left">
            <a href="{{ route('exchange') }}" target="_blank">
                Exchange
            </a>
        </td>
        <td align="center">
            <a href="{{ route('shop') }}" target="_blank">
                Shop
            </a>
        </td>
        {{-- <td align="center">
            <a href="{{ route('getliveprices') }}" target="_blank">
                Live Prices
            </a>
        </td> --}}
        <td align="right">
            <a href="{{ route('home') }}" target="_blank">
                See All
            </a>
        </td>
    </tr>
</table>

<hr>
<br>
