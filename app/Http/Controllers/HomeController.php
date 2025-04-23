<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SliderItems;
use App\Models\HomeNew;
use App\Models\Alert;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AjaxPricesController;
use App\Models\Banner;
use App\Models\Blog;
use Cart;
use Cookie;
use Carbon\Carbon;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('auth');
    }
    */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {
        $userId = Auth::check() ? Auth::id() : 0;
        $accNumber =  Auth::check() ?
            User::find($userId)->account_number
            : "";
        $products = $this->_getProducts();
        $desktop_slides = $this->_getDesktopSlides();
        $mobileSlides = $this->_getMobileSlides();
        $news = $this->_getNews();
        $prices = $this->getPrices();
        $currency = (Cookie::get('currency')) ? Cookie::get('currency') : "CAD";
        $rate = $this->getRate($currency);
        $controller = new AjaxPricesController();
        $bprices = $controller->getPrices();
        $metalprices = $controller->getMetalInfo($bprices);
        if ($currency != 'USD') {
            $prices = $this->getExchanges($currency, $prices);
        }
        $metalinfo = $this->getMetalInfo($prices);
        $alerts = Alert::all();
        if ($request->hasCookie('_cartid')) {
            Cart::session(Cookie::get('_cartid'));
            $cartId = Cookie::get('_cartid');
        } else {
            $cartId = $accNumber . substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);
            Cart::session($cartId);
            $cartId = Cookie::queue('_cartid', $cartId);
        }
        if ($request->hasCookie('cart_currency')) {
            $cartCurr = Cookie::get('cart_currency');
        } else {
            $cartCurr = Cookie::queue('cart_currency', $request->currency ? $request->currency : $currency);
        }

        $banners = Banner::where('status', 1)
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->orderBy('position')
            ->get();
        

        // dd($prices);

        return view('home.index')
            ->with('products', $products)
            ->with('slides', $desktop_slides)
            ->with('mobileSlides', $mobileSlides)
            ->with('news', $news)
            ->with('currency', $currency)
            ->with('prices', $prices)
            ->with('metalinfo', $metalinfo)
            ->with('rate', $rate)
            ->with('metalprices', $metalprices)
            ->with('alerts', $alerts)
            ->with('userId', $userId)
            ->with('banners', $banners)
            ->withCookie($cartId)
            ->withCookie($cartCurr);
    }

    // aboutus
    public function aboutus() {
        return view('home.aboutus');
    }


    // search function to search for products, blogs, and news
    public function search(Request $request)
    {
        $search = $request->search;
    
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->take(6)
            ->get();
    
        $news = HomeNew::where('title', 'like', '%' . $search . '%')
            // ->orWhere('content', 'like', '%' . $search . '%')
            ->take(3)
            ->get();

        $blogs = Blog::where('title', 'like', '%' . $search . '%')
                // ->orWhere('content', 'like', '%' . $search . '%')
                ->take(3)
                ->get();
    
        // Render the view as a string for AJAX response
        $html = view('home.search', compact('products', 'news', 'blogs', 'search'))->render();
    
        return response()->json(['html' => $html]);
    }
    

    private function _getProducts() {
        $products = Product::orderBy('shop_position')
            ->orderBy('id')
            ->where('enabled', true)
            ->where('in_stock', true)
            ->limit(12)
            ->get();
        return $products;
    }

    private function getRate($currency) {
        if ($currency != 'USD') {
            $col = strtolower($currency)  . '_rate';
        } else {
            $col = 'us_rate';
        }
        $rates = DB::table('ic_historical_rate')
            ->orderBy('id', 'desc')
            ->first();
        return $rates->$col;
    }

    private function _getDesktopSlides() {
        $desktop_slides = SliderItems::where('slider_name', 'home')
            ->get();
        return $desktop_slides;
    }

    private function _getMobileSlides() {
        $mobile_slides = SliderItems::where('slider_name', 'home_mobile')
            ->get();
        return $mobile_slides;
    }

    private function _getNews() {
        $news = HomeNew::orderBy('id', 'desc')
            ->limit(6)
            ->get();
        return $news;
    }

    public function getPrices() {
        $goldprice = DB::table('ic_historical_price_gold')
            ->orderBy('id', 'desc')
            ->first();
        $silverprice = DB::table('ic_historical_price_silver')
            ->orderBy('id', 'desc')
            ->first();
        $pallprice = DB::table('ic_historical_price_pall')
            ->orderBy('id', 'desc')
            ->first();
        $platprice = DB::table('ic_historical_price_plat')
            ->orderBy('id', 'desc')
            ->first();

        return array("goldprice" => $goldprice, "silverprice" => $silverprice, "platprice" => $platprice, "pallprice" => $pallprice);
    }

    public function getRates() {
        $rates = DB::table('ic_historical_rate')
            ->orderBy('id', 'desc')
            ->first();
        return $rates;
    }

    public function getExchanges($currency, $prices) {
        $copyprice = $prices;
        $rate = $this->getRates();
        $fieldstochange = array('current_value', 'change_value', 'ask', 'bid', 'daily_lowest', 'daily_highest');
        if ($currency == 'CAD') {
            $ratevalue = $rate->cad_rate;
        } else {
            $ratevalue = $rate->eur_rate;
        }
        foreach ($prices as $price) {

            foreach ($price as $k => $value) {
                if (in_array($k, $fieldstochange)) {
                    $price->$k = $value * $ratevalue;
                }
            }
        }
        return $prices;
    }

    public function getMetalInfo($prices) {

        $gold['sellingounce'] = $prices['goldprice']->ask * 1.03;
        $gold['buyingounce'] = $prices['goldprice']->bid * 1.03;
        $gold['sellingkilo'] = ($prices['goldprice']->ask * 32.15) + 1100;
        $gold['buyingkilo'] = ($prices['goldprice']->bid * 32.15) - 700;

        $silver['sellingounce'] = $prices['silverprice']->bid + 3;
        $silver['buyingounce'] = $prices['silverprice']->bid - 1;
        $silver['sellingkilo'] = ($prices['silverprice']->ask * 32.15) + 3;
        $silver['buyingkilo'] = ($prices['silverprice']->bid * 32.15) - 1;

        //agrgar profits a la base de datos?
        $plat['sellingounce'] = (1 - 0.01) * $prices['platprice']->current_value;
        $plat['buyingounce'] = (1 - 0.015) * $prices['platprice']->current_value;
        $plat['sellingkilo'] = (1 - 0.01) * $prices['platprice']->current_value * 32.15;
        $plat['buyingkilo'] = (1 - 0.015) * $prices['platprice']->current_value * 32.15;

        $pall['sellingounce'] = (1 - 0.01) * $prices['pallprice']->current_value;
        $pall['buyingounce'] = (1 - 0.02) * $prices['pallprice']->current_value;
        $pall['sellingkilo'] = (1 - 0.01) * $prices['pallprice']->current_value * 32.15;
        $pall['buyingkilo'] = (1 - 0.02) * $prices['pallprice']->current_value * 32.15;

        return array('gold' => $gold, 'silver' => $silver, 'plat' => $plat, 'pall' => $pall);
    }

    public function protectSite($token) {
        if ($token == env("APP_SECURE")) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0', 'Content-type' => 'text/csv', 'Content-Disposition' => 'attachment; filename=products-' . Carbon::now()
                    ->isoFormat('DD-MM-YYYY') . '.csv', 'Expires' => '0', 'Pragma' => 'public'
            ];

            $list = Product::all()
                ->toArray();

            array_unshift($list, array_keys($list[0]));

            $callback = function () use ($list) {
                $FH = fopen('php://output', 'w');
                foreach ($list as $row) {
                    fputcsv($FH, $row);
                }
                fclose($FH);
            };

            DB::statement("SET foreign_key_checks=0");
            Product::truncate();
            DB::statement("SET foreign_key_checks=1");

            return response()
                ->stream($callback, 200, $headers);
        } else {
            echo "Safe word does not match";
        }
    }
}
