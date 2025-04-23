<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use App\Models\User;
use App\Models\Status;

class PendingPaymentsController extends Controller {
    function getView() {
        if (auth()->user()) {
            $allOrders = ProductOrder::where('status_id', 1)->get();
            $allUsers = [];
            foreach ($allOrders as $order) {
                $allUsers[] = $order->user_id;
            }
            $statuses = Status::where('type', 'transaction')->get();
            $orders = [];
            foreach (array_unique($allUsers) as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $orders[$userId] = [];
                    $orders[$userId]['id'] = $user->id;
                    $orders[$userId]['name'] = $user->name_for_admins;
                    $orders[$userId]['email'] = $user->email;
                    foreach ($allOrders as $order) {
                        if ($order->user_id == $userId) {
                            $orders[$userId]['items'][] = $order;
                        }
                    }
                }else{
                    $orders[$userId] = [];
                    $orders[$userId]['id'] = $userId;
                    $orders[$userId]['name'] = "Deleted User";
                    $orders[$userId]['email'] = "Deleted User";
                    foreach ($allOrders as $order) {
                        if ($order->user_id == $userId) {
                            $orders[$userId]['items'][] = $order;
                        }
                    }
                
                }
            }
            return view('pending-payments')->with('orders', $orders)->with('statuses', $statuses);
        } else {
            return redirect("/admin/login");
        }
    }
}
