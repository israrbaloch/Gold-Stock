@extends('header.index')

@section('extratitle')
    News
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/latest_news.css') }}">
@endpush

@section('content')
    <div class="main-div">
        <section class="hero-news d-flex justify-content-center align-items-center">
            <img src="img/news-bg.png" alt="Gold Refining News" class="hero-img">
            <div class="overlay"></div>
            <div class="hero-content">
                <h1>Explore the Latest News in Gold Refining</h1>
                <p>With a strong focus on making precious metal investments accessible, we’ve grown into a trusted name in
                    bullion trading and refining, serving jewellers, businesses, and individuals across Canada.</p>
            </div>
        </section>

        <section class="news-section">
            <div class="container">
                <div class="row gx-50">
                    <div class="col-md-8">
                        <h2>Popular News</h2>
                        @foreach ($news as $new)
                            <div class="news-card">
                                <a href="{{ url('/news/' . $new->slug) }}" class="text-white">
                                    <img src="{{ asset('storage/' . $new->image) }}" alt="{{ strip_tags($new->title) }}">
                                    <div class="news-overlay"></div>
                                    <div class="news-content">
                                        <h3>
                                            {{ strip_tags($new->title) }}
                                        </h3>
                                        <p class="d-md-block d-none">
                                            {{ Str::limit(strip_tags($new->description), 270, '...') }}
                                        </p>
                                        <p class="d-block d-md-none">
                                            {{ Str::limit(strip_tags($new->description), 120, '...') }}
                                        </p>
                                        <a href="{{ url('/news/' . $new->slug) }}">Read more...</a>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>

                    <div class="col-md-4">
                        <div class="recent-news">
                            <h3>Recent News</h3>
                            @foreach ($recentNews as $new)
                                <a href="{{ url('/news/' . $new->slug) }}" class="recent-news-link">
                                    <div class="recent-news-card">
                                        <img src="{{ asset('storage/' . $new->image) }}"
                                            alt="{{ strip_tags($new->title) }}">
                                        <div class="news-overlay"></div> <!-- Full image overlay -->
                                        <div class="recent-news-content">
                                            <p>
                                                {{ Str::limit(strip_tags($new->description), 100, '...') }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
