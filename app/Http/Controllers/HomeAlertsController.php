<?php

namespace App\Http\Controllers;

use App\Models\Alert;

class HomeAlertsController extends Controller {
    function getView() {
        $alerts = Alert::all();
        // dd($data);
        return view('home-alerts')->with('homeAlerts', $alerts);
    }
}
