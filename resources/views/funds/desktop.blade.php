<div class="d-none d-sm-block">
    <div class="title-page-1 text-center">Funds</div>

    <h2>Cash balance</h2>
    <table class="table coins-table">
        <thead class="thead-dark">
            <tr>
                <th class="table-legends" scope="col">Currency</th>
                <th class="table-legends" scope="col">Total balance</th>
                <th class="table-legends" scope="col">Available balance</th>
                <th class="table-legends" scope="col">In order</th>
                <th class="table-no-legends" scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userCashBalances as $balance)
                <tr>
                    <td>
                        {{ $balance['currency'] }}
                    </td>
                    <td>
                        ${{ number_format($balance['total'], 2) }}
                    </td>
                    <td>
                        ${{ number_format($balance['total'], 2) }}
                    </td>
                    <td>
                        0
                    </td>

                    <td>
                        <div class="row g-0 ref-funds">
                            <div class="col-4 ps-md-2">
                                <a href="/deposit-cash?currency={{ $balance['currency'] }}" class="btn">Deposit</a>
                            </div>
                            <div class="col-4 ps-md-2">
                                <a href="/whitdrawal-cash?currency={{ $balance['currency'] }}"
                                    class="btn">Withdrawal</a>
                            </div>
                            <div class="col-4 ps-md-2">
                                <a href="/exchange" class="btn">Trade</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Metal balance</h2>
    <table class="table coins-table">
        <thead class="thead-dark">
            <tr>
                <th class="table-legends" scope="col">Metal</th>
                <th class="table-legends" scope="col">Total balance</th>
                <th class="table-legends" scope="col">Available balance</th>
                <th class="table-legends" scope="col">In order</th>
                <th class="table-no-legends" scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userMetalBalances as $balance)
                <tr>
                    <td class="lefty">
                        <span class="coin-img-desk">
                            <img alt="" src="/img/{{ $balance['metalName'] }}.png">
                        </span>
                        <a href="/holding?metal={{ $balance['metalName'] }}">
                            {{ $balance['metalName'] }}
                        </a>
                    </td>
                    <td>{{ addCommas($balance['total'], 5) }}/oz</td>
                    <td>{{ addCommas($balance['total'], 5) }}/oz</td>
                    <td>0</td>

                    <td>
                        <div class="row g-0 ref-funds">
                            <div class="col-4 ps-md-2">
                                <a href="/deposit-coin" class="btn">Deposit</a>
                            </div>
                            <div class="col-4 ps-md-2">
                                <a href="/convert-to-physical?metal={{ $balance['metalName'] }}"
                                    class="btn">Withdrawal</a>
                            </div>
                            <div class="col-4 ps-md-2">
                                <a href="/exchange" class="btn">Trade</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
