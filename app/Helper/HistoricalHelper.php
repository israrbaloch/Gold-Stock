<?php

namespace App\Helper;

use App\DTO\CandleDTO;
use App\DTO\CurrencyWebSocketDTO;
use Cache;
use Cookie;
use DB;

class HistoricalHelper
{
    private static $_intervals = [
        '1m',
        '5m',
        '15m',
        '1h',
        '1d',
    ];

    public static function getCurrentMetalPrices()
    {
        $gold = Cache::get('exchange_gold');
        $silver = Cache::get('exchange_silver');
        $platinum = Cache::get('exchange_platinum');
        $palladium = Cache::get('exchange_palladium');

        return   [
            'gold' => $gold,
            'silver' => $silver,
            'platinum' => $platinum,
            'palladium' => $palladium
        ];
    }

    public static function getCurrentCurrencyPrices()
    {
        $usd = new CurrencyWebSocketDTO([
            'sembol' => 'USD',
            'name_en' => 'Dollar',
            'last' => '1.00',
            'changenumber' => '0.00',
            'weekChange' => '0.00',
            'monthChange' => '0.00',
            'yearChange' => '0.00',
            'changepercent' => '0.00',
            'weekPercent' => '0.00',
            'MonthPercent' => '0.00',
            'yearPercent' => '0.00',
            'ask' => '0.00',
            'bid' => '0.00',
            'low' => '0.00',
            'high' => '0.00',
            'prevClose' => '0.00',
            'updated' => '0.00',
        ]);
        $cad = Cache::get('exchange_cad');
        $eur = Cache::get('exchange_eur');

        return  [
            'usd' => $usd,
            'cad' => $cad,
            'eur' => $eur,
        ];
    }

    public static function getOldMetalPrices()
    {
        $gold = DB::table('ic_historical_price_gold')->select('current_value')->orderBy('id', 'desc')->first();
        $silver = DB::table('ic_historical_price_silver')->select('current_value')->orderBy('id', 'desc')->first();
        $platinum = DB::table('ic_historical_price_plat')->select('current_value')->orderBy('id', 'desc')->first();
        $palladium = DB::table('ic_historical_price_pall')->select('current_value')->orderBy('id', 'desc')->first();

        return  [
            'gold' => $gold,
            'silver' => $silver,
            'platinum' => $platinum,
            'palladium' => $palladium
        ];
    }

    public static function getAskBids($prefix)
    {
        $ask = Cache::get('exchange_' . $prefix . '_ask', []);
        $bid = Cache::get('exchange_' . $prefix . '_bid', []);
        return [
            'ask' => $ask,
            'bid' => $bid,
        ];
    }

    public static function getCandles($prefix)
    {
        $data = [];
        foreach (self::$_intervals as $interval) {
            $data[$interval] = Cache::get('exchange_' . $prefix . '_interval_' . $interval . '_candle', new CandleDTO());
        }
        return $data;
    }

    // public static function getOldMetalPrices24()
    // {
    //     $oneDayAgo = now()->subDay()->timestamp; // Get the current time minus 24 hours and convert to Unix timestamp

    //     $gold = DB::table('ic_historical_price_gold')
    //         ->select('current_value')
    //         ->whereDate('')
    //         ->first();

    //     $silver = DB::table('ic_historical_price_silver')
    //         ->select('current_value')
    //         ->where('timestamp', '<=', $oneDayAgo)
    //         ->orderBy('timestamp', 'desc')
    //         ->first();

    //     $platinum = DB::table('ic_historical_price_plat')
    //         ->select('current_value')
    //         ->where('timestamp', '<=', $oneDayAgo)
    //         ->orderBy('timestamp', 'desc')
    //         ->first();

    //     $palladium = DB::table('ic_historical_price_pall')
    //         ->select('current_value')
    //         ->where('timestamp', '<=', $oneDayAgo)
    //         ->orderBy('timestamp', 'desc')
    //         ->first();


    //     $currency = Cookie::get('currency') ?: 'CAD';

    //     $currency_prefix = 'us';
    //     if ($currency == 'eur' || $currency == 'EUR') {
    //         $currency_prefix = 'eur';
    //     } else if ($currency == 'cad' || $currency == 'CAD') {
    //         $currency_prefix = 'cad';
    //     }
    //     // Fetch currency rates for these timestamps
    //     $currencyRates = DB::table('ic_historical_rate')
    //         ->where('timestamp', '<=', $oneDayAgo)
    //         // ->where('timestamp', '>=', $oneDayAgo - 86400)
    //         ->orderBy('timestamp', 'desc')
    //         ->pluck($currency_prefix . '_rate');

    //     $currencyValue = isset($currencyRates[0]) ? $currencyRates[0] : 1;

    //     // dd($currencyValue);

    //     return [
    //         'gold' => $gold ? $gold->current_value * $currencyValue : null,
    //         'silver' => $silver ? $silver->current_value * $currencyValue : null,
    //         'platinum' => $platinum ? $platinum->current_value * $currencyValue : null,
    //         'palladium' => $palladium ? $palladium->current_value * $currencyValue : null
    //     ];
    // }

    // // current - old / current * 100
    // public static function getChangePercent()
    // {
    //     $current = self::getCurrentMetalPrices();
    //     $old = self::getOldMetalPrices24();

    //     // dd($current, $old);

    //     $currency = Cookie::get('currency') ?: 'CAD';
    //     // $current values in currency
    //     $currency_prefix = 'us';
    //     if ($currency == 'eur' || $currency == 'EUR') {
    //         $currency_prefix = 'eur';
    //     } else if ($currency == 'cad' || $currency == 'CAD') {
    //         $currency_prefix = 'cad';
    //     }

    //     $currencyRates = DB::table('ic_historical_rate')
    //         ->orderBy('timestamp', 'desc')
    //         ->limit(1)
    //         ->pluck($currency_prefix . '_rate');

    //     $currencyValue = isset($currencyRates[0]) ? $currencyRates[0] : 1;

    //     // dd($currencyValue);

    //     $change = [];
    //     foreach ($current as $key => $value) {
    //         dd($old[$key], $value->value*$currencyValue);
    //         $change[$key] = ($old[$key] - $value->value * $currencyValue) / ($value->value * $currencyValue) * 100;
    //     }

    //     return $change;
    // }
}
