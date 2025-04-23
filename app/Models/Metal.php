<?php

namespace App\Models;

use App\Helper\HistoricalHelper;
use App\Http\Controllers\AjaxPricesController;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Metal extends Model {
    protected $table = "metals";

    protected $appends = ['real_price'];

    public function getRealPriceAttribute() {
        $table = 'ic_historical_price_' . $this->code;
        $price = DB::table($table)->orderBy('id', 'desc')->limit(1)->get()->toArray();
        return $price;
    }

    public function CurrencyPrice($currency)
    {
        $_currency = $currency;
        $_metals = HistoricalHelper::getCurrentMetalPrices();
        $_currencies = HistoricalHelper::getCurrentCurrencyPrices();

        $metalPrice = 0;
        switch ($this->id) {
            case 1183:
                $metalPrice = $_metals['gold']->value;
                break;
            case 1677:
                $metalPrice = $_metals['silver']->value;
                break;
            case 1681:
                $metalPrice = $_metals['platinum']->value;
                break;
            case 1682:
                $metalPrice = $_metals['palladium']->value;
                break;
        }

        return round($metalPrice * $_currencies[strtolower($_currency)]->value, 2);
    }

    // currentChange
    public function currentChange()
    {
        $_metals = HistoricalHelper::getCurrentMetalPrices();
        // $_currencies = HistoricalHelper::getCurrentCurrencyPrices();

        $metalPrice = 0;
        switch ($this->id) {
            case 1183:
                // dd($_metals['gold']);
                $metalPrice = $_metals['gold']->change_percent;
                break;
            case 1677:
                $metalPrice = $_metals['silver']->change_percent;
                break;
            case 1681:
                $metalPrice = $_metals['platinum']->change_percent;
                break;
            case 1682:
                $metalPrice = $_metals['palladium']->change_percent;
                break;
        }

        return $metalPrice;

    }

}
