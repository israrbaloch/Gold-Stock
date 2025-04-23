<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentTypesController extends Controller
{
    //index
    public function index()
    {
        return view('payment-types.index');
    }
}
