<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller {
    function getSalesPolicyView() {
        return view('policy.sales');
    }
    function getCookiesPolicyView() {
        return view('policy.cookies');
    }
    function getECommercePolicyView() {
        return view('policy.ecommerce');
    }
    function getDisclaimerPolicyView() {
        return view('policy.disclaimer');
    }
    function getPrivacyPolicyView() {
        return view('policy.privacy');
    }
    function getTermsPolicyView() {
        return view('policy.terms');
    }
    function getUsePolicyView() {
        return view('policy.use');
    }
}
