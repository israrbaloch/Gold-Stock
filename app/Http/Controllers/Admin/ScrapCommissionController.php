<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScrapCommission;
use Illuminate\Http\Request;

class ScrapCommissionController extends Controller
{
    //index and update
    public function index()
    {
        // manage_scrap_commission
        if (!auth()->user()->hasPermission('manage_scrap_commission')) {
            abort(403, 'You do not have permission to manage Orders');
        }
        $commission = ScrapCommission::firstOrCreate([]);

        return view('admin.scrap-commission.index', compact('commission'));
    }

    public function update(Request $request)
    {
        // manage_scrap_commission
        if (!auth()->user()->hasPermission('manage_scrap_commission')) {
            abort(403, 'You do not have permission to manage Orders');
        }

        $request->validate([
            'gold' => 'required|numeric|min:0|max:100',
            'silver' => 'required|numeric|min:0|max:100',
            'platinum' => 'required|numeric|min:0|max:100',
            'palladium' => 'required|numeric|min:0|max:100',
        ]);

        $scrapCommission = ScrapCommission::firstOrCreate([]);
        $scrapCommission->update($request->all());
        // update
        return redirect()->route('admin.scrap-metals-commission')->with('success', 'Scrap commission updated successfully.');
    }
}
