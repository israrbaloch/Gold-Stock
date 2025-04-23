<div class="mobile-filter-container">
    <div id="filter-open">
        Filter
    </div>
    <div id="up-filters">
        {{-- Producer --}}


        <span class="label">Sort</span>
        <select id="sort" class="sort">
            <option value="best-match">Best Match</option>
            <option value="price-asc">Price Low-High</option>
            <option value="price-desc">Price High-Low</option>
        </select>
    </div>
</div>

<div class="shop-filters col-12 col-md-2">
    <div class="filters">
        <div class="title-container">
            <span class="title">Filter</span>
            <div class="close d-block d-md-none" id="filter-close"></div>
        </div>

        {{-- Availablity (in stock, out of stock) --}}
        <fieldset>
            <h5 class="filter-title">Availability</h5>
            <div class="filter-container">
                <div class="filter">
                    <label class="checkbox">
                        <input type="checkbox" id="in-stock" value="1" name="stock">
                        <label class="label-name" for="in-stock">In Stock</label>
                    </label>
                </div>
                <div class="filter">
                    <label class="checkbox">
                        <input type="checkbox" id="out-of-stock" value="0" name="stock">
                        <label class="label-name" for="out-of-stock">Out of Stock</label>
                    </label>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <h5 class="filter-title">Category</h5>
            <div class="filter-container">
                <div class="filter">
                    <label class="checkbox">
                        <input type="checkbox" id="coins-only" value="coin" name="Coins only">
                        <label class="label-name" for="coins-only">Coins only</label>
                    </label>
                </div>
                <div class="filter">
                    <label class="checkbox">
                        <input type="checkbox" id="bars-only" value="bar" name="Bars Only">
                        <label class="label-name" for="bars-only">Bars Only</label>
                    </label>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <h5 class="filter-title">Metal Type</h5>
            <div class="filter-container">
                @foreach ($metal_types as $type)
                    <div class="filter">
                        <label class="checkbox">
                            <input class="cat-check" type="checkbox" id="f-{{ $type->id }}"
                                value="{{ $type->id }}" name="{{ $type->name }}">
                            <label class="label-name" for="{{ $type->name }}">{{ $type->name }}</label>
                        </label>
                    </div>
                @endforeach
            </div>
        </fieldset>

        <fieldset>
            <h5 class="filter-title">Weight</h5>
            <div class="filter-container">
                @php
                    $i = 0;
                @endphp
                @foreach ($weights as $weight)
                    <div class="filter filter-to-show">
                        @php
                            if ($weight == '1000gram') {
                                $label = '1kilo';
                            } else {
                                $label = $weight;
                            }
                        @endphp
                        <label class="checkbox">
                            <input class="weight-check" type="checkbox"
                                id="{{ preg_replace('/[^a-zA-Z0-9_.]/', '_', $weight) }}"
                                value="{{ preg_replace('/[^a-zA-Z0-9_.]/', '_', $weight) }}">
                            <label class="label-name"
                                for="{{ preg_replace('/[^a-zA-Z0-9_.]/', '_', $weight) }}">{{ $weight }}</label>
                        </label>
                    </div>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </div>

            <button class="button button-clear-filters" type="button" onclick="reloadWithParams();" id="clear-filters">
                CLEAR FILTERS
            </button>

            {{-- <div class="d-block d-md-none col-12">
                <select id="weight-select" class="weight-select form-select form-select-lg multiple">
                    <option value="">All</option>
                    @foreach ($weights as $weight)
                        @php
                            if ($weight == '1000gram') {
                                $label = '1kilo';
                            } else {
                                $label = $weight;
                            }
                        @endphp
                        <option value="{{ $weight }}">{{ $weight }}</option>
                    @endforeach

                </select>
            </div> --}}
        </fieldset>
    </div>
</div>
