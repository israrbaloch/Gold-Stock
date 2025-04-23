<div class="search-results">
    <div class="search-results-container">
        <div class="search-results-body">
            <div class="search-results-list">

                @foreach ($products as $item)
                    <div class="search-results-item">
                        <a href="{{ url('product/' . $item->id . '/' . $item->slug) }}">
                            {{ Str::limit($item->name, 50, '...') }}
                        </a>
                    </div>
                @endforeach


                @foreach ($news as $item)
                    <div class="search-results-item">
                        <a href="{{ url('news/' . $item->slug) }}">
                            {{ Str::limit($item->title, 80, '...') }}
                        </a>
                    </div>
                @endforeach

                @foreach ($blogs as $item)
                    <div class="search-results-item">
                        <a href="{{ url('blog/' . $item->slug) }}">
                            {{ Str::limit($item->title, 80, '...') }}
                        </a>
                    </div>
                @endforeach

                @if (count($products) == 0 && count($news) == 0 && count($blogs) == 0)
                    <div class="search-results-item text-center">
                        No results found
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
