@extends('admin.layout')

@section('css')
    <link rel="stylesheet" href="{{ mix('css/admin.order.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/admin-custom.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
@endsection

@section('body')
    @include('header.utils')


    <div class="container-fluid">

        <div class="order-details">
            <div class="col-lg-12 row col-md-12">
                <div class="card">
                    <div class="header card-header">
                        <h5>Order {{ $productOrder->orderid }}</h5>
                    </div>
                    <div class="card-body-details">
                        <form action="{{ route('admin.orders.products.update-order-products', $productOrder->id) }}"
                            method="POST">
                            @csrf
                            @method('POST')

                            <div class="product-form-container">
                                <div id="product-form-container">
                                    @foreach ($currentProducts as $product)
                                    @php
                                        // dd($product);
                                    @endphp
                                        <div class="row product-row">
                                            <div class="form-group col-lg-3">
                                                <label for="product_ids">Name</label>
                                                <select class="form-control select2" name="product_ids[]">
                                                    @foreach ($allProducts as $availableProduct)
                                                        <option value="{{ $availableProduct->id }}" {{ $availableProduct->id == $product->id ? 'selected' : '' }}>
                                                            {{ $availableProduct->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group col-lg-2">
                                                <label for="weight">Weight</label>
                                                <input type="text" class="form-control weight" name="weight[]"
                                                    value="{{ $product->weight }}" placeholder="Weight">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="price">Price</label>
                                                <input type="text" class="form-control price product_price" name="price[]"
                                                    value="{{ $product->price }}" placeholder="Unit Price">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" class="form-control quantity" name="quantity[]"
                                                    value="{{ $product->quantity }}" placeholder="Quantity">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label for="total_price">Sub-Total</label>
                                                <input type="text" class="form-control price total_price" name="total_price[]"
                                                    value="{{ $product->price * $product->quantity }}"
                                                    placeholder="Total Price" readonly>
                                            </div>

                                            <div class="col-lg-1 d-flex">
                                                <button type="button" class="remove-product-btn">
                                                    <i class="far fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" id="add-product-btn" class="add-product-btn">Add Product</button>

                            </div>



                            <hr>

                            <div>
                                <div class="form-group col-lg-6 d-flex align-items-center">
                                    <input type="checkbox" class="mr-2 my-auto form-check" name="send_approval" value="1" id="send_approval">
                                    <label for="send_approval" class="mb-0">
                                        Ask for modification approval from user
                                    </label>
                                </div>
                            </div>

                            {{-- cancel, update buttons --}}
                            <div class="row pull-right">
                                <div class="col-lg-12">
                                    <a href="{{ route('admin.orders.products.view', $productOrder->id) }}"
                                        class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('javascript')
    <script src="{{ asset('js/admin/order.js') }}"></script>
    <script>
        $(document).ready(function() {
            // add product
            $('#add-product-btn').click(function() {
                var productFormContainer = $('#product-form-container');
                var productRow = $('.product-row').first().clone();
                productRow.find('input').val('');
                productFormContainer.append(productRow);

                // remove select2 from cloned row and add it again to avoid select2 conflict
                productRow.find('.select2').parent().find('.select2-container').remove();
                // remove select2-hidden-accessible attribute
                productRow.find('.select2').removeAttr('data-select2-id').removeClass('select2-hidden-accessible').next()
                    .remove();

                // add select2
                productRow.find('.select2').select2({
                    placeholder: 'Select Product',
                });

                // select the first option
                productRow.find('.select2').val('').trigger('change');
            });

            // remove product
            $(document).on('click', '.remove-product-btn', function() {
                $(this).closest('.product-row').remove();
            });

            // on change of price or quantity
            $(document).on('change keyup', '.product_price, .quantity', function() {
                var price = $(this).closest('.product-row').find('.product_price').val();
                var quantity = $(this).closest('.product-row').find('.quantity').val();
                var totalPrice = price * quantity;
                $(this).closest('.product-row').find('.total_price').val(totalPrice);
            });

            // on change the product
            $(document).on('change', '.select2', function() {
                var selectedProduct = $(this).val();
                var productRow = $(this).closest('.product-row');
                var weight = productRow.find('.weight');
                var price = productRow.find('.product_price');
                var quantity = productRow.find('.quantity');
                var totalPrice = productRow.find('.total_price');

                // get the product details
                $.ajax({
                    url: "{{ route('admin.orders.products.get-product-details') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: selectedProduct
                    },
                    success: function(response) {
                        weight.val(response.weight);
                        price.val(response.price);
                        quantity.val(1);
                        totalPrice.val(response.price);
                    }
                });
            });
        });
    </script>
@endsection
