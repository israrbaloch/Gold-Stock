<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AjaxPricesController;
use App\Models\Metal;

class HoldingsController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    function getView(Request $request) {
        $currencies = ['CAD', 'USD', 'EUR'];
        $allMetals = Metal::get();
        foreach ($allMetals as $metal) {
            $metals[$metal->code] = $metal->id;
        }
        $tableNames = ['Gold' => 'gold', 'Silver' => 'silver', 'Platinum' => 'plat', 'Palladium' => 'pall'];
        $metal = $request->metal;
        $userId = auth()->user()->id;
        $total = Helper::getMetalBalances($userId, $metals[strtolower($tableNames[$request->metal])]);
        $controller = new AjaxPricesController();
        $price = $controller->getPrices('ic_historical_price_' . $tableNames[$metal], 1);
        $prices = [];
        foreach ($currencies as $currency) {
            $prices[$currency] = $this->getExchange($currency, $price['metalprices'][0]->bid);
        }
        $value = [];
        foreach ($currencies as $currency) {
            $value[$currency] =  $prices[$currency] * $total;
        }
        return view('holdings')->with('total', $total)->with('value', $value)->with('metal', strtolower($request->metal));
    }

    public function getRates() {
        $rates = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();
        return $rates;
    }

    public function getExchange($currency, $price) {
        $rate = $this->getRates();
        $fieldstochange = array('current_value', 'change_value', 'ask', 'bid', 'daily_lowest', 'daily_highest');


        if ($currency == 'USD') {
            $ratevalue = $rate->us_rate;
        } else if ($currency == 'EUR') {
            $ratevalue = $rate->eur_rate;
        } else if ($currency == 'CAD') {
            $ratevalue = $rate->cad_rate;
        }

        $val = $price * $ratevalue;

        return $val;
    }
}
