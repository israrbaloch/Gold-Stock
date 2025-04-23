@extends('voyager::master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin/admin-custom.css') }}?v=1">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
@endsection

@section('content')
    @include('header.utils')
    <div class="container-fluid">

        <div class="d-flex mt-3">
            <h4 class="heading">Product Order</h4>

            {{-- create new order button --}}
            <form class="ml-auto">
                <a href="{{ route('admin.orders.products.create') }}" class="btn btn-primary">+ Add New Order</a>
            </form>
        </div>

        {{-- search, date, payment status, shipping status --}}


        <div class="row mb-3">
            <div class="col-md-3">
                <label for="search">Search</label>
                <input type="text" id="search" class="form-control table-search"
                    placeholder="Search  by Name, Email, Order">
            </div>

            {{-- date --}}
            <div class="col-md-3">
                <label for="date-filter">Date</label>
                <input type="date" id="date-filter" class="form-control table-search date-filter">
            </div>

            <div class="col-md-3 pull-right">
                <label for="payment-status-filter">Order Status</label>
                <select id="payment-status-filter" class="form-control select2" multiple>
                    {{-- 1, 2 --}}
                    @foreach ($paymentStatuses as $key => $status)
                        <option value="{{ $key }}">{{ $status }}</option>
                    @endforeach
                    {{-- <option value="1">Pending</option>
                    <option value="2">Paid</option> --}}
                </select>
            </div>
            <div class="col-md-3 pull-right">
                <label for="shipping-status-filter">Shipping Status</label>
                <select id="shipping-status-filter" class="form-control select2" multiple>
                    @foreach ($shippingStatuses as $key => $status)
                        <option value="{{ $key }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="bg-white custom-dataTable">
            <table class="table table-bordered- border-top-" id="orders-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>User</th>
                        <th>Shipping</th>
                        <th>Shipping Status</th>
                        <th>Currency</th>
                        <th>Status</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection


@push('javascript')
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.orders.products.data') }}',
                    data: function(d) {
                        d.payment_status = $('#payment-status-filter').val();
                        d.shipping_status = $('#shipping-status-filter').val();
                    }
                },
                // searching: false,
                lengthMenu: [
                    [13, 26, 50, 100, -1],
                    [13, 26, 50, 100, "All"]
                ],
                language: {
                    // info: "<b>_START_ - _END_</b> (of _TOTAL_)"
                    info: "<b>Sowing _START_ to _END_ of _TOTAL_ orders</b>"
                },
                // do not show menu
                dom: 'Bfrtip',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'shipping_option',
                        name: 'shipping_option'
                    },
                    {
                        data: 'shipping_status',
                        name: 'shipping_status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'currency',
                        name: 'currency'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status',
                        orderable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
                initComplete: function() {},
            });


            // ext
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: false,
                width: '100%'
            });

            // Search Filter
            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Date Filter
            $('#date-filter').on('change', function() {
                table.columns(6).search(this.value).draw();
            });

            // // Shipping Status Filter
            $('#shipping-status-filter').on('change', function() {
                var selectedStatuses = $(this).val();
                table.columns(3).search(selectedStatuses ? selectedStatuses.join('|') : '', true, false)
                    .draw();
            });

            // Payment Status Filter
            $('#payment-status-filter').on('change', function() {
                var selectedStatuses = $(this).val();
                table.columns(5).search(selectedStatuses ? selectedStatuses.join('|') : '', true, false)
                    .draw();
            });

            $('.select2').on('change', function() {
                const $selectionContainer = $(this).siblings('.select2-container').find(
                    '.select2-selection__rendered');
                const items = $selectionContainer.children('.select2-selection__choice');
                const maxVisible = 2; // Number of visible items before showing "+N"

                if (items.length > maxVisible) {
                    // Hide extra items
                    items.slice(maxVisible).css('display', 'none');

                    // Remove any existing "+N"
                    $selectionContainer.find('.select2-overflow-indicator').remove();

                    // Add "+N" indicator
                    const overflowCount = items.length - maxVisible;
                    $selectionContainer.append(
                        `<li class="select2-overflow-indicator">+${overflowCount}</li>`
                    );
                } else {
                    // Show all items if there's no overflow
                    items.css('display', '');
                    $selectionContainer.find('.select2-overflow-indicator').remove();
                }
            });

            // Pre-trigger filters for initial values
            // $('#shipping-status-filter, #payment-status-filter').trigger('change');
        });
    </script>
@endpush
