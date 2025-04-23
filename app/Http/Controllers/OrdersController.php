<?php

namespace App\Http\Controllers;

use App\Enums\PaymentOptions;
use App\Models\ProductOrder;
use App\Models\MetalOrder;
use \App\Models\CashDeposit;
use App\Models\Currency;
use App\Models\Metal;
use App\Models\ShippingOption;
use Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller {

    public function index($type, $id) {

        // dd($type, $id);
        if ($type == 'product') {
            $order = ProductOrder::find($id);
            $orderProducts = DB::table('order_products')
                ->where('order_products.order_id', $id)
                ->join('products', 'order_products.product_id', 'products.id')
                ->select('order_products.*', 'products.images', 'products.name AS name')
                ->get();
        } else {
            $order = CashDeposit::find($id);
            $orderProducts['currency'] = Currency::find($order->currency_id)->code;
            $orderProducts['name'] = $orderProducts['currency'] . ' Cash Deposit';
        }

        Log::info("Order: " . $order);
        $shippingOption = ShippingOption::where('id', $order->shipping_option_id)->first();
        Log::info($orderProducts);

        $paymentMethodName = PaymentOptions::getOption($order->payment_method);

        // dd($paymentMethodName);
        if (Auth::user() && $order && Auth::user()->id == $order->user_id) {
            return view('order.index')
                ->with('type', $type)
                ->with('order', $order)
                ->with('products', $orderProducts)
                ->with('paymentMethodName', $paymentMethodName)
                ->with('shippingOption', $shippingOption);
        } else {
            return redirect()
                ->route('login');
        }
    }

}
