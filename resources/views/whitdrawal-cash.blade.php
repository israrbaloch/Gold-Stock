@extends('header.index')
@php
    $has_two_step = 0;
    $has_email_step = 0;
    $balance = 0;
    foreach ($userBalance['cash'] as $bal) {
        $balance = $bal->currency == $currency ? $bal->total : $balance;
    }
@endphp

@push('styles')
    <link href="{{ URL::to('/') }}/css/withdrawal-cash.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/withdrawal-cash.js?ver=1.2.0"></script>
@endpush

@section('content')
    <div class="page-container container">
        <div id="confirmation-modal" class="modal" data-href="/funds">
            <div class="modal-header">
                <h5 class="modal-title">Withdrawal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please, review your email to confirm the withdrawal</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
            </div>
        </div>
        <div class="title-page-1 text-center">WITHDRAWAL</div>
        <div class="row mobile-title d-md-none"
            style="background-image: url('/img/deposit-bar-mob.png'); background-repeat: no-repeat;background-size:contain;background-position: right;">
            <div class="text-left text-bold col-7 balance-title-mobile color-dark-green">Current balance</div>
            <div class="text-right text-bold col-5 balance-total-mobile color-dark-green"><?= number_format($balance, 2) ?>
                <?= strtoupper($currency) ?></div>
        </div>
        <div class="row main-cont"
            style='background-image: url("/img/form-bg.png"); background-repeat: no-repeat;background-size:contain;'>
            <div class="col-12 col-md-7">
                <div id="imaginary_container">
                    <br class="d-none d-md-block disappear-bank"><br class="d-none d-md-block disappear-bank"><br
                        class="d-none d-md-block disappear-bank">
                    <div class="row help-bank-2">
                        <div class="col-4 offset-md-1">
                            <label>Quantity</label>
                        </div>
                        <div class="col-8 col-md-7">
                            <input id="widthrawal-value" type="number" class="form-control makeup-input" placeholder=""
                                style="width: 100%" data-available="<?= $balance ?>">
                            <div class="wd-error" style="display: none;">wrong value</div>
                            <div class="wd-error-funds" style="display: none;">Insufficient funds</div>
                        </div>
                    </div>
                    <div class="row help-bank-2">
                        <div class="col-4 offset-md-1">
                            <label>Widthrawal Option</label>
                        </div>
                        <div class="col-8 col-md-7">
                            <select id="widthdrawal-option"class="form-control makeup-input">
                                <option value="">Select Widthrawal Option</option>
                                <option value="1">Cash pick up in store</option>
                                <option value="2">Bank transfer</option>
                            </select>
                        </div>
                    </div>

                    <?php if($has_two_step) { ?>
                    <div class="row help-bank-2">
                        <div class="col-4 offset-md-1">
                            <label>google authentication code</label>
                        </div>
                        <div class="col-8 col-md-7">
                            <input name="google-code" id="google-code" type="text" class="form-control makeup-input"
                                style="width: 100%">
                        </div>
                    </div>
                    <input type="hidden" name="email-code" id="email-code" value="0">

                    <?php } elseif($has_email_step) { ?>
                    <div class="row help-bank-2">
                        <div class="col-4 offset-md-1">
                            <label>email authentication code</label>
                        </div>
                        <div class="col-8 col-md-7">
                            <input name="email-code" id="email-code" type="text" class="form-control makeup-input"
                                style="width: 100%">
                        </div>
                    </div>
                    <input type="hidden" name="google-code" id="google-code" value="0">

                    <?php } else { ?>
                    <input type="hidden" name="email-code" id="email-code" value="0">
                    <input type="hidden" name="google-code" id="google-code" value="0">

                    <?php } ?>

                </div>

                <div id="bank-transfer-box" class="col-md-11 offset-md-1">
                    <div class="row g-0 help-bank">
                        <div class="col-4 col-md-3 offset-md-2">
                            <label>Bank name</label>
                        </div>
                        <div class="col-8 col-md-6 offset-md-1">
                            <input id="bank-name" class="form-control makeup-input" placeholder="" style="width: 100%">
                        </div>
                    </div>
                    <div class="row g-0 help-bank">
                        <div class="col-4 col-md-3 offset-md-2">
                            <label>Bank address</label>
                        </div>
                        <div class="col-8 col-md-6 offset-md-1">
                            <input id="bank-address" class="form-control makeup-input" placeholder="" style="width: 100%">
                        </div>
                    </div>
                    <div class="row g-0 help-bank">
                        <div class="col-4 col-md-3 offset-md-2">
                            <label>Account number</label>
                        </div>
                        <div class="col-8 col-md-6 offset-md-1">
                            <input id="account-number" class="form-control makeup-input" placeholder=""
                                style="width: 100%">
                        </div>
                    </div>
                    <div class="row g-0 help-bank">
                        <div class="col-4 col-md-3 offset-md-2">
                            <label>Institution number</label>
                        </div>
                        <div class="col-8 col-md-6 offset-md-1">
                            <input id="institution-number" class="form-control makeup-input" placeholder=""
                                style="width: 100%">
                        </div>
                    </div>
                    <div class="row g-0 help-bank">
                        <div class="col-4 col-md-3 offset-md-2">
                            <label>Transit number</label>
                        </div>
                        <div class="col-8 col-md-6 offset-md-1">
                            <input id="transit-number" class="form-control makeup-input" placeholder=""
                                style="width: 100%">
                        </div>
                    </div>
                </div>
                <div id="store-pickup-box" class="col-md-11 offset-md-1">
                    <div><span style="font-weight: bold;">Operations days:</span> <span>Monday - Friday</span></div>
                    <div><span style="font-weight: bold;">Operations time:</span> <span>9am - 5pm</span></div>
                </div>
                <div class="col-md-4 offset-md-5">
                    <button id="withdraw-btn" type="button" class="btn makeup-btn-dark-green"
                        data-cash="<?= $currency ?>">Withdraw</button>
                </div>
                <div class="d-md-none">
                    <br><br><br><br>
                </div>
            </div>
            <div class="d-none d-md-block col-md-5">
                <div class="row">
                    <div class="text-right col-12 text-bold balance-title color-dark-green"
                        style="background-image: url('/img/highlight.png'); background-repeat: no-repeat;background-size:contain;background-position: right;">
                        Available balance</div>
                    <div class="text-right col-12 text-bold balance-total"><?= number_format($balance, 2) ?>
                        <?= strtoupper($currency) ?></div>
                </div>
            </div>
        </div>
        <br><br>
    </div>
@endsection
