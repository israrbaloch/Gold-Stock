<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;

use App\Models\ProductOrder;
use App\Models\User;
use App\Models\Status;
use App\Models\Fedex;

class PendingShippingsController extends Controller {
    function getView() {
        if (auth()->user()) {
            $allOrders = ProductOrder::where('shipping_option_id', 1)->whereIn('shipping_status_id', [3, 6])->get();
            $allUsers = [];
            foreach ($allOrders as $order) {
                $allUsers[] = $order->user_id;
            }
            $statuses = Status::where('type', 'shipping')->get();
            $orders = [];
            foreach (array_unique($allUsers) as $userId) {
                $user = User::find($userId);
                $orders[$userId] = [];
                $orders[$userId]['id'] = $user->account_number;
                $orders[$userId]['name'] = $user->name_for_admins;
                $orders[$userId]['email'] = $user->email;
                foreach ($allOrders as $order) {
                    if ($order->user_id == $userId) {
                        $orders[$userId]['items'][] = $order->toArray();
                    }
                }
            }
            return view('shippings')->with('orders', $orders)->with('statuses', $statuses);
        } else {
            return redirect("/admin/login");
        }
    }

    function updateShippingStatus(Request $request) {
        $order = ProductOrder::find($request->order_id);
        $order->shipping_status_id = $request->shipping_status;
        $order->save();

        if ($request->fedex_id != "") {
            $fedex = Fedex::find($request->fedex_id);
            $fedex->tracking_number = $request->tracking_number;
            $fedex->save();
        }
        return response()->json(array('success' => true), 200);
    }
}
