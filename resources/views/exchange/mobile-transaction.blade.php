<div id="mobile-transaction">
    <div class="row mx-0">
        <div class="col-7">
            <div class="box-orange-border row g-0">
                <div class="transaction-type buy active text-center col-6" data-transaction="buy">Buy</div>
                <div class="transaction-type sell text-center col-6" data-transaction="sell">Sell</div>
            </div>
            <div style="margin: 10px 0;">
                <div>Available</div>
                <div class="sell-avaialability available-value" style="display: none;"><span
                        id="available-metal-value">{{ $get_id }}</span>/oz 
                        <!-- <span class="metal-code">BTC</span> -->
                </div>
                <div class="buy-avaialability available-value"><span id="available-cash-value">$
                        {{ Auth::check() && $cashBalance > 0 ? number_format($cashBalance, 2) : 0 }}</span>
                    {{ $currency }} </div>
            </div>
            <form>
                <div class="form-group">
                    <input id="transaction-metal-price" class="form-control text-right disabled" disabled>
                </div>
                <div class="form-group relative">
                    <input id="transaction-amount-fake" type="number"
                        class="form-control text-right input-with-unit" placeholder="Amount" value="1">
                    <input type="hidden" id="transaction-amount" type="number"
                        class="form-control text-right input-with-unit" placeholder="Amount" value="1">
                    <span class="input-unit">/oz</span>
                </div>
            </form>
            <!-- <div class="row g-0 mobile-small-font" style="margin-top: 10px;">
                <div class="col-8">Max Amount:</div>
                <div class="col-4 font-weight-bold">0.00 <span class="metal-code">BTC</span></div>
            </div> -->
            <div class="row g-0 mobile-small-font avg-container" style="margin-top: 10px;">
                <div class="col-3 text-center avg-cells percent-trigger-mobile" data-val="0.25">25%</div>
                <div class="col-3 text-center avg-cells percent-trigger-mobile" data-val="0.5">50%</div>
                <div class="col-3 text-center avg-cells percent-trigger-mobile" data-val="0.75">75%</div>
                <div class="col-3 text-center avg-cells percent-trigger-mobile" data-val="1">100%</div>
            </div>
            <div class="row g-0" style="margin-top: 10px;">
                <div class="col-3" style="padding-top: 10px;">Total</div>
                <input id="total-transaction-fake" style="padding-right: 5px; padding-bottom: 0;"
                    class="col-9 form-control text-right" value="0.00" />
                <input type="hidden" id="total-transaction" style="padding-right: 5px; padding-bottom: 0;"
                    class="col-9 form-control text-right" value="0.00" />
            </div>
            <button id="mobile-buy-btn" class="btn btn-success mobile-transaction-btn disabled"
                disabled>Buy</button>
            <button id="mobile-sell-btn" class="btn btn-danger mobile-transaction-btn disabled"
                style="display: none;" disabled>Sell</button>
        </div>
        <div class="col-5">
            <div class="text-left">
                <span
                    class="last-price mobile-small-font">{{ number_format($prices[$get_id]['sellingounce'], 2) }}</span>
            </div>
            <div class="row g-0">
                <div class="col-6 mobile-small-font">Price</div>
                <div class="col-6 text-right mobile-small-font">Amount</div>
                @for ($i = 0; $i < 10; $i++)
                    <div class="row mobile-bottom-border g-0">
                        <div class="col-7 red-color bid-{{ $i }} mobile-small-font"><span
                                class="bid-{{ $i }}"></span></div>
                        <div class="col-5  mobile-small-font text-right">100</div>
                    </div>
                @endfor
                @for ($i = 0; $i < 10; $i++)
                    <div class="row mobile-bottom-border g-0">
                        <div class="col-7 green-color ask-{{ $i }} mobile-small-font"><span
                                class="ask-{{ $i }}"></span></div>
                        <div class="col-5  mobile-small-font text-right">100</div>
                    </div>
                @endfor
            </div>
            <div class></div>
        </div>
        </br>
    </div>
    <br>
    <br>
</div>