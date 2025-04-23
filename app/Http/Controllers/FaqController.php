<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller {
    function getView() {
        return view('faq');
    }
}
