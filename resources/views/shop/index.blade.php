@extends('header.index')

@section('extratitle')
    Shop
@endsection

@push('styles')
    <link href="{{ URL::to('/') }}/css/products.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        const productsPage = @json($products);
    </script>
    <script src="{{ mix('js/shop/shop.js') }}"></script>
@endpush

@php
    // $products = request()->has('sort')
    //     ? (request()->sort == 'price-asc'
    //         ? $products->sortBy('real_price')
    //         : $products->sortByDesc('real_price'))
    //     : $products;
@endphp


@section('content')
@include('shop.mega-menu')

    <div class="page-container container shop-container main pt-0">
        {{-- @include('shop.title') --}}
        <div class="row">
            @include('shop.filter')

            <div class="col-md-10">
                @include('shop.sort')
                @include('shop.products')
                @include('shop.pagination')
            </div>
        </div>
    </div>
@endsection
