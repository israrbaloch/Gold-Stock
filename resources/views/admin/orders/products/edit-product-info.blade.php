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
                        <form action="{{ route('admin.orders.products.update-product-info', $productOrder->id) }}"
                            method="POST">
                            @csrf
                            @method('POST')

                            <div class="row">
                                {{-- Moneris Order ID --}}
                                <div class="form-group col-lg-3 @error('moneris_order_id') has-error @enderror">
                                    <label for="moneris_order_id">Moneris Order ID</label>
                                    <input type="text" class="form-control" id="moneris_order_id" name="moneris_order_id"
                                        value="{{ $productOrder->moneris_order_id }}">
                                    @error('moneris_order_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Moneris Ticket --}}
                                <div class="form-group col-lg-3 @error('moneris_ticket') has-error @enderror">
                                    <label for="moneris_ticket">Moneris Ticket</label>
                                    <input type="text" class="form-control" id="moneris_ticket" name="moneris_ticket"
                                        value="{{ $productOrder->moneris_ticket }}">
                                    @error('moneris_ticket')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Currency --}}
                                <div class="form-group col-lg-3 @error('currency') has-error @enderror">
                                    <label for="currency">Currency</label>
                                    <select name="currency" id="currency" class="form-control" disabled>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->code }}" @if ($currency->code == $productOrder->currency) selected @endif>
                                                {{ $currency->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Status --}}
                                <div class="form-group col-lg-3 @error('status') has-error @enderror">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach ($orderStatuses as $key => $orderStatus)
                                            <option value="{{ $key }}" @if ($key == $productOrder->status_id) selected @endif>
                                                {{ $orderStatus }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                {{-- Shipping --}}
                                <div class="form-group col-lg-3 @error('shipping') has-error @enderror">
                                    <label for="shipping_option">Shipping</label>
                                    <select name="shipping_option" id="shipping_option" class="form-control">
                                        @foreach ($shippingOptions as $shippingOption)
                                            <option value="{{ $shippingOption->id }}" @if ($shippingOption->id == $productOrder->shipping_option_id) selected @endif>
                                                {{ $shippingOption->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shipping_option')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                {{-- Shipping Status --}}
                                <div class="form-group col-lg-3 @error('shipping_status') has-error @enderror">
                                    <label for="shipping_status">Shipping Status</label>
                                    <select name="shipping_status" id="shipping_status" class="form-control">
                                        <option value="">Select Shipping Status</option>
                                        @foreach ($shippingStatuses as $key => $shippingStatus)
                                            <option value="{{ $key }}" @if ($key == $productOrder->shipping_status_id) selected @endif>
                                                {{ $shippingStatus }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shipping_status')
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
