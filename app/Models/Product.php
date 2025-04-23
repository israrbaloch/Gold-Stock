<?php

namespace App\Models;

use App\Helper\HistoricalHelper;
use Illuminate\Database\Eloquent\Model;
use App\Helper\ProductsHelper;
use Illuminate\Support\Facades\DB;
use Cookie;

use App\Models\Metal;
use Log;

class Product extends Model
{
    protected $table = "products";

    protected $appends = [
        'real_price',
        'weight_oz',
        'metal_name',
        'url_name'
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'in_stock' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->perPage = request()->input('show') ?? 10;
    }

    // reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    public function getImageAttribute()
    {
        $imagesData = json_decode($this->images);

        // Check if the decoded value is an array
        if (is_array($imagesData)) {
            // Select the first image in the array
            $image = $imagesData[0];
            // Replace backslashes with forward slashes in the image path and prepend the 'storage/' directory
            return '/storage/' . str_replace('\\', '/', $image);
        } else {
            // Assume the decoded value is a comma-separated list of image paths
            $exp = explode(',', $this->images);
            // Select the first image in the list
            return  $exp[0];
        }
    }

    public function getRealPriceAttribute()
    {
        $_currency = Cookie::get('currency') ?: 'cad';
        $_metals = HistoricalHelper::getCurrentMetalPrices();
        $_currencies = HistoricalHelper::getCurrentCurrencyPrices();

        $metalPrice = 0;
        switch ($this->metal_id) {
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

        $weight = ProductsHelper::getOzNumberWeight($this->weight);
        $price  = $weight * $metalPrice * $_currencies[strtolower($_currency)]->value;

        // dd($price);

        // $price = $price + $this->percent_interval_cc_1 / 100 * $price;
        $price = $price + $this->percent_interval_1;
        return round($price, 2);
    }

    // original_price
    public function getOriginalPriceAttribute()
    {
        $_currency = Cookie::get('currency') ?: 'cad';
        $_metals = HistoricalHelper::getCurrentMetalPrices();
        $_currencies = HistoricalHelper::getCurrentCurrencyPrices();

        $metalPrice = 0;
        switch ($this->metal_id) {
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

        $weight = ProductsHelper::getOzNumberWeight($this->weight);
        $price  = $weight * $metalPrice * $_currencies[strtolower($_currency)]->value;

        return $price;

        // $price = $price + $this->percent_interval_1 / 100 * $price;
    }

    // price in passed currency
    public function CurrencyPrice($currency)
    {
        $_currency = $currency;
        $_metals = HistoricalHelper::getCurrentMetalPrices();
        $_currencies = HistoricalHelper::getCurrentCurrencyPrices();

        $metalPrice = 0;
        switch ($this->metal_id) {
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

        $weight = ProductsHelper::getOzNumberWeight($this->weight);
        $price  = $weight * $metalPrice * $_currencies[strtolower($_currency)]->value;

        $price = $price + $this->percent_interval_1;

        return round($price, 2);
    }

    // getPaymentMethodPrice
    public function PaymentMethodPrice($percent_interval)
    {
        $price = $this->original_price;

        // $price = $price + $this->{$percent_interval} / 100 * $price;
        $price = $price + $this->{$percent_interval};

        return round($price, 2);
    }

    public function getWeightOzAttribute()
    {
        $tweight = $this->weight;
        $number_weight = ProductsHelper::getOzNumberWeight($tweight);
        return $number_weight;
    }

    public function getMetalNameAttribute()
    {
        $metal_name = Metal::select('name')->find($this->metal_id)->name;
        return $metal_name;
    }

    public function getUrlNameAttribute()
    {
        $searchVal =    array(" ", ":", "/", "?", "#", "[", "]", "@", "!", "$", "&", "*", "+", ",", ";", "%");
        $replaceVal =   array("-", "",  "",  "",  "",  "",  "",  "",  "", "-",  "", "",  "-", "-", "", "");

        return strtolower(str_replace($searchVal, $replaceVal, $this->name));
    }
}
