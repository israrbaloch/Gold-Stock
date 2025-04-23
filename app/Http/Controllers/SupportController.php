<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller {
    function getView() {
        return view('support');
    }
}
