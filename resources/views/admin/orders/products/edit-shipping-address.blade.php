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
                        <form action="{{ route('admin.orders.products.update-shipping-address', $productOrder->id) }}"
                            method="POST">
                            @csrf
                            @method('POST')

                            <div class="row">
                                {{-- Address 1 --}}
                                <div class="form-group col-lg-3 @error('shipping_address_1') has-error @enderror">
                                    <label for="shipping_address_1">Address 1</label>
                                    <input type="text" class="form-control" id="shipping_address_1" name="shipping_address_1"
                                        value="{{ $productOrder->shipping_address_1 }}">
                                    @error('shipping_address_1')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Address 2 --}}
                                <div class="form-group col-lg-3 @error('shipping_address_2') has-error @enderror">
                                    <label for="shipping_address_2">Address 2</label>
                                    <input type="text" class="form-control" id="shipping_address_2" name="shipping_address_2"
                                        value="{{ $productOrder->shipping_address_2 }}">
                                    @error('shipping_address_2')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- City --}}
                                <div class="form-group col-lg-3 @error('shipping_city') has-error @enderror">
                                    <label for="shipping_city">City</label>
                                    <input type="text" class="form-control" id="shipping_city" name="shipping_city"
                                        value="{{ $productOrder->shipping_city }}">
                                    @error('shipping_city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Country --}}
                                <div class="form-group col-lg-3 @error('shipping_country') has-error @enderror">
                                    <label for="shipping_country">Country</label>
                                    <input type="text" class="form-control" id="shipping_country" name="shipping_country"
                                        value="{{ $productOrder->shipping_country }}">
                                    @error('shipping_country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                {{-- Postal Code --}}
                                <div class="form-group col-lg-3 @error('shipping_postal_code') has-error @enderror">
                                    <label for="shipping_postal_code">Postal Code</label>
                                    <input type="text" class="form-control" id="shipping_postal_code" name="shipping_postal_code"
                                        value="{{ $productOrder->shipping_postal_code }}">
                                    @error('shipping_postal_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Province --}}
                                <div class="form-group col-lg-3 @error('shipping_province') has-error @enderror">
                                    <label for="shipping_province">Province</label>
                                    <input type="text" class="form-control" id="shipping_province" name="shipping_province"
                                        value="{{ $productOrder->shipping_province }}">
                                    @error('shipping_province')
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
