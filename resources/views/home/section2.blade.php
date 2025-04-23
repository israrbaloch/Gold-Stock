<div class="section2">
    <div class="page-container container home-container">
        <h2 class="section-title">Shop Bullion</h2>
        <p class="section-desc my-3">Get your hands on gold and silver coins or bars for upmost satisfaction</p>
        <div class="col-lg-12 row mt-5">
            <div class="col text-center">
                <a href="{{route('shop')}}">
                    <h3>popular</h3>
                    <img src="{{asset('img/sect2-1.png')}}" alt="Popular products">
                </a>
            </div>
            <div class="col text-center">
                <a href="{{route('shop', ['metal' => 1183])}}">
                    <h3>GOLD</h3>
                    <img src="{{asset('img/sect2-2.png')}}" alt="Gold products">
                </a>
            </div>
            <div class="col text-center">
                <a href="{{route('shop', ['metal' => 1677])}}">
                    <h3>Silver</h3>
                    <img src="{{asset('img/sect2-3.png')}}" alt="Silver products">
                </a>
            </div>
            <div class="col text-center">
                <a href="{{route('shop', ['metal' => 1681])}}">
                    <h3>Platinum</h3>
                    <img src="{{asset('img/sect2-4.png')}}" alt="Platinum products">
                </a>
            </div>
            <div class="col text-center">
                <a href="{{route('shop', ['metal' => 1682])}}">
                    <h3>Palladium</h3>
                    <img src="{{asset('img/sect2-5.png')}}" alt="Palladium products">
                </a>
            </div>
        </div>
    </div>
</div>