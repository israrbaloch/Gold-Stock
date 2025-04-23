@extends('header.index')

@push('styles')
    <link href="{{ URL::to('/') }}/css/deposit-coin.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/deposit-coin.js?ver=1.2.0"></script>
@endpush

@section('content')
    <div class="page-container container">
        <div class="coins-container" style="margin-top: 20px;">
            <div id="address-modal" class="modal" data-href="/funds">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center font-bold">

                        <h5 class="modal-title"> Deposit Address</h5>
                    </div>
                    <div class="qr-container">
                        <img src="image" style="height: 200px; margin: 0 auto;" />
                        <div class="scan-message">Scan QR code</div>
                        <a href="#" class="save-qr btn btn-primary">Save QR Code</a>
                    </div>
                </div>
            </div>
            <div class="title-page-1 text-center"></div>
            <br>
            <div class="row">
                <div class="col-12 first-container">
                    You may deposit metals in branch or ship them into our facility
                    <br>
                    <br>
                    <div id="dib-trigger" class="color-dark-green text-underline pointer">DEPOSIT IN BRANCH</div>
                    <br>
                    <div id="si-trigger" class="color-dark-green text-underline pointer">SHIP IN</div>
                    <br>
                    <div id="dib" class="bg-section" style="display: none;">
                        Gold Stock Canada Inc. <br>
                        3rd Floor - 55 Dundas St East <br>
                        Toronto, Ontario m5B-1C6 <br>
                        Monday - Friday 9am - 6pm <br>
                        416 504 4653
                    </div>
                    <div id="si" class="bg-section" style="display: none;">
                        Shipping & Recieving <br>
                        Gold Stock Canada Inc. <br>
                        3rd Floor - 55 Dundas St East <br>
                        Toronto, Ontario m5B-1C6 <br>
                        <br>
                        *Please include the account number and your full name as it is on your account.
                    </div>
                </div>
            </div>
            <br> <br>

            <div id="action-buttons">
                <div class="row">

                </div>
            </div>

        </div>
    </div>
@endsection
