<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AjaxPricesController;
use App\Models\HomeNew;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class LivePricesController extends Controller
{
    private function getHistoricalPrice($code, $interval)
    {
        $currency = Cookie::get('currency');

        $data = Cache::get($code);

        if ($currency == 'CAD') {
            $usd_to_cad = Cache::get('USD/CAD');
            return $data[$interval] * $usd_to_cad[$interval];
        }

        if ($currency == 'EUR') {
            $usd_to_eur = Cache::get('EUR/USD');
            return $data[$interval] / $usd_to_eur[$interval];
        }

        return $data[$interval];
    }


    // Function to build a series for a metal
    private function buildSeries($tableName)
    {
        // week, today
        $todayPrice = $this->getHistoricalPrice($tableName, 'today');
        $weekPrice = $this->getHistoricalPrice($tableName, 'week');
        $monthPrice = $this->getHistoricalPrice($tableName,'month');
        $sixMonthsPrice = $this->getHistoricalPrice($tableName, 'six_months');
        $yearPrice = $this->getHistoricalPrice($tableName, 'year');

        // dd($monthPrice, $sixMonthsPrice, $yearPrice);

        return json_encode(array_reverse([
            (int)$todayPrice,
            (int)$weekPrice,
            (int)$monthPrice,
            (int)$sixMonthsPrice,
            (int)$yearPrice,
        ]));
    }

    function getView()
    {
        $currency = Cookie::get('currency');

        $rate = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();
        $controller = new AjaxPricesController();
        $prices = $controller->getPrices();
        $prices = $controller->getMetalInfo($prices, $currency);

        // dd($prices);
        $oldGoldPrice = DB::table('ht_gold_1d')->orderBy('timestamp_id', 'desc')->first();
        $oldGoldPrice = $oldGoldPrice->close;
        $oldSilverPrice = DB::table('ht_silver_1d')->orderBy('timestamp_id', 'desc')->first();
        $oldSilverPrice = $oldSilverPrice->close;

        $oldRatio = $oldGoldPrice / $oldSilverPrice;

        $currency = 'USD';

        $currencies = [
            "XAU/{$currency}",
            "XAG/{$currency}",
            "XPT/{$currency}",
            "XPD/{$currency}",
        ];

        // Build series for each metal
        $goldSeries = $this->buildSeries($currencies[0]);
        $silverSeries = $this->buildSeries($currencies[1]);
        $platinumSeries = $this->buildSeries($currencies[2]);
        $palladiumSeries = $this->buildSeries($currencies[3]);


        $news = HomeNew::orderBy('id', 'desc')
            ->limit(3)
            ->get();



        return view('live-prices')->with('prices', $prices)->with('rate', $rate)->with('oldRatio', $oldRatio)->with('goldSeries', $goldSeries)->with('silverSeries', $silverSeries)->with('platinumSeries', $platinumSeries)->with('palladiumSeries', $palladiumSeries)->with('news', $news)->with('currency', Cookie::get('currency'));
    }
}
