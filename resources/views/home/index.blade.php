@extends('header.index')

@push('styles')

@endpush

@push('scripts')
    <script type="text/javascript">
        var end = @json(time()) * 1000;
        var rate = @json($rate);
        var currency = @json($currency);
        var prices = @json($metalprices);
    </script>
@endpush

@section('content')
    @php
        $metals = [1183 => 'Gold', 1677 => 'Silver', 1681 => 'Platinum', 1682 => 'Palladium'];
    @endphp

    @include('home.banners')

    <div class="d-block d-md-none">
        @include('home.prices')
    </div>

    @include('home.section2')

    @include('home.section3')

    @include('home.products')

    @include('home.section4')

    @include('home.section5')

    @include('home.section6')


    {{-- <div class="d-none d-md-block"> --}}
    @include('home.benefits')
    {{-- </div> --}}

    @include('home.section7')

    @include('home.section8')

    @include('home.news')

    @include('home.section9')





    {{-- <div class="slider-section">
        <div class="page-container container home-container">
            @include('home.banner-slider')

            <div class="d-none d-md-block pb-5">
                <div class="g-0">
                    @include('home.live-quotes')
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="page-container container home-container">

        <div class="d-block d-md-none">
            @include('home.prices')
        </div>


        @include('home.info')

    </div> --}}

    {{-- @include('home.signup') --}}

    {{-- <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg search-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Search</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="searchInput" class="form-label">Enter your search query:</label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search here...">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
