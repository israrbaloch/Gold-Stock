<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\ProductOrder;
use App\Models\MetalOrder;
use Auth;
use Illuminate\Support\Facades\Log;

class OrderHistoryController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    function getView() {
        $account = Account::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();
        if ($account) {
            $userID = Auth::user()->id;
            //$deposits = $userID ? Helper::OrderHistory($userID) : null;
            $productOrders = ProductOrder::where('user_id', $userID)
                ->with('shippingOption')
                ->get();
            $metalOrders = MetalOrder::where('user_id', $userID)->get();

            $deposits = array_merge($productOrders->toArray(), $metalOrders->toArray());
            usort($deposits, function ($x, $y) {
                return $y['created_at'] <=> $x['created_at'];
            });
            return view('orders.index')
                ->with('deposits', $deposits);
        } else {
            Log::info("Account not found for user: " . auth()->user()->id);
            return redirect()->route('profile');
        }
    }

    // function getDetailOrder($product, $depositOrderID) {
    //     if ($product != 'Gold' || $product != 'Silver' || $product != 'Platinum' || $product != 'Palladium') {
    //         $productDetail = Helper::getProductOrderDetail($depositOrderID);
    //     } else {
    //         $productDetail = Helper::getMetalOrderDetail($depositOrderID);
    //     }
    //     return $productDetail;
    // }
}
