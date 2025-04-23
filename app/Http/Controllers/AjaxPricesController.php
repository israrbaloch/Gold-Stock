<?php

namespace App\Http\Controllers;

use App\DTO\CurrencyWebSocketDTO;
use App\Helper\HistoricalHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cookie;
use Carbon\Carbon;
use App\Models\Metal;
use App\Models\AdditionalPercent;
use App\Models\Currency;
use App\Models\HTGold15M;
use App\Models\HTGold1D;
use App\Models\HTGold1H;
use App\Models\HTGold1M;
use App\Models\HTGold5M;
use App\Models\HTPalladium15M;
use App\Models\HTPalladium1D;
use App\Models\HTPalladium1H;
use App\Models\HTPalladium1M;
use App\Models\HTPalladium5M;
use App\Models\HTPlatinum15M;
use App\Models\HTPlatinum1D;
use App\Models\HTPlatinum1H;
use App\Models\HTPlatinum1M;
use App\Models\HTPlatinum5M;
use App\Models\HTSilver15M;
use App\Models\HTSilver1D;
use App\Models\HTSilver1H;
use App\Models\HTSilver1M;
use App\Models\HTSilver5M;
use Cache;

class AjaxPricesController extends Controller
{

    public function getPrices()
    {
        $goldPrice = DB::table('ic_historical_price_gold')->orderBy('id', 'desc')->first();
        $silverPrice = DB::table('ic_historical_price_silver')->orderBy('id', 'desc')->first();
        $platPrice = DB::table('ic_historical_price_plat')->orderBy('id', 'desc')->first();
        $pallPrice = DB::table('ic_historical_price_pall')->orderBy('id', 'desc')->first();
        $resp = array("goldprice" => $goldPrice, "silverprice" => $silverPrice, "platprice" => $platPrice, "pallprice" => $pallPrice);
        return $resp;
    }

    public function getMetalPrices($curr)
    {
        $metals = Metal::get();
        $prices = [];
        foreach ($metals as $metal) {
            $prices[$metal->id] = DB::table('ic_historical_price_' . $metal->code)->orderBy('id', 'desc')->first();
        }
        return $this->getExchanges($curr, $prices);
    }

    public function getRates()
    {
        $rates = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();
        return $rates;
    }

    public function getExchanges($currency, $prices)
    {
        $rate = $this->getRates();
        $fieldsToChange = array('current_value', 'change_value', 'ask', 'bid', 'daily_lowest', 'daily_highest');

        if ($currency == 'USD') {
            $rateValue = $rate->us_rate;
        } else if ($currency == 'EUR') {
            $rateValue = $rate->eur_rate;
        } else {
            $rateValue = $rate->cad_rate;
        }

        foreach ($prices as $price) {

            foreach ($price as $k => $value) {
                if (in_array($k, $fieldsToChange)) {
                    $price->$k = $value * $rateValue;
                }
            }
        }
        return $prices;
    }

    public function getAdditionalPercent($type = "calculator", $sign = "negative")
    {

        $value = 20;/* default */

        $result = AdditionalPercent::where('type', $type)->where('sign', $sign)->first();

        return $result ? $result->percent : $value;
    }

    public function getMetalInfo($usdPrices, $curr = null)
    {

        $currency = ($curr) ? $curr : Cookie::get('currency');

        $prices = $this->getExchanges($currency, $usdPrices);

        $usd_to_eur = Cache::get('exchange_eur')->value;
        $usd_to_cad = Cache::get('exchange_cad')->value;

        // Gold
        $goldProfit = Metal::where('name', 'like', '%gold%')->first();
        $gold['sprofit'] = $goldProfit->sprofit;
        $gold['bprofit'] = $goldProfit->bprofit;
        $gold['sfakeprice'] = $prices['goldprice']->current_value * (1 - $gold['sprofit']);
        $gold['bfakeprice'] = $prices['goldprice']->current_value * ($gold['bprofit'] + 1);
        $gold['lowest'] = $prices['goldprice']->daily_lowest;
        $gold['highest'] = $prices['goldprice']->daily_highest;
        $gold['change_percent'] = $prices['goldprice']->change_percent;
        $gold['current_value'] = $prices['goldprice']->current_value;

        $gold_ask_adjust_usd = 2;
        $gold_bid_adjust_usd = -3;

        if ($currency == 'USD') {
            $gold_ask_adjust = $gold_ask_adjust_usd;
            $gold_bid_adjust = $gold_bid_adjust_usd;
        } else if ($currency == 'EUR') {
            $gold_ask_adjust = $gold_ask_adjust_usd * $usd_to_eur;
            $gold_bid_adjust = $gold_bid_adjust_usd * $usd_to_eur;
        } else {
            $gold_ask_adjust = $gold_ask_adjust_usd * $usd_to_cad;
            $gold_bid_adjust = $gold_bid_adjust_usd * $usd_to_cad;
        }

        $gold['ask'] = $prices['goldprice']->ask + $gold_ask_adjust;
        $gold['bid'] = $prices['goldprice']->bid + $gold_bid_adjust;

        $gold['sellingounce'] = $prices['goldprice']->ask * 1.03;
        $gold['buyingounce'] = $prices['goldprice']->bid * 1.03;
        $gold['sellingkilo'] = ($prices['goldprice']->ask * 32.15) + 1100;
        $gold['buyingkilo'] = ($prices['goldprice']->bid * 32.15) - 700;

        // Silver
        $silverProfit = Metal::where('name', 'like', '%silver%')->first();
        $silver['sprofit'] = $silverProfit->sprofit;
        $silver['bprofit'] = $silverProfit->bprofit;
        $silver['sfakeprice'] = $prices['silverprice']->current_value * (1 - $silver['sprofit']);
        $silver['bfakeprice'] = $prices['silverprice']->current_value * ($silver['bprofit'] + 1);
        $silver['lowest'] = $prices['silverprice']->daily_lowest;
        $silver['highest'] = $prices['silverprice']->daily_highest;
        $silver['change_percent'] = $prices['silverprice']->change_percent;
        $silver['current_value'] = $prices['silverprice']->current_value;

        $silver_ask_adjust_usd = 0.03;
        $silver_bid_adjust_usd = -0.06;

        if ($currency == 'USD') {
            $silver_ask_adjust = $silver_ask_adjust_usd;
            $silver_bid_adjust = $silver_bid_adjust_usd;
        } else if ($currency == 'EUR') {
            $silver_ask_adjust = $silver_ask_adjust_usd * $usd_to_eur;
            $silver_bid_adjust = $silver_bid_adjust_usd * $usd_to_eur;
        } else {
            $silver_ask_adjust = $silver_ask_adjust_usd * $usd_to_cad;
            $silver_bid_adjust = $silver_bid_adjust_usd * $usd_to_cad;
        }

        $silver['ask'] = $prices['silverprice']->ask + $silver_ask_adjust;
        $silver['bid'] = $prices['silverprice']->bid + $silver_bid_adjust;

        $silver['sellingounce'] = $prices['silverprice']->bid + 3;
        $silver['buyingounce'] = $prices['silverprice']->bid - 1;
        $silver['sellingkilo'] = ($prices['silverprice']->ask * 32.15) + 3;
        $silver['buyingkilo'] = ($prices['silverprice']->bid * 32.15) - 1;

        // Platinum
        $platProfit = Metal::where('name', 'like', '%platinum%')->first();
        $plat['sprofit'] = $platProfit->sprofit;
        $plat['bprofit'] = $platProfit->bprofit;
        $plat['sfakeprice'] = $prices['platprice']->current_value * (1 - $plat['sprofit']);
        $plat['bfakeprice'] = $prices['platprice']->current_value * ($plat['bprofit'] + 1);
        $plat['lowest'] = $prices['platprice']->daily_lowest;
        $plat['highest'] = $prices['platprice']->daily_highest;
        $plat['change_percent'] = $prices['platprice']->change_percent;
        $plat['current_value'] = $prices['platprice']->current_value;


        $plat_ask_adjust_usd = 12;
        $plat_bid_adjust_usd = -10;

        if ($currency == 'USD') {
            $plat_ask_adjust = $plat_ask_adjust_usd;
            $plat_bid_adjust = $plat_bid_adjust_usd;
        } else if ($currency == 'EUR') {
            $plat_ask_adjust = $plat_ask_adjust_usd * $usd_to_eur;
            $plat_bid_adjust = $plat_bid_adjust_usd * $usd_to_eur;
        } else {
            $plat_ask_adjust = $plat_ask_adjust_usd * $usd_to_cad;
            $plat_bid_adjust = $plat_bid_adjust_usd * $usd_to_cad;
        }

        $plat['ask'] = $prices['platprice']->ask + $plat_ask_adjust;
        $plat['bid'] = $prices['platprice']->bid + $plat_bid_adjust;

        $plat['sellingounce'] = (1 - $plat['sprofit']) * $prices['platprice']->current_value;
        $plat['buyingounce'] = ($plat['bprofit'] + 1) * $prices['platprice']->current_value;
        $plat['sellingkilo'] = (1 - $plat['sprofit']) * $prices['platprice']->current_value * 32.15;
        $plat['buyingkilo'] = ($plat['bprofit'] + 1) * $prices['platprice']->current_value * 32.15;

        // Palladium
        $pallProfit = Metal::where('name', 'like', '%palladium%')->first();
        $pall['sprofit'] = $pallProfit->sprofit;
        $pall['bprofit'] = $pallProfit->bprofit;
        $pall['sfakeprice'] = $prices['pallprice']->current_value * (1 - $pall['sprofit']);
        $pall['bfakeprice'] = $prices['pallprice']->current_value * ($pall['bprofit'] + 1);
        $pall['lowest'] = $prices['pallprice']->daily_lowest;
        $pall['highest'] = $prices['pallprice']->daily_highest;
        $pall['change_percent'] = $prices['pallprice']->change_percent;
        $pall['current_value'] = $prices['pallprice']->current_value;

        $plad_ask_adjust_usd = 15;
        $plad_bid_adjust_usd = -15;

        if ($currency == 'USD') {
            $plad_ask_adjust = $plad_ask_adjust_usd;
            $plad_bid_adjust = $plad_bid_adjust_usd;
        } else if ($currency == 'EUR') {
            $plad_ask_adjust = $plad_ask_adjust_usd * $usd_to_eur;
            $plad_bid_adjust = $plad_bid_adjust_usd * $usd_to_eur;
        } else {
            $plad_ask_adjust = $plad_ask_adjust_usd * $usd_to_cad;
            $plad_bid_adjust = $plad_bid_adjust_usd * $usd_to_cad;
        }

        $pall['ask'] = $prices['pallprice']->ask + $plad_ask_adjust;
        $pall['bid'] = $prices['pallprice']->bid + $plad_bid_adjust;

        $pall['sellingounce'] = (1 - $pall['sprofit']) * $prices['pallprice']->current_value;
        $pall['buyingounce'] = ($pall['bprofit'] + 1) * $prices['pallprice']->current_value;
        $pall['sellingkilo'] = (1 - $pall['sprofit']) * $prices['pallprice']->current_value * 32.15;
        $pall['buyingkilo'] = ($pall['bprofit'] + 1) * $prices['pallprice']->current_value * 32.15;

        return [
            'gold' => $gold,
            'silver' => $silver,
            'platinum' => $plat,
            'palladium' => $pall
        ];
    }

    public function getLivePricesAjax(Request $request)
    {

        $prices = $this->getPrices();
        $metalInfo = $this->getMetalInfo($prices, $request->currency);

        return response()->json(array('allmetalinfo' => $metalInfo), 200);
    }

    public function getExchangePrices(Request $request)
    {
        $metal = $request->metal;

        $prices = Cache::remember('exchange_price' . $metal, 60, function () use ($metal) {
            switch ($metal) {
                case 'gold':
                    return DB::table('ic_historical_price_gold')->orderBy('id', 'desc')->limit(10)->get();
                    break;
                case 'silver':
                    return DB::table('ic_historical_price_silver')->orderBy('id', 'desc')->limit(10)->get();
                    break;
                case 'platinum':
                    return DB::table('ic_historical_price_plat')->orderBy('id', 'desc')->limit(10)->get();
                    break;
                case 'palladium':
                    return DB::table('ic_historical_price_pall')->orderBy('id', 'desc')->limit(10)->get();
                    break;
                default:
                    return [];
                    break;
            }
        });

        return response()->json(array('success' => true, 'data' => $prices), 200);
    }

    public function getPricesHistoryAjax(Request $request) {
        $metal = $request->metal;
        $interval = $request->interval;

        $intervals = [
            '1d' => [HTGold1D::class, HTSilver1D::class, HTPlatinum1D::class, HTPalladium1D::class, 60 * 60 * 24, 365 * 3],
            '1h' => [HTGold1H::class, HTSilver1H::class, HTPlatinum1H::class, HTPalladium1H::class, 60 * 60, 30],
            '15m' => [HTGold15M::class, HTSilver15M::class, HTPlatinum15M::class, HTPalladium5M::class, 60 * 15, 10],
            '5m' => [HTGold5M::class, HTSilver5M::class, HTPlatinum5M::class, HTPalladium5M::class, 60 * 5, 5],
            '1m' => [HTGold1M::class, HTSilver1M::class, HTPlatinum1M::class, HTPalladium1M::class, 60, 4],
        ];

        $metals = [
            'gold' => 0,
            'silver' => 1,
            'platinum' => 2,
            'palladium' => 3,
        ];

        $intervalModel = $intervals[$interval];
        if ($intervalModel === null) {
            return response()->json(array('success' => false, 'message' => 'Invalid interval'), 400);
        }

        $metalIndex = $metals[$metal];
        if ($metalIndex === null) {
            return response()->json(array('success' => false, 'message' => 'Invalid metal'), 400);
        }

        $model = $intervalModel[$metalIndex];
        $cacheDuration = $intervalModel[4];
        $daysAgo = $intervalModel[5];
        $now = Carbon::now('Europe/Helsinki');
        if (config('app.env') == 'production') {
            $prices = Cache::remember('exchange_' . $metal . '_interval_' . $interval, $cacheDuration, function () use ($now, $model, $daysAgo) {
                return $model::where('timestamp_id', '>', $now->subDays($daysAgo)->timestamp)->where('market_open', true)->orderBy('timestamp_id', 'desc')->get();
            });
        } else {
            $prices = $model::where('timestamp_id', '>', $now->subDays($daysAgo)->timestamp)->where('market_open', true)->orderBy('timestamp_id', 'desc')->get();
        }

        return response()->json(array('success' => true, 'data' => $prices), 200);
    }

    public function getPricesHistoryAjax_newBk(Request $request)
    {
        $metal = $request->metal;
        $interval = $request->interval;
        $currency = $request->currency;
        $currentCurrencyRate = $request->currentCurrencyRate;

        $intervals = [
            '1d' => [HTGold1D::class, HTSilver1D::class, HTPlatinum1D::class, HTPalladium1D::class, 60 * 60 * 24, 365 * 3],
            '1h' => [HTGold1H::class, HTSilver1H::class, HTPlatinum1H::class, HTPalladium1H::class, 60 * 60, 30],
            '15m' => [HTGold15M::class, HTSilver15M::class, HTPlatinum15M::class, HTPalladium5M::class, 60 * 15, 10],
            '5m' => [HTGold5M::class, HTSilver5M::class, HTPlatinum5M::class, HTPalladium5M::class, 60 * 5, 5],
            '1m' => [HTGold1M::class, HTSilver1M::class, HTPlatinum1M::class, HTPalladium1M::class, 60, 4],
        ];

        $metals = [
            'gold' => 0,
            'silver' => 1,
            'platinum' => 2,
            'palladium' => 3,
        ];

        if (!isset($intervals[$interval])) {
            return response()->json(['success' => false, 'message' => 'Invalid interval'], 400);
        }

        if (!isset($metals[$metal])) {
            return response()->json(['success' => false, 'message' => 'Invalid metal'], 400);
        }

        $intervalModel = $intervals[$interval];
        $metalIndex = $metals[$metal];
        $model = $intervalModel[$metalIndex];
        $cacheDuration = $intervalModel[4];
        $daysAgo = $intervalModel[5];
        $now = Carbon::now('Europe/Helsinki');

        if (config('app.env') == 'production') {
            $prices = Cache::remember('exchange_' . $metal . '_interval_' . $interval, $cacheDuration, function () use ($now, $model, $daysAgo) {
                return $model::where('timestamp_id', '>', $now->subDays($daysAgo)->timestamp)
                    ->where('market_open', true)
                    ->orderBy('timestamp_id', 'desc')
                    ->get();
            });
        } else {
            $prices = $model::where('timestamp_id', '>', $now->subDays($daysAgo)->timestamp)
                ->where('market_open', true)
                ->orderBy('timestamp_id', 'desc')
                ->get();
        }

        if ($prices->isEmpty()) {
            return response()->json(['success' => true, 'data' => []], 200);
        }

        // Extract timestamps from price data
        $timestamps = $prices->pluck('timestamp_id')->toArray();

        $currency_prefix = 'us';
        if ($currency == 'eur') {
            $currency_prefix = 'eur';
        } else if ($currency == 'cad') {
            $currency_prefix = 'cad';
        }
        // Fetch currency rates for these timestamps
        $currencyRates = DB::table('ic_historical_rate')
            ->whereIn('timestamp', $timestamps)
            ->pluck($currency_prefix . '_rate', 'timestamp');

        // Attach currency rate to each price entry
        $pricesWithRates = $prices->map(function ($price) use ($currencyRates, $currentCurrencyRate) {
            $price->currency_rate = $currencyRates[$price->timestamp_id] ?? $currentCurrencyRate;
            return $price;
        });

        return response()->json(['success' => true, 'data' => $pricesWithRates], 200);
    }
}
