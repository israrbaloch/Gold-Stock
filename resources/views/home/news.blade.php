<div class="page-container container home-container">
    <div class="market-news my-5">
        <a href="/news">
            <h2>Market News</h2>
        </a>

        <div class="market-news-container col-lg-12">
            @foreach ($news->take(3) as $i => $new)
                <a class="news-container col-lg-4 w-100" href="{{ url('news/' . $new->slug) }}" target="_blank">

                    @if (strlen($new->image) && (str_ends_with($new->image, '.jpg') || str_ends_with($new->image, '.png')))
                        <div class="image" style="background-image: url({{ asset('storage/' . $new->image) }})"></div>
                    @else
                        @php
                            $prev_img = '';
                            do {
                                $img_n = rand(1, 7);
                            } while ($img_n == $prev_img);
                            $srcimage = 'img/news/news-' . $img_n . '.jpg';
                            $prev_img = $img_n;
                        @endphp
                        <img class="image" src="{{ asset($srcimage) }} " alt="News image">
                    @endif
                    <div class="details">
                        <h3>{{ strip_tags($new->title) }}</h3>
                        <div class="description">
                            {{ Str::limit(strip_tags($new->description), 200, '...') }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="allnews">
            <a href="/news">
                More market news
                <i class="fas fa-chevron-right right-chevron"></i>

            </a>
        </div>
    </div>
</div>
