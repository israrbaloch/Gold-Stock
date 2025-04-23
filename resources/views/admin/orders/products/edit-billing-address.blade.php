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
                        <form action="{{ route('admin.orders.products.update-billing-address', $productOrder->id) }}"
                            method="POST">
                            @csrf
                            @method('POST')

                            <div class="row">
                                {{-- Billing Address Line 1 --}}
                                <div class="form-group col-lg-3 @error('billing_address_1') has-error @enderror">
                                    <label for="billing_address_1">Billing Address 1</label>
                                    <input type="text" class="form-control" id="billing_address_1"
                                        name="billing_address_1" value="{{ $productOrder->billing_address_1 }}">
                                    @error('billing_address_1')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Billing Address Line 2 --}}
                                <div class="form-group col-lg-3 @error('billing_address_2') has-error @enderror">
                                    <label for="billing_address_2">Billing Address 2</label>
                                    <input type="text" class="form-control" id="billing_address_2"
                                        name="billing_address_2" value="{{ $productOrder->billing_address_2 }}">
                                    @error('billing_address_2')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Billing City --}}
                                <div class="form-group col-lg-3 @error('billing_city') has-error @enderror">
                                    <label for="billing_city">City</label>
                                    <input type="text" class="form-control" id="billing_city" name="billing_city"
                                        value="{{ $productOrder->billing_city }}">
                                    @error('billing_city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Billing Country --}}
                                <div class="form-group col-lg-3 @error('billing_country') has-error @enderror">
                                    <label for="billing_country">Country</label>
                                    <input type="text" class="form-control" id="billing_country" name="billing_country"
                                        value="{{ $productOrder->billing_country }}">
                                    @error('billing_country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                {{-- Billing Postal Code --}}
                                <div class="form-group col-lg-3 @error('billing_postal_code') has-error @enderror">
                                    <label for="billing_postal_code">Postal Code</label>
                                    <input type="text" class="form-control" id="billing_postal_code"
                                        name="billing_postal_code" value="{{ $productOrder->billing_postal_code }}">
                                    @error('billing_postal_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Billing Province --}}
                                <div class="form-group col-lg-3 @error('billing_province') has-error @enderror">
                                    <label for="billing_province">Province</label>
                                    <input type="text" class="form-control" id="billing_province" name="billing_province"
                                        value="{{ $productOrder->billing_province }}">
                                    @error('billing_province')
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
