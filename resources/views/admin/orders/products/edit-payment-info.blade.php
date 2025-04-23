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
                        <form action="{{ route('admin.orders.products.update-payment-info', $productOrder->id) }}"
                            method="POST">
                            @csrf
                            @method('POST')

                            <div class="row">
                                {{-- Total --}}
                                <div class="form-group col-lg-3 @error('total') has-error @enderror">
                                    <label for="total">Total</label>
                                    <input type="text" class="form-control price" id="total" name="total"
                                        value="{{ $productOrder->total + $shippingFee }}" disabled>
                                    @error('total')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- 10% Deposit --}}
                                <div class="form-group col-lg-3 @error('deposit') has-error @enderror">
                                    <label for="deposit">10% Deposit</label>
                                    <input type="text" class="form-control price" id="deposit" name="deposit"
                                        value="{{ $productOrder->payed - $productOrder->fee }}" disabled>
                                    @error('deposit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- 3.75% Fee --}}
                                <div class="form-group col-lg-3 @error('fee') has-error @enderror">
                                    <label for="fee">3.75% Fee</label>
                                    <input type="text" class="form-control price" id="fee" name="fee"
                                        value="{{ $productOrder->fee }}" disabled>
                                    @error('fee')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Shipping Service --}}
                                <div class="form-group col-lg-3 @error('shipping_service') has-error @enderror">
                                    <label for="shipping_service">Shipping Service</label>
                                    <input type="text" class="form-control price" id="shipping_service" name="shipping_service"
                                        value="{{$shippingFee}}" disabled>
                                    @error('shipping_service')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                {{-- Payed --}}
                                <div class="form-group col-lg-3 @error('payed') has-error @enderror">
                                    <label for="payed">Payed</label>
                                    <input type="text" class="form-control price" id="payed" name="payed"
                                        value="{{ $productOrder->payed }}">
                                    @error('payed')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Outstanding --}}
                                <div class="form-group col-lg-3 @error('outstanding') has-error @enderror">
                                    <label for="outstanding">Outstanding</label>
                                    <input type="text" class="form-control price" id="outstanding" name="outstanding"
                                        value="{{ $productOrder->total + $shippingFee - $productOrder->payed }}" disabled>
                                    @error('outstanding')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            <hr>

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
@endsection
