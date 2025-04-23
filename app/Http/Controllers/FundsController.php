<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Account;
use App\Models\Metal;
use \App\Models\Currency;
use Illuminate\Http\Request;

class FundsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function getView() {
        $account = Account::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();

        if ($account) {
            $userid = auth()->user()->id;
            $userBalance = [];
            $currencies = Currency::all();
            $metals = Metal::all();
            foreach ($account->balances['metals'] as $metal) {
                $userBalance['metals'][$metal['metalName']] = $userid ? $metal['total'] : null;
            }
            foreach ($account->balances['cash'] as $currency) {
                $userBalance['cash'][$currency['currency']] = $userid ? $currency['total'] : null;
            }

            return view('funds.index')->with('userBalance', $userBalance ? $userBalance : null)->with('currencies', $currencies)->with('metals', $metals);
        } else {
            return redirect()->route('profile');
        }
    }
}
