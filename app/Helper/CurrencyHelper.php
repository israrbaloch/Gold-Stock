<?php

namespace App\Helper;

use App\DTO\CurrencyWebSocketDTO;
use Cache;


class CurrencyHelper {


    static function getCurrency($currency) {
        switch (strtolower($currency)) {
            case 'usd':
                return  new CurrencyWebSocketDTO([
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
            case 'cad':
                return Cache::get('exchange_cad');
            case 'eur':
                return Cache::get('exchange_eur');
        }
        throw new \Exception("Currency not found: $currency");
    }
}
