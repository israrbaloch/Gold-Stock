<div class="page-container container home-container">
    <div class="col-12 desktop-product-slider">
        <div class="d-flex justify-content-between">
            <a href="javascript:void(0)">
                <h2 class="section-title">Reviews</h2>
            </a>
            <div class="d-flex align-items-center mb-5">
                <div class="me-2">
                    <span class="">
                        @for ($j = 0; $j < 5; $j++)
                            @if ($j + 1 <= $rating)
                                <i class="fas fa-star rating-star"></i>
                            @elseif ($j < $rating)
                                <i class="fas fa-star-half-alt rating-star"></i>
                            @else
                                <i class="far fa-star rating-star"></i>
                            @endif
                        @endfor
                    </span>
                    <span>
                        {{ number_format($rating, 1) }}
                    </span>
                </div>
                
                <span>({{ $product->reviews->count() }} Reviews)</span>
            </div>
        </div>

        <div class="reviews mt-2" id="reviews-container">
            {{-- Reviews will be loaded here via AJAX --}}
        </div>
    </div>
</div>
