<div class="chart-trade-option buy">

    <button type="button" class="button clean button-back">
        Back
    </button>

    <div class="title-container">
        <div class="title">
            Buy {{ strtoupper($_metal) }}/{{ strtoupper($_currency) }}
        </div>
        <div class="title-message">
            Available: $<span class="buy-available"> {{ addCommas($_userBalances['cash'], 4) }} </span>
        </div>
    </div>

    <form>
        <div class="control-container">
            <label for="price-buy">Price</label>
            <input class="input clean right price-buy" id="price-buy" type="text" disabled>
        </div>
        <div class="control-container">
            <label for="amount-buy">Amount</label>
            <div class="input input-container">
                <input class="amount-buy" id="amount-buy" type="number" min="0" value="1">
                <span class="input-unit">/oz</span>
            </div>
        </div>
        <div class="options-container">
            <label for="percentage-buy">Percentage</label>
            <div class="button-group">
                <button type="button" class="btn percentage-button" data-mode="buy" data-percentage="25">
                    25%
                </button>
                <button type="button" class="btn percentage-button" data-mode="buy" data-percentage="50">
                    50%
                </button>
                <button type="button" class="btn percentage-button" data-mode="buy" data-percentage="75">
                    75%
                </button>
                <button type="button" class="btn percentage-button" data-mode="buy" data-percentage="100">
                    100%
                </button>
            </div>
        </div>
        <div class="control-container">
            <label for="total-buy">Total</label>
            <input class="input right total-buy" id="total-buy" type="text">
        </div>
        <div class="control-container">
            <label for="fee-buy">Fee</label>
            <input class="input clean right fee-buy" id="fee-buy" type="text" disabled>
        </div>
    </form>

    <button type="button" class="button btn-action button-buy" id="button-buy">
        Buy
    </button>
</div>
