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
                        <form action="{{ route('admin.orders.products.update-order-customer-details', $productOrder->id) }}"
                            method="POST">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="form-group col-lg-3
                                @error('first_name')
                                    has-error
                                @enderror">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ $productOrder->first_name }}">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                {{-- Last Name --}}
                                <div
                                    class="form-group col-lg-3
                                @error('last_name')
                                has-error
                                @enderror">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ $productOrder->last_name }}">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            
                                <div
                                    class="form-group col-lg-3
                                @error('email') has-error @enderror">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $productOrder->email }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div
                                    class="form-group col-lg-3
                                @error('phone') has-error @enderror">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $productOrder->phone }}">
                                    @error('phone')
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
