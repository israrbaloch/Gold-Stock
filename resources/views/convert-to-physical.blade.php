@extends('header.index')

@php
    $currency = Cookie::get('currency');
@endphp


@push('styles')
    <link href="{{ URL::to('/') }}/css/convert-to-physical.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/convert-to-physical.js?ver=1.2.0"></script>
@endpush

@section('content')
    <div class="page-container container">
        <div class="row g-0 main-cont">
            <div class="col-12">
                <div class="row go-gutters mobile-title d-md-none"
                    style="background-image: url('/img/deposit-bar-mob.png'); background-repeat: no-repeat;background-size:contain;background-position: right;">
                    <div class="text-left text-bold col-6 balance-title-mobile color-dark-green">Current balance</div>
                    <div class="text-right text-bold col-6 balance-total-mobile color-dark-green">
                        <?= number_format($usermetalbalance['total'], 2) ?>/oz <?= $usermetalbalance['metal'] ?></div>
                </div>
                <div class="row border-section">
                    <div class="col-12 col-md-7 text-center">
                        <div id="imaginary_container">
                            <br class="d-none d-md-block"><br class="d-none d-md-block">
                            <div class="row deposit-value-row">
                                <div class="col-4 col-md-4 offset-md-1">
                                    <label>Oz to convert</label>
                                </div>
                                <div class="col-8 col-md-7">
                                    <div class="input-group mb-3">
                                        <input id="amount-to-convert" type="number" class="form-control makeup-input"
                                            placeholder="" style="width: 100%"
                                            data-available="<?= $usermetalbalance['total'] ?>">
                                        <span class="input-unit">/oz</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row deposit-value-row">
                                <div class="col-12 text-right">
                                    <span class="reset" style="display: none;">Change Amount (reset
                                        products)</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-7 offset-md-5">
                                <button id="show-products-to-convert" type="button"
                                    class="btn makeup-btn-dark-green">Withdraw</button>
                            </div>
                            <br>
                        </div>

                    </div>
                    <div class="d-none d-md-block col-md-5">
                        <div class="row">
                            <div class="text-right text-bold col-12 balance-title color-dark-green"
                                style="background-image: url('/img/highlight.png'); background-repeat: no-repeat;background-size:contain;background-position: right;">
                                Current balance</div>
                            <div class="text-right text-bold col-12 balance-total">
                                <i><?= number_format($usermetalbalance['total'], 5) ?>/oz
                                    <?= $usermetalbalance['metal'] ?></i>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="available" name="available" value="<?= $usermetalbalance['total'] ?>">
                    <input type="hidden" id="added" name="added" value="0">
                    <input type="hidden" id="currency" name="currency" value="<?= $usercashbalance['currency'] ?>">
                    <input type="hidden" id="metal-id" name="metal-id" value="<?= $usermetalbalance['metalid'] ?>">
                    <input type="hidden" id="metal-name" name="metal-name" value="<?= $usermetalbalance['metal'] ?>">
                    <input type="hidden" id="cash-funds" name="cash-funds" value="<?= $usercashbalance['total'] ?> ">
                </div>
                <br>
                <div class="row border-section remaining-counter" style="display: none;">
                    <div class="col-6 text-center">
                        <span class="color-gold">Total weight added to convert:</span> <span
                            class="total-weight-counter text-bold color-yellow"></span><span
                            class="text-bold color-yellow">/oz</span>
                    </div>
                    <div class="col-6 text-center">
                        <span class="color-gold">Weight Remaining:</span> <span
                            class="remaining-weight-counter color-yellow text-bold"></span><span
                            class="text-bold color-yellow">/oz</span>
                    </div>
                </div>
                <br>
                <div id="convert-products" class="row g-0 border-section" style="display: none;">
                    <br>
                    <?php if(sizeof($products) < 1) { ?>
                    <h3 class="text-center">No Products Available for your amount.<br><br></h3>
                    <?php } ?>
                    <?php foreach($products as $product_item) {
                $exp = explode(",", $product_item['images']);
                $img = $exp[0];                 
                    ?>
                    <div id="convert-product-<?= $product_item['id'] ?>" class="convert-product col-12 col-md-6"
                        data-weight="<?= $product_item['weight_oz'] ?>">
                        <div class="product-box-convert row">
                            <div class="col-4 text-center product-image"><img src="<?= $img ?>" /></div>
                            <div class="col-4 text-left product-name"><b><?= $product_item['name'] ?></b></div>
                            <div class="col-4 text-left product-text color-yellow text-bold">Convert fee: $ <span
                                    class="color-yellow text-bold">
                                    <?= number_format($product_item['real_conversion'], 2) ?>
                                    <?= $usercashbalance['currency'] ?></span></div>

                            <div class="col-4 text-left color-yellow text-bold product-text">Weight: <span
                                    class="color-yellow text-bold"><?= number_format($product_item['weight_oz'], 5) ?>/oz</span>
                            </div>
                            <div class="col-8 col-md-4 text-right">
                                <div class="color-yellow text-bold">Quantity: <input class="product-input makeup-input"
                                        type="number" id="product-quantity-<?= $product_item['id'] ?>" name="quantity"
                                        min="1" value="1"></div>
                            </div>
                            <div class="col-12 col-md-4 text-right"><button name="add-to-cart"
                                    class="btn makeup-btn-dark-green add-to-convert" data-id="<?= $product_item['id'] ?>"
                                    data-weight="<?= $product_item['weight_oz'] ?>"
                                    data-name="<?= $product_item['name'] ?>"
                                    data-price="<?= number_format($product_item['real_conversion'], 2) ?>">Add to
                                    convert</button></div>
                        </div>

                    </div>
                    <?php } ?>
                </div>
                <br>
                <div id="added-products" class="border-section" style="display: none;">
                    <div class="row g-0">
                        <div class="col-12 text-center text-bold color-dark-green text-cap no-gutters">
                            <br>
                            products to Convert:
                            <br><br>
                        </div>
                    </div>
                    <div id="added-product-list" class="row g-0">

                    </div>
                    <br><br>
                    <div class="row g-0">
                        <div class="col-12 col-md-6 text-center color-gold text-bold">
                            Total weight to Convert: <span id="total-weight">0</span>/oz
                            <br><br>
                            Total Convert fee: $ <span id="total-price">0</span><?= $usercashbalance['currency'] ?>
                            <br><br>
                        </div>
                        <div class="col-12 col-md-6 text-center">
                            <br><br><br>
                            <button type="submit" name="add-to-cart"
                                class="single_add_to_cart_button-dark-green button show-payment">CONVERT!</button>
                        </div>
                    </div>
                </div>
                <br>
                <div id="payment" class="border-section" style="display: none;">

                    <div class="row">
                        <div class="col-5 col-md-4 offset-md-1">
                            <label>Payment Option</label>
                        </div>
                        <div class="col-7 col-md-7">
                            <select id="convert-option-fake" class="form-control makeup-input" style="display: none;">
                                <option value="5">From Balance on Account</option>
                            </select>
                            <select id="convert-option" class="form-control makeup-input">
                                <option value="1">Cash drop off in store</option>
                                <option value="2">Bank transfer</option>
                                <!-- <option value="credit card">Credit card</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 col-md-4 offset-md-1">
                            <label>Delivery Option</label>
                        </div>
                        <div class="col-7 col-md-7">
                            <select id="delivery-option" class="form-control makeup-input">
                                <option value="">Select method</option>
                                {{-- <option value='1'>Delivery</option> --}}
                                <option value='2'>Pick up in store</option>
                                <option value='3'>Add to storage</option>
                            </select>
                        </div>
                    </div>
                    <div class="row shipping-fedex shipping" style="display: none;">
                        <div class="col-5 col-md-4 offset-md-1">
                            <br>
                            <img class="fedex-logo" src='/imgs/fedex-logo.png' alt="FeDex">
                        </div>
                        <div class="col-7 col-md-7">
                            <select name="fedex-shipping" id="trigger-fedex-convert" class="form-control makeup-input">
                                <option value="">Select Fedex Service</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <br><br><br>
                            <button type="submit" name="add-to-cart"
                                class="single_add_to_cart_button-dark-green button pay-convert"
                                data-id="product_item->get_id() >" data-weight="$number_weight?">CONFIRM PAYMENT!</button>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog"
            aria-labelledby="confirmation-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="confirmation-modal-label">Product added to convert!</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-7">
                                <span class="color-gold">Total weight added to convert:</span>
                            </div>
                            <div class="col-5">
                                <span class="total-weight-counter text-bold color-yellow"></span><span
                                    class="text-bold color-yellow">/oz</span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-7">
                                <span class="color-gold">Weight Remaining:</span>
                            </div>
                            <div class="col-5">
                                <span class="remaining-weight-counter text-bold color-yellow"></span><span
                                    class="text-bold color-yellow">/oz</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn makeup-btn-dark-green" data-bs-dismiss="modal"
                            data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
