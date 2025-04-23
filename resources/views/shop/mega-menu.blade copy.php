<div class="container- mb-4 d-lg-block d-none">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 filter-section px-5- container mx-auto">
        <div class="col px-0">
            <div class="filter-category">
                <h3>
                    <span class="icon">
                        <img src="{{asset('img/mega-1.png')}}" alt="Metal Type">
                    </span> 
                    Shop by Metal
                </h3>
                <ul class="list-unstyled">
                    <!-- Gold Section -->
                    <li>
                        <input type="checkbox" class="form-check-input" data-metal="gold"> 
                        <span class="fw-bold toggle-btn" data-bs-toggle="collapse" data-bs-target="#goldSubmenu">Gold</span>
                    </li>
                    <ul id="goldSubmenu" class="collapse ms-3">
                        <li>
                            <input type="checkbox" class="form-check-input" data-category="gold-bars">
                            <span class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#goldBars">Bars</span>
                        </li>
                        <ul id="goldBars" class="collapse ms-3">
                            <li><input type="checkbox" class="form-check-input" data-weight="gold-bars-1oz"> 1oz</li>
                            <li><input type="checkbox" class="form-check-input" data-weight="gold-bars-10oz"> 10oz</li>
                            <li><input type="checkbox" class="form-check-input" data-weight="gold-bars-100oz"> 100oz</li>
                        </ul>
                        <li>
                            <input type="checkbox" class="form-check-input" data-category="gold-coins">
                            <span class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#goldCoins">Coins</span>
                        </li>
                        <ul id="goldCoins" class="collapse ms-3">
                            <li><input type="checkbox" class="form-check-input" data-weight="gold-coins-1oz"> 1oz</li>
                            <li><input type="checkbox" class="form-check-input" data-weight="gold-coins-10oz"> 10oz</li>
                            <li><input type="checkbox" class="form-check-input" data-weight="gold-coins-100oz"> 100oz</li>
                            <li><input type="checkbox" class="form-check-input" data-weight="gold-coins-1g"> 1 gram</li>
                        </ul>
                        <li>
                            <input type="checkbox" class="form-check-input" data-category="gold-rounds">
                            <span class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#goldRounds">Rounds</span>
                        </li>
                    </ul>
                
                    <!-- Silver Section -->
                    <li>
                        <input type="checkbox" class="form-check-input" data-metal="silver">
                        <span class="fw-bold toggle-btn" data-bs-toggle="collapse" data-bs-target="#silverSubmenu">Silver</span>
                    </li>
                    <ul id="silverSubmenu" class="collapse ms-3">
                        <li>
                            <input type="checkbox" class="form-check-input" data-category="silver-bars">
                            <span class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#silverBars">Bars</span>
                        </li>
                        <ul id="silverBars" class="collapse ms-3">
                            <li><input type="checkbox" class="form-check-input" data-weight="silver-bars-1oz"> 1oz</li>
                            <li><input type="checkbox" class="form-check-input" data-weight="silver-bars-10oz"> 10oz</li>
                            <li><input type="checkbox" class="form-check-input" data-weight="silver-bars-100oz"> 100oz</li>
                        </ul>
                        <li>
                            <input type="checkbox" class="form-check-input" data-category="silver-coins">
                            <span class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#silverCoins">Coins</span>
                        </li>
                        <ul id="silverCoins" class="collapse ms-3">
                            <li><input type="checkbox" class="form-check-input" data-weight="silver-coins-1oz"> 1oz</li>
                            <li><input type="checkbox" class="form-check-input" data-weight="silver-coins-10oz"> 10oz</li>
                        </ul>
                    </ul>
                
                    <!-- Platinum Section -->
                    <li>
                        <input type="checkbox" class="form-check-input" data-metal="platinum">
                        <span class="fw-bold toggle-btn" data-bs-toggle="collapse" data-bs-target="#platinumSubmenu">Platinum</span>
                    </li>
                    <ul id="platinumSubmenu" class="collapse ms-3">
                        <li>
                            <input type="checkbox" class="form-check-input" data-category="platinum-bars">
                            <span class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#platinumBars">Bars</span>
                        </li>
                        <ul id="platinumBars" class="collapse ms-3">
                            <li><input type="checkbox" class="form-check-input" data-weight="platinum-bars-1oz"> 1oz</li>
                        </ul>
                    </ul>
                
                    <!-- Palladium Section -->
                    <li>
                        <input type="checkbox" class="form-check-input" data-metal="palladium">
                        <span class="fw-bold toggle-btn" data-bs-toggle="collapse" data-bs-target="#palladiumSubmenu">Palladium</span>
                    </li>
                    <ul id="palladiumSubmenu" class="collapse ms-3">
                        <li>
                            <input type="checkbox" class="form-check-input" data-category="palladium-bars">
                            <span class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#palladiumBars">Bars</span>
                        </li>
                        <ul id="palladiumBars" class="collapse ms-3">
                            <li><input type="checkbox" class="form-check-input" data-weight="palladium-bars-1oz"> 1oz</li>
                        </ul>
                    </ul>
                </ul>                
            </div>
        </div>

        <div class="col px-0">
            <div class="filter-category">
                <h3><span class="icon"><img src="{{asset('img/mega-2.png')}}" alt="Best Deals & Brands"></span> Best Deals & Brands</h3>
                <ul class="list-unstyled">
                    <li><input type="checkbox" class="form-check-input"> Top Deals & Low Premium Bullion</li>
                    <li><input type="checkbox" class="form-check-input"> Wholesale & Bulk Discount</li>
                    <li><input type="checkbox" class="form-check-input"> <p class="mb-0"><strong>Brands</strong> (Royal Canadian Mint, PAMP Suisse, Valcambi, etc.)</p></li>
                </ul>
            </div>
        </div>

        <div class="col px-0">
            <div class="filter-category">
                <h3><span class="icon"><img src="{{asset('img/mega-3.png')}}" alt="Investment & Collectibles"></span> Investment & Collectibles</h3>
                <ul class="list-unstyled">
                    <li><input type="checkbox" class="form-check-input"> Best Seller & New Arrivals</li>
                    <li><input type="checkbox" class="form-check-input"> Popular Weight Options (1oz, 10oz, 100oz)</li>
                    <li><input type="checkbox" class="form-check-input"> Rare & Numismatic Coins</li>
                </ul>
            </div>
        </div>

        <div class="col px-0">
            <div class="filter-category">
                <h3><span class="icon"><img src="{{asset('img/mega-4.png')}}" alt="Market Data & Resources"></span> Market Data & Resources</h3>
                <ul class="list-unstyled">
                    <li><input type="checkbox" class="form-check-input"> Live metal price (Gold, Silver, Platinum, Palladium)</li>
                    <li><input type="checkbox" class="form-check-input"> How to Buy Precious Metals</li>
                    <li><input type="checkbox" class="form-check-input"> Investing Guides & Secure Storage</li>
                    <li><input type="checkbox" class="form-check-input"> <p class="mb-0"><strong>Accessories</strong> (Coins Capsules, Storage Boxes, Testing Kit)</p></li>
                </ul>
            </div>
        </div>
    </div>
</div>