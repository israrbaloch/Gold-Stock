<?php

namespace App\Http\Controllers;

use App\Models\ScrapCommission;
use Illuminate\Http\Request;

class ScarpCalculatorContoller extends Controller
{
    //index
    public function index()
    {
        $commission = ScrapCommission::firstOrCreate([]);
        return view('scrap-calculator', compact('commission'));
    }
}
