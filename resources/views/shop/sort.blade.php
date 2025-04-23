<div id="up-filters" class="up-filters d-block d-none d-md-block">
    <div class="row">

        {{-- <div class="col-md-4 ps-0">
            <form action="{{ route('shop') }}" method="get" class="sort-container">
                <span class="label mb-0 ms-2">Producer</span>
                <input type="search" id="producer" name="producer" class="filter form-control" placeholder="Search Producer"
                    value="{{ request()->query('producer') }}">
            </form>
            <div id="producer-suggestions" class="suggestions"></div>
        </div> --}}

        <div class="col-md-4 ps-0">
            <form action="{{ route('shop') }}" method="get" class="sort-container">
                <span class="label mb-0 ms-2">Producer</span>
                <select id="producer1" name="producer" class="sort">
                    <option value="">Select Producer</option>
                    <option value="Royal Canadian mint" {{ request()->query('producer') == 'Royal Canadian mint' ? 'selected' : '' }}>Royal Canadian mint</option>
                    <option value="Valcambi suisse" {{ request()->query('producer') == 'Valcambi suisse' ? 'selected' : '' }}>Valcambi suisse</option>
                    <option value="Ontario mint" {{ request()->query('producer') == 'Ontario mint' ? 'selected' : '' }}>Ontario mint</option>
                    <option value="United states mint" {{ request()->query('producer') == 'United states mint' ? 'selected' : '' }}>United states mint</option>
                    <option value="Pamp suisse" {{ request()->query('producer') == 'Pamp suisse' ? 'selected' : '' }}>Pamp suisse</option>
                    <option value="Asahi refining" {{ request()->query('producer') == 'Asahi refining' ? 'selected' : '' }}>Asahi refining</option>
                    <option value="Johnson mathey" {{ request()->query('producer') == 'Johnson mathey' ? 'selected' : '' }}>Johnson mathey</option>
                    <option value="Perth mint" {{ request()->query('producer') == 'Perth mint' ? 'selected' : '' }}>Perth mint</option>
                    <option value="Sunshine mint" {{ request()->query('producer') == 'Sunshine mint' ? 'selected' : '' }}>Sunshine mint</option>
                    <option value="Rand refinery" {{ request()->query('producer') == 'Rand refinery' ? 'selected' : '' }}>Rand refinery</option>
                    <option value="Royal mint" {{ request()->query('producer') == 'Royal mint' ? 'selected' : '' }}>Royal mint</option>
                    <option value="Austrian mint" {{ request()->query('producer') == 'Austrian mint' ? 'selected' : '' }}>Austrian mint</option>
                </select>
            </form>
        </div>
        
    
    
        <div class="sort-container col-md-6 ms-auto">
            <span class="label">Sort by</span>
            <select id="sort1" class="sort">
                <option value="best-match" {{ request()->has('sort') && request()->sort == 'best-match' ? 'selected' : '' }}>Best Match</option>
                <option value="price-asc" {{ request()->has('sort') && request()->sort == 'price-asc' ? 'selected' : '' }}>Price Low-High</option>
                <option value="price-desc" {{ request()->has('sort') && request()->sort == 'price-desc' ? 'selected' : '' }}>Price High-Low</option>
            </select>
        </div>
    </div>
    {{-- <div class=">
        <button type="button" onclick="reloadWithParams();" id="clear-filters"
            class="btn btn-clear-filters">
            CLEAR FILTERS
        </button>
    </div> --}}
</div>