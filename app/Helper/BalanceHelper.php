<?php

namespace App\Helper;

use Auth;
use Cookie;


class BalanceHelper {

    /**
     * Get user balances
     *
     * @param [type] $userId
     * @return void
     */
    static function getUserBalances() {
        $user = Auth::user();
        $userBalances = [];
        $userBalances['cash'] = 0;
        $userBalances['gold'] = 0;
        $userBalances['silver'] = 0;
        $userBalances['platinum'] = 0;
        $userBalances['palladium'] = 0;

        if (!$user) {
            return $userBalances;
        }

        $currency = Cookie::get('currency');

        $balances = Helper::getUserBalances($user->id);
        if ($balances) {
            foreach ($balances['cash'] as $cashBalance) {
                if ($cashBalance->currency == $currency) {
                    $userBalances['cash'] = $cashBalance->total;
                }
            }
            if (count($balances['metals']) > 0) {
                $metalsArray = (array)$balances['metals'];
                foreach ($metalsArray as $metal) {
                    $userBalances[strtolower($metal->metalName)] = $metal->total;
                }
            }
        }
        return $userBalances;
    }
}
