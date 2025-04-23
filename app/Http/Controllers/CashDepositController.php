<?php

namespace App\Http\Controllers;

use App\Models\Metal;
use App\Helper\Helper;
use App\Mail\UserDepositConfirmationMail;
use App\Models\Currency;
use App\Models\CashDeposit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Cart;
use Cookie;
use Illuminate\Support\Facades\Mail;

class CashDepositController extends Controller {

    function getView(Request $request) {
        $currency = $request->currency;
        Cookie::queue('currency', $currency);
        $userId = auth()->user()->id;
        $account = \App\Models\Account::where('user_id', $userId)->orderBy('id', 'desc')->first();
        $userBalance = $userId > 0 ? Helper::getCashDepositUserBalance($userId, $currency) : null;
        // dd($userBalance);
        return view('deposit-cash')->with('userBalance', $userBalance)->with('userId', $userId)->with('account', $account);
    }

    function saveDeposit(Request $request) {
        $userId = $request->user_id;
        $user = User::find($userId);
        if (!Auth::check())
            Auth::login($user);

        if ($request->tfrom == 'cart') {
            Cart::session(Cookie::get('_cartid'));
            $deposits = json_decode($request->products);
            if ($deposits) {
                foreach ($deposits as $product) {
                    // $metalName = $product->name;
                    // $qtymetal = $product->quantity;
                    $price = $product->price;
                    $cartCurrency = $product->currency;
                }
                $currency = Currency::where('currencies.code', $cartCurrency)->first();
                $deposit = new CashDeposit();
                $deposit->user_id = $userId;
                $deposit->currency_id = $currency->id;
                $deposit->value = $price;
                $deposit->status_id = 2;
                $deposit->payment_method_id = 3;
                $deposit->save();
                Cart::clear();
                return response()->json(array('success' => true, 'item_type' => 'cash', 'msg' => '', 'order_id' => $deposit->id), 200);
            } else {
                return response()->json(array('success' => false, 'msg' => ''), 200);
            }
        } else {
            $currency = Currency::where('currencies.code', $request->currency)->first();
            $deposit = new CashDeposit();
            $deposit->user_id = auth()->user()->id;
            $deposit->currency_id = $currency->id;
            $deposit->value = $request->value_to_be_confirmed;
            $deposit->status_id = $request->confirmed_status;
            $deposit->payment_method_id = $request->option_selected;
            $deposit->save();

            $data = array(
                'fname' => auth()->user()->name,
                'email' => auth()->user()->email,
                'date' => Carbon::now(),
                'ordertype' => 'Cash',
                'curr_or_metal' => $currency->code,
                'total' => $request->value_to_be_confirmed,
            );
        }

        Mail::to($data['email'])->send(new UserDepositConfirmationMail($data));
        $admins = User::whereIn('role_id', [1])->pluck('email');
        Mail::to($admins)->send(new UserDepositConfirmationMail($data));
        return response()->json(array('success' => true), 200);
    }

    function deposit() {
        $metals = Metal::all();
        $metals = $metals->toArray();
        return view('deposit')->with('metals', $metals);
    }

    function depositCoin() {
        return view('deposit-coin');
    }
}
