<div id="news-container-home">
    <div class="news">
        @foreach ($news as $i => $new)
            @if (strlen($new->url))
                <a class="news-row @if ($i == 0) show @endif" href="{{ $new->url }}"
                    target="_blank">

                    @if (strlen($new->image) && (str_ends_with($new->image, '.jpg') || str_ends_with($new->image, '.png')))
                        <div class="image" style="background-image: url({{ $new->image }})"></div>
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

                    <div class="background"></div>

                    <div class="details">
                        <h3>{{ strip_tags($new->title) }}</h3>
                        <div class="description">
                            {{ strip_tags($new->description) }}
                        </div>
                        <span class="author">
                            {{ $new->author }}
                        </span>
                        <span class="date">
                            {{ date('d-m-Y', strtotime($new->date)) }}
                        </span>
                        {{-- <a href="{{ $new->url }}">Learn more</a> --}}
                    </div>
                </a>
            @endif
        @endforeach
    </div>

    <div id="news-selector-container" class="selects">
        @foreach ($news as $i => $new)
            @if (strlen($new->url))
                <button type="button" class="dot @if ($i == 0) show @endif"
                    onclick="selectNew({{ $i }})">
                </button>
            @endif
        @endforeach
    </div>
</div>

<script type="text/javascript" src="{{ URL::to('/') }}/js/news.js"></script>
