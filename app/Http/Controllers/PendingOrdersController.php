<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MetalOrder;
use App\Models\ProductOrder;
use App\Helper\Helper;

class PendingOrdersController extends Controller
{
    function getView()
    {
        if(auth()->user()){
            $productOrders = Helper::ProductOrderHistory();
            $metalOrders = Helper::MetalOrderHistory();
            $orderscompletes = [];
            $orderspendingpay = [];
            $orderpendingship = [];
    //        dd($orders);
            foreach ($productOrders as $order) {
                if ($order['status_id'] == 1) {
                    $orderspendingpay[] = $order;
                } elseif ($order['status_id'] == 2) {
                    $orderscompletes[] = $order;
                } elseif ($order['shipping_status_id'] == 3) {
                    $orderpendingship[] = $order;
                }
            }
            foreach ($metalOrders as $order) {
                if ($order['status_id'] == 1) {
                    $orderspendingpay[] = $order;
                } elseif ($order['status_id'] == 2) {
                    $orderscompletes[] = $order;
                } elseif ($order['shipping_status_id'] == 3) {
                    $orderpendingship[] = $order;
                }
            }
            $data = array_merge($metalOrders, $productOrders);
            usort($data, function($x, $y) {
                return $y['created_at'] <=> $x['created_at'];
            });

            //dd($orderspendingpay);

            return view('pending-orders')->with('orders', $data)->with('orderscompletes', $orderscompletes)
                ->with('orderspendingpay', $orderspendingpay)->with('orderpendingship', $orderpendingship);
        } else {
            return redirect("/admin/login");
        }
    }
}
