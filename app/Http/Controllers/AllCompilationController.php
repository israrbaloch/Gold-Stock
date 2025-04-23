<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Models\User;
use App\Models\Account;
use App\Models\CashDeposit;
use App\Models\MetalDeposit;
use App\Models\CashWithdrawal;
use App\Models\MetalWithdrawal;
use Carbon\Carbon;

class AllCompilationController extends Controller
{
    function getView(Request $request){
        if(auth()->user()){
            $start = $request->start ? Carbon::createFromFormat('d/m/Y', $request->start)->startOfDay() : Carbon::now()->subDays(1);
            $end = $request->end ? Carbon::createFromFormat('d/m/Y', $request->end)->endOfDay() : Carbon::now()->endOfDay();
            $allOrders = Helper::getRecentOrders($start, $end);
            $now = $end->lte(Carbon::now());
            $accounts = Account::all();
            $orders = [];
            $i = 0;
            foreach($allOrders as $order){
                $user = User::find($order['user_id']);
                $orders[$i] = $order;
                $orders[$i]['name'] = $user->name_for_admins;
                $orders[$i]['email'] = $user->email;
                $i++;
            }
            usort($orders, function($x, $y) {
                return $y['created_at'] <=> $x['created_at'];
            });
            $ini = $request->start ? $start : date_format($start, 'g:i A\, Y-m-d');
            $last = $request->end ? $end : date_format($end, 'g:i A\, Y-m-d');
            // dd($usersbalances);
            return view('daily-activity')->with('orders',$orders)->with('start', $ini)->with('end', $end ? $last : null)->with('now', $now)->with('accounts', $accounts);
        } else {
            return redirect("/admin/login");
        }
    }
    
    function getUserOrders(Request $request){
        $account = Account::find($request->acc_id);
        $orders = $account->orders;
        usort($orders, function($x, $y) {
            return $y['created_at'] <=> $x['created_at'];
        });
        return response()->json(array('success' => true, 'user_data' => $orders, 'action' => 'orders', 'name_for_admins' => $account->name_for_admins), 200);
    }
    
    function getUserBalances(Request $request){
        $account = Account::find($request->acc_id);
        $balances = $account->balances;
        return response()->json(array('success' => true, 'user_data' => $balances, 'action' => 'balances', 'name_for_admins' => $account->name_for_admins), 200);
    }
    
    function getUserDeposits(Request $request){
        $account = Account::find($request->acc_id);
        $cash_depo = CashDeposit::where('user_id', $account->user_id)->get()->toArray();
        $metal_depo = MetalDeposit::where('user_id', $account->user_id)->get()->toArray();
        $userData = array_merge($cash_depo, $metal_depo);
        usort($userData, function($x, $y) {
            return $y['created_at'] <=> $x['created_at'];
        });
        return response()->json(array('success' => true, 'user_data' => $userData, 'action' => 'deposits'), 200);
    }
    
    function getUserWithdrawals(Request $request){
        $account = Account::find($request->acc_id);
        $cash_with = CashWithdrawal::where('user_id', $account->user_id)->whereNull('order_id')->whereNull('metal_order_id')->get()->toArray();
        $metal_with = MetalWithdrawal::where('user_id', $account->user_id)->whereNull('order_id')->whereNull('metal_order_id')->get()->toArray();
        $userData = array_merge($cash_with, $metal_with);
        usort($userData, function($x, $y) {
            return $y['created_at'] <=> $x['created_at'];
        });
        return response()->json(array('success' => true, 'user_data' => $userData, 'action' => 'withdrawals'), 200);
    }
}
