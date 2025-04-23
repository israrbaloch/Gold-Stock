@extends('header.index')

@section('extratitle')
    Payment Types
@endsection

@push('styles')
    <style>
        .payment-methods {
            text-align: center;
            padding: 40px 0;
        }

        .payment-methods h1 {
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            justify-items: center;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 20px;
            width: 90%;
            cursor: pointer;
        }

        .payment-option .icon-container {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            box-shadow: 4px 4px 20px 0px #E0E0E0;
            transition: box-shadow 0.3s, transform 0.3s;
        }

        .payment-option:hover .icon-container {
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(-3px);
        }

        .payment-option i {
            font-size: 28px;
            color: #7C7E85;
        }

        .payment-option p {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
            color: #1E2026;
        }
    </style>
@endpush

@section('content')
    <div class="page-container container py-5">
        <div class="title-page-1 text-center">Payment Types</div>
        <div class="payment-methods">
            <h1>Payment Methods</h1>
            <div class="payment-options col-lg-8 col-md-12 col-12 mx-auto">
                <div class="payment-option" data-method="Credit Card">
                    <div class="icon-container">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <p>Credit Card: 3.75% Fee</p>
                </div>
                <div class="payment-option" data-method="Personal Cheque">
                    <div class="icon-container">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <p>Personal Cheque: $0 Fee</p>
                </div>
                <div class="payment-option" data-method="E Transfer">
                    <div class="icon-container">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <p>E Transfer: $0 Fee</p>
                </div>
                <div class="payment-option" data-method="Cash">
                    <div class="icon-container">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <p>Cash (in store): $0 Fee</p>
                </div>
                <div class="payment-option" data-method="Bank Wire">
                    <div class="icon-container">
                        <i class="fas fa-university"></i>
                    </div>
                    <p>Bank Wire: $0 Fee</p>
                </div>
                <div class="payment-option" data-method="Bill Payment">
                    <div class="icon-container">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <p>Bill Payment: $0 Fee</p>
                </div>
                <div class="payment-option" data-method="Debit Interac">
                    <div class="icon-container">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <p>Debit Interac (in store): $0 Fee</p>
                </div>
            </div>
        </div>

        <!-- Input Popup -->
        <div class="modal fade" id="inputPopup" tabindex="-1" aria-labelledby="inputPopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputPopupLabel">Enter Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="detailsForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="orderNumber" class="form-label">Order Number</label>
                                <input type="text" class="form-control" id="orderNumber" placeholder="Enter order number" required>
                            </div>
                            <button type="submit" class="button px-5 mt-4 ms-auto">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Popup -->
        <div class="modal fade" id="detailsPopup" tabindex="-1" aria-labelledby="detailsPopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsPopupLabel">Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="details"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let selectedMethod = '';

            $('.payment-option').on('click', function() {
                selectedMethod = $(this).data('method');
                const inputPopup = new bootstrap.Modal(document.getElementById('inputPopup'));
                inputPopup.show();
            });

            $('#detailsForm').on('submit', function(e) {
                e.preventDefault();
                const email = $('#email').val();
                const orderNumber = $('#orderNumber').val();

                $('#details').html(`
                    <p><strong>Payment Method:</strong> ${selectedMethod}</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Order Number:</strong> ${orderNumber}</p>
                `);

                const inputPopup = bootstrap.Modal.getInstance(document.getElementById('inputPopup'));
                inputPopup.hide();

                const detailsPopup = new bootstrap.Modal(document.getElementById('detailsPopup'));
                detailsPopup.show();
            });
        });
    </script>
@endpush
