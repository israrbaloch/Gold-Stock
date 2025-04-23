@foreach ($reviews as $review)
    <div class="review pt-4 {{ $loop->last ? 'border-0 pb-0' : '' }}">
        <div class="d-flex">
            <div class="d-flex align-items-center me-3">
                <img src="/img/userprofile-avatar.png" alt="User"
                    style="width: 50px; height: 50px; border-radius: 50%;">
            </div>
            <div>
                <div class="d-flex mb-1">
                    <h5 class="my-auto me-3">{{ $review->user->name }}</h5>
                    <small class="text-muted my-auto">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                <div class="mb-2">
                    @php $rating = $review->rating; @endphp

                    @for ($j = 0; $j < 5; $j++)
                        @if ($j < $rating)
                            <i class="fas fa-star rating-star"></i>
                        @else
                            <i class="far fa-star rating-star"></i>
                        @endif
                    @endfor
                </div>
                <p>{{ $review->review }}</p>
            </div>
        </div>
    </div>
@endforeach

<div class="mt-0 d-flex justify-content-center shop-container" id="pagination-container">
    @if ($reviews->hasPages())
        <div class="row g-0 pagination mt-0 pagination-links ms-auto">
            {{ $reviews->links('pagination::default') }}
        </div>
    @endif
</div>
