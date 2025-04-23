<div class="funds-mobile d-block d-md-none">
    <br><br>

    <div class="links text-center">
        <div class="row g-0">
            <div class="col-6 pe-1">
                <a href="/deposit" class="button btn-left text-center w-100">
                    Deposit
                </a>
            </div>
            <div class="col-6 ps-1">
                <a href="/whitdraw" class="button btn-right text-center w-100">
                    Withdraw
                </a>
            </div>
        </div>
    </div>

    <div class="currencies-container" style="margin-top: 20px;">
        <div class="bg-gray pre-title text-bold">
            Cash Balance
        </div>
        <div class=" row g-0">
            <div class="col-6 text-left text-bold post-title">
                Currency
            </div>
            <div class="col-6 text-right text-bold post-title">
                Total
            </div>
        </div>
        @foreach ($userCashBalances as $balance)
            <div class="currency-container">
                {{ $balance['currency'] }} <span class="float-right">$
                    {{ number_format($balance['total'] > 0 ? $balance['total'] : 0, 2) }}</span>
            </div>
        @endforeach
    </div>
    <div class="coins-container" style="margin: 20px 0;">
        <div class="bg-gray pre-title text-bold">
            Metal Balance
        </div>
        <div class=" row g-0">
            <div class="col-6 text-left text-bold post-title">
                Metal
            </div>
            <div class="col-6 text-right text-bold post-title">
                Total
            </div>
        </div>
        @foreach ($userMetalBalances as $balance)
            <div class="coin-container">
                <span class="coin-img">
                    <img alt="" src="/img/{{ $balance['metalName'] }}.png">
                </span>
                <a href="/holding?metal={{ $balance['metalName'] }}">
                    <span class="coin-name">{{ $balance['metalName'] }}</span>
                    <span class="float-right">{{ addCommas($balance['total'], 5) }}/oz</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
