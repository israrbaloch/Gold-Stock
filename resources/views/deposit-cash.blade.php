@extends('header.index')

@push('styles')
    <link href="{{ URL::to('/') }}/css/deposit-cash.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/deposit-cash.js?ver=1.2.0"></script>
@endpush

@section('content')
    <div class="page-container container">
        <div id="confirmation-modal" class="modal" data-href="/funds">
            <div class="modal-header">
                <h5 class="modal-title">Deposit</h5>
                <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please, review your email to confirm the withdrawal</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-dismiss="modal">Done</button>
            </div>
        </div>
        <div class="title-page-1 text-center">DEPOSIT</div>
        <div class="row mobile-title d-md-none"
            style="background-image: url('/img/deposit-bar-mob.png'); background-repeat: no-repeat;background-size:contain;background-position: right;">
            <div class="text-left text-bold col-7 balance-title-mobile color-dark-green">Current balance</div>
            <div class="text-right text-bold col-5 balance-total-mobile color-dark-green">
                <?= number_format($userBalance['total'], 2) ?> <?= strtoupper($userBalance['currency']) ?></div>
        </div>
        <div class="row main-cont"
            style="background-image: url('/img/form-bg.png'); background-repeat: no-repeat;background-size:contain;">
            <div class="col-12 col-md-7">
                <div id="imaginary_container">
                    <br class="d-none d-md-block"><br class="d-none d-md-block">
                    <div class="row">
                        <div class="col-4 col-md-4 offset-md-1">
                            <label>Deposit Option</label>
                        </div>
                        <div class="col-8 col-md-7">
                            <select id="deposit-option"class="form-control makeup-input">
                                <option value="">Select Deposit Option</option>
                                <option value="1">Cash drop off in store</option>
                                <option value="2">Bank transfer</option>
                                <option value="3">Credit card</option>
                                <option value="4">Pay/Pal</option>
                            </select>
                        </div>
                    </div>
                    <div class="row deposit-value-row">
                        <div class="col-4 col-md-4 offset-md-1">
                            <label>Quantity</label>
                        </div>
                        <div class="col-8 col-md-7">
                            <input id="deposit-value" type="number" class="form-control makeup-input" placeholder=""
                                style="width: 100%" data-available="">
                            <div class="wd-error" style="display: none;">wrong value</div>
                            <div class="wd-error-max" style="display: none;">Deposit amount cannot be higher than 3000</div>
                            <div class="wd-error-min" style="display: none;">Deposit amount must be at least 10</div>
                        </div>
                    </div>
                    <div class="row account-numb-row">
                        <div class="col-4 col-md-4 offset-md-1">
                            <label>account #</label>
                        </div>
                        <div class="input-group stylish-input-group col-8 col-md-7" id="account-number-box">
                            <input id="account-number" type="number"
                                class="form-control makeup-input-clear text-right text-md-left"
                                style="margin-top: 10px; width: 100%" value="{{ $account->number }}" disabled>
                            <div class="sp-style" style="font-size: 14px; text-align: left; width: 100%;">Please include
                                this account # when sending payment</div>
                        </div>
                    </div>
                </div>
                <br>

                <div id="bank-transfer-box" class="col-12 col-md-11 offset-md-1">
                    <?php
                if($userBalance['currency'] == 'USD'){
            ?>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Beneficiary : </strong><span
                            class="col-5 text-right text-md-left">Gold Stock Canada Inc</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Bank Name: </strong><span class="col-5 text-right text-md-left">Bank
                            of Montreal</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Bank Address: </strong> <span
                            class="col-5 text-right text-md-left">3993 HWY 7 Markham Ontario L3R 5M6</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Account Number: </strong> <span
                            class="col-5 text-right text-md-left">4754-443</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Transit Number: </strong> <span
                            class="col-5 text-right text-md-left">001 25922</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Swift Code: </strong> <span
                            class="col-5 text-right text-md-left">BOFMCAM2</span>
                    </div>
                    <?php
                } elseif($userBalance['currency'] == 'CAD'){
            ?>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Beneficiary : </strong><span
                            class="col-5 text-right text-md-left">Gold Stock Canada Inc</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Bank Name: </strong><span class="col-5 text-right text-md-left">Bank
                            of Montreal</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Bank Address: </strong> <span
                            class="col-5 text-right text-md-left">3993 HWY 7 Markham Ontario L3R 5M6</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Account Number: </strong> <span
                            class="col-5 text-right text-md-left">1964-753</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Transit Number: </strong> <span
                            class="col-5 text-right text-md-left">001 25922</span>
                    </div>
                    <div class="additional-listing row g-0">
                        <strong class="col-7 text-left">Swift Code: </strong> <span
                            class="col-5 text-right text-md-left">BOFMCAM2</span>
                    </div>
                    <?php
                }
            ?>
                </div>
                <div id="store-pickup-box" class="col-12 col-md-11 offset-md-1">
                    <div><span style="font-weight: bold;">Operations days:</span> <span>Monday - Friday</span></div>
                    <div><span style="font-weight: bold;">Operations time:</span> <span>9am - 5pm</span></div>
                </div>
                <div class="col-12 col-md-4 offset-md-5">
                    <button id="deposit-btn" type="button" class="btn makeup-btn-dark-green"
                        data-cash="{{ $userBalance['currency'] }}">Deposit</button>
                </div>
                <div class="d-md-none">
                    <br><br><br><br>
                </div>
            </div>
            <div class="d-none d-md-block col-md-5">
                <div class="row">
                    <div class="text-right text-bold col-12 balance-title color-dark-green"
                        style="background-image: url('/img/highlight.png'); background-repeat: no-repeat;background-size:contain;background-position: right;">
                        Current balance</div>
                    <div class="text-right text-bold col-12 balance-total">
                        <i><?= number_format($userBalance['total'], 2) ?> <?= strtoupper($userBalance['currency']) ?></i>
                    </div>
                </div>
            </div>
            <input type="hidden" id="user_id" value=" {{ $userId }} ">
        </div>
    </div>
@endsection
