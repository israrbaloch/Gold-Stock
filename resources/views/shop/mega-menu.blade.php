<div class="container- mb-4 d-lg-block d-none">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 filter-section px-5- container mx-auto">
      <!-- Shop by Metal Section -->
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
              <input type="checkbox" id="metal-gold" class="form-check-input" data-metal="gold">
              <label for="metal-gold" class="fw-bold toggle-btn" data-bs-toggle="collapse" data-bs-target="#goldSubmenu">Gold</label>
            </li>
            <ul id="goldSubmenu" class="collapse ms-3">
              <li>
                <input type="checkbox" id="gold-bars" class="form-check-input" data-category="gold-bars">
                <label for="gold-bars" class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#goldBars">Bars</label>
              </li>
              <ul id="goldBars" class="collapse ms-3">
                <li>
                  <input type="checkbox" id="gold-bars-1oz" class="form-check-input" data-weight="gold-bars-1oz">
                  <label for="gold-bars-1oz">1oz</label>
                </li>
                <li>
                  <input type="checkbox" id="gold-bars-10oz" class="form-check-input" data-weight="gold-bars-10oz">
                  <label for="gold-bars-10oz">10oz</label>
                </li>
                <li>
                  <input type="checkbox" id="gold-bars-100oz" class="form-check-input" data-weight="gold-bars-100oz">
                  <label for="gold-bars-100oz">100oz</label>
                </li>
              </ul>
              <li>
                <input type="checkbox" id="gold-coins" class="form-check-input" data-category="gold-coins">
                <label for="gold-coins" class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#goldCoins">Coins</label>
              </li>
              <ul id="goldCoins" class="collapse ms-3">
                <li>
                  <input type="checkbox" id="gold-coins-1oz" class="form-check-input" data-weight="gold-coins-1oz">
                  <label for="gold-coins-1oz">1oz</label>
                </li>
                <li>
                  <input type="checkbox" id="gold-coins-10oz" class="form-check-input" data-weight="gold-coins-10oz">
                  <label for="gold-coins-10oz">10oz</label>
                </li>
                <li>
                  <input type="checkbox" id="gold-coins-100oz" class="form-check-input" data-weight="gold-coins-100oz">
                  <label for="gold-coins-100oz">100oz</label>
                </li>
                <li>
                  <input type="checkbox" id="gold-coins-1g" class="form-check-input" data-weight="gold-coins-1g">
                  <label for="gold-coins-1g">1 gram</label>
                </li>
              </ul>
              <li>
                <input type="checkbox" id="gold-rounds" class="form-check-input" data-category="gold-rounds">
                <label for="gold-rounds" class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#goldRounds">Rounds</label>
              </li>
            </ul>
        
            <!-- Silver Section -->
            <li>
              <input type="checkbox" id="metal-silver" class="form-check-input" data-metal="silver">
              <label for="metal-silver" class="fw-bold toggle-btn" data-bs-toggle="collapse" data-bs-target="#silverSubmenu">Silver</label>
            </li>
            <ul id="silverSubmenu" class="collapse ms-3">
              <li>
                <input type="checkbox" id="silver-bars" class="form-check-input" data-category="silver-bars">
                <label for="silver-bars" class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#silverBars">Bars</label>
              </li>
              <ul id="silverBars" class="collapse ms-3">
                <li>
                  <input type="checkbox" id="silver-bars-1oz" class="form-check-input" data-weight="silver-bars-1oz">
                  <label for="silver-bars-1oz">1oz</label>
                </li>
                <li>
                  <input type="checkbox" id="silver-bars-10oz" class="form-check-input" data-weight="silver-bars-10oz">
                  <label for="silver-bars-10oz">10oz</label>
                </li>
                <li>
                  <input type="checkbox" id="silver-bars-100oz" class="form-check-input" data-weight="silver-bars-100oz">
                  <label for="silver-bars-100oz">100oz</label>
                </li>
              </ul>
              <li>
                <input type="checkbox" id="silver-coins" class="form-check-input" data-category="silver-coins">
                <label for="silver-coins" class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#silverCoins">Coins</label>
              </li>
              <ul id="silverCoins" class="collapse ms-3">
                <li>
                  <input type="checkbox" id="silver-coins-1oz" class="form-check-input" data-weight="silver-coins-1oz">
                  <label for="silver-coins-1oz">1oz</label>
                </li>
                <li>
                  <input type="checkbox" id="silver-coins-10oz" class="form-check-input" data-weight="silver-coins-10oz">
                  <label for="silver-coins-10oz">10oz</label>
                </li>
              </ul>
            </ul>
        
            <!-- Platinum Section -->
            <li>
              <input type="checkbox" id="metal-platinum" class="form-check-input" data-metal="platinum">
              <label for="metal-platinum" class="fw-bold toggle-btn" data-bs-toggle="collapse" data-bs-target="#platinumSubmenu">Platinum</label>
            </li>
            <ul id="platinumSubmenu" class="collapse ms-3">
              <li>
                <input type="checkbox" id="platinum-bars" class="form-check-input" data-category="platinum-bars">
                <label for="platinum-bars" class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#platinumBars">Bars</label>
              </li>
              <ul id="platinumBars" class="collapse ms-3">
                <li>
                  <input type="checkbox" id="platinum-bars-1oz" class="form-check-input" data-weight="platinum-bars-1oz">
                  <label for="platinum-bars-1oz">1oz</label>
                </li>
              </ul>
            </ul>
        
            <!-- Palladium Section -->
            <li>
              <input type="checkbox" id="metal-palladium" class="form-check-input" data-metal="palladium">
              <label for="metal-palladium" class="fw-bold toggle-btn" data-bs-toggle="collapse" data-bs-target="#palladiumSubmenu">Palladium</label>
            </li>
            <ul id="palladiumSubmenu" class="collapse ms-3">
              <li>
                <input type="checkbox" id="palladium-bars" class="form-check-input" data-category="palladium-bars">
                <label for="palladium-bars" class="toggle-btn" data-bs-toggle="collapse" data-bs-target="#palladiumBars">Bars</label>
              </li>
              <ul id="palladiumBars" class="collapse ms-3">
                <li>
                  <input type="checkbox" id="palladium-bars-1oz" class="form-check-input" data-weight="palladium-bars-1oz">
                  <label for="palladium-bars-1oz">1oz</label>
                </li>
              </ul>
            </ul>
          </ul>
        </div>
      </div>

      <!-- Best Deals & Brands Section -->
      <div class="col px-0">
        <div class="filter-category">
          <h3>
            <span class="icon">
              <img src="{{asset('img/mega-2.png')}}" alt="Best Deals & Brands">
            </span> 
            Best Deals & Brands
          </h3>
          <ul class="list-unstyled">
            <li>
              <input type="checkbox" id="best-deals" class="form-check-input">
              <label for="best-deals">Top Deals & Low Premium Bullion</label>
            </li>
            <li>
              <input type="checkbox" id="wholesale" class="form-check-input">
              <label for="wholesale">Wholesale & Bulk Discount</label>
            </li>
            <li>
              <input type="checkbox" id="brands" class="form-check-input">
              <label for="brands"><p class="mb-0"><strong>Brands</strong> (Royal Canadian Mint, PAMP Suisse, Valcambi, etc.)</p></label>
            </li>
          </ul>
        </div>
      </div>

      <!-- Investment & Collectibles Section -->
      <div class="col px-0">
        <div class="filter-category">
          <h3>
            <span class="icon">
              <img src="{{asset('img/mega-3.png')}}" alt="Investment & Collectibles">
            </span> 
            Investment & Collectibles
          </h3>
          <ul class="list-unstyled">
            <li>
              <input type="checkbox" id="investment-best-seller" class="form-check-input">
              <label for="investment-best-seller">Best Seller & New Arrivals</label>
            </li>
            <li>
              <input type="checkbox" id="investment-popular-weight" class="form-check-input">
              <label for="investment-popular-weight">Popular Weight Options (1oz, 10oz, 100oz)</label>
            </li>
            <li>
              <input type="checkbox" id="investment-rare" class="form-check-input">
              <label for="investment-rare">Rare & Numismatic Coins</label>
            </li>
          </ul>
        </div>
      </div>

      <!-- Market Data & Resources Section -->
      <div class="col px-0">
        <div class="filter-category">
          <h3>
            <span class="icon">
              <img src="{{asset('img/mega-4.png')}}" alt="Market Data & Resources">
            </span> 
            Market Data & Resources
          </h3>
          <ul class="list-unstyled">
            <li>
              <input type="checkbox" id="market-live-metal" class="form-check-input">
              <label for="market-live-metal">Live metal price (Gold, Silver, Platinum, Palladium)</label>
            </li>
            <li>
              <input type="checkbox" id="how-to-buy" class="form-check-input">
              <label for="how-to-buy">How to Buy Precious Metals</label>
            </li>
            <li>
              <input type="checkbox" id="investing-guides" class="form-check-input">
              <label for="investing-guides">Investing Guides & Secure Storage</label>
            </li>
            <li>
              <input type="checkbox" id="accessories" class="form-check-input">
              <label for="accessories"><p class="mb-0"><strong>Accessories</strong> (Coins Capsules, Storage Boxes, Testing Kit)</p></label>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>