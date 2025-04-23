<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

class CalculatorController extends Controller {
    function getView(Request $request) {
        $curr = $request->currency ? $request->currency : Cookie::get('currency');
        $controller = new AjaxPricesController();

        $bprices = $controller->getPrices();
        $prices = $controller->getMetalInfo($bprices, $curr);
        $calc_minus_percent = $controller->getAdditionalPercent();

        return view('calculator')->with('prices', $prices)->with('active_currency', $curr)->with('calc_minus_percent', $calc_minus_percent);
    }
}
