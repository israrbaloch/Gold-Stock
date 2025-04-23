<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Metal;
use App\Helper\Helper;
use App\Mail\UserWithdrawalConfirmationMail;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\CashWithdrawal;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CashWhitdrawalController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    function getView(Request $request) {
        $currency = $request->currency;
        $userid = auth()->user()->id;
        $userBalance = $userid ? Helper::getUserBalances($userid) : null;
        //dd($userBalance);
        return view('whitdrawal-cash')->with('userBalance', $userBalance)->with('currency', $currency);
    }

    function saveWhitdrawal(Request $request) {
        $currency = Currency::where('currencies.code', $request->cash)->first();
        $whitdrawal = new CashWithdrawal();
        $whitdrawal->user_id = auth()->user()->id;
        $whitdrawal->currency_id = $currency->id;
        $whitdrawal->value = $request->value;
        $whitdrawal->payment_method_id = $request->withdraw_option;
        $whitdrawal->status_id = $request->confirmed_status;
        $whitdrawal->bank_address = $request->bank_address;
        $whitdrawal->account_number = $request->account_number;
        $whitdrawal->institution_number = $request->institution_number;
        $whitdrawal->transit_number = $request->transit_number;
        $whitdrawal->bank_name = $request->bank_name;
        $whitdrawal->save();

        $data = array(
            'fname' => auth()->user()->name,
            'email' => auth()->user()->email,
            'date' => Carbon::now()->format('d-m-Y'),
            'ordertype' => 'Cash',
            'curr_or_metal' => $currency->code,
            'total' => $request->value,
        );
        if (config('app.env') != 'testing') {
            Mail::to($data['email'])->send(new UserWithdrawalConfirmationMail($data));
            $emails = User::whereIn('role_id', [1])->pluck('email');
            Mail::to($emails)->send(new UserWithdrawalConfirmationMail($data));
        }
        return response()->json(array('success' => true), 200);
    }

    function whitdraw() {
        $metals = Metal::all();
        $metals = $metals->toArray();
        return view('withdraw')->with('metals', $metals);
    }
}
