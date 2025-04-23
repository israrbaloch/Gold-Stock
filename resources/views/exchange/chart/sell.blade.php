<div class="chart-trade-option sell">

    <button type="button" class="button clean button-back">
        Back
    </button>

    <div class="title-container">
        <div class="title">
            Sell {{ ucfirst($_metal) }}/{{ strtoupper($_currency) }}
        </div>
        <div class="title-message">
            Available: <span class="sell-available">{{ addCommas($_userBalances[$_metal], 5) }}</span> oz
        </div>
    </div>

    <form>
        <div class="control-container">
            <label for="price-sell">Price</label>
            <input class="input clean right price-sell" id="price-sell" type="text" disabled>
        </div>
        <div class="control-container">
            <label for="amount-sell">Amount</label>
            <div class="input input-container">
                <input class="amount-sell" id="amount-sell" type="number" min="0" value="1">
                <span class="input-unit">/oz</span>
            </div>
        </div>
        <div class="options-container">
            <label for="percentage-sell">Percentage</label>
            <div class="button-group">
                <button type="button" class="btn percentage-button" data-mode="sell" data-percentage="25">
                    25%
                </button>
                <button type="button" class="btn percentage-button" data-mode="sell" data-percentage="50">
                    50%
                </button>
                <button type="button" class="btn percentage-button" data-mode="sell" data-percentage="75">
                    75%
                </button>
                <button type="button" class="btn percentage-button" data-mode="sell" data-percentage="100">
                    100%
                </button>
            </div>
        </div>
        <div class="control-container">
            <label for="total-sell">Total</label>
            <input class="input right total-sell" id="total-sell" type="text">
        </div>
        <div class="control-container">
            <label for="fee-sell">Fee</label>
            <input class="input clean right fee-sell" id="fee-sell" type="text" disabled>
        </div>
    </form>

    <button type="button" class="button btn-action button-sell" id="button-sell">
        Sell
    </button>
</div>
