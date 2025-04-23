<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Models\User;
use Carbon\Carbon;

class RecentOrdersController extends Controller
{
    function getView(Request $request){
        if(auth()->user()){
            $start = $request->start ? Carbon::createFromFormat('d/m/Y', $request->start)->startOfDay() : Carbon::now()->subDays(1);
            $end = $request->end ? Carbon::createFromFormat('d/m/Y', $request->end)->endOfDay() : Carbon::now()->endOfDay();
            $allOrders = Helper::getRecentOrders($start, $end);
            $now = $end->lte(Carbon::now());
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
            return view('recent-orders')->with('orders',$orders)->with('start', $ini)->with('end', $end ? $last : null)->with('now', $now);
        } else {
            return redirect("/admin/login");
        }
    }
}
