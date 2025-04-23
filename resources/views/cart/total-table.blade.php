<div id="total-table">
    <table cellspacing="0" class="no-style">
        <tbody>
            <input type="hidden" name="total_weight" id="total_weight">
            <tr>
                <td align="left">
                    <b>
                        Due Now:
                    </b>
                </td>
                <td align="right">
                    <b>
                        $<span class="price-amount">
                            {{ number_format($dueNow, 2) }}
                        </span>
                        {{ strtoupper($_currency) }}
                    </b>
                </td>
            </tr>
            @if ($paymentMethod == 2)
                <tr>
                    <th style="text-indent: 2rem;">
                        10% Deposit:
                    </th>
                    <td align="right">
                        $<span class="initial">
                            {{ number_format($initialDeposit, 2) }}</span>
                        <span>
                            {{ strtoupper($_currency) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th style="text-indent: 2rem;">
                        3.75% Processing Fee:
                    </th>
                    <td align="right">
                        $<span class="fee">
                            {{ number_format($fee, 2) }}
                        </span>
                        <span>
                            {{ strtoupper($_currency) }}
                        </span>
                    </td>
                </tr>
            @endif
            {{-- promo code  --}}
            <tr id="promo-code-row">
                @if (isset($promoCodeDiscount) && $promoCodeDiscount > 0)
                    <th>
                        Promo Code Discount:
                    </th>
                    <td align="right">
                        - $<span class="promo-code-discount">
                            {{ number_format($promoCodeDiscount, 2) }}
                        </span>
                        <span>
                            {{ strtoupper($_currency) }}
                        </span>
                    </td>
                @endif
            </tr>


            <tr class="order-total">
                <th>
                    Total
                </th>
                <td align="right" class="product-price">
                    <b>
                        $<span class="total">
                            {{ number_format($total, 2) }}
                        </span>
                        <span>
                            {{ strtoupper($_currency) }}
                        </span>
                    </b>
                </td>
            </tr>
        </tbody>
    </table>
</div>