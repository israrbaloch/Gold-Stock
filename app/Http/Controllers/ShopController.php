<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentOptions;
use App\Enums\ShippingStatus;
use App\Models\Fedex;
use App\Helper\Helper;
use App\Mail\AdminProductTransactionCompletedMail;
use App\Mail\UserProductTransactionCompletedMail;
use App\Models\Currency;
use App\Models\DepositOrder;
use App\Models\OrderProduct;
use App\Models\ProductOrder;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CashWithdrawal;
use App\Models\DepositOrderPayment;
use App\Models\ShippingOption;
use App\Models\User;
use Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ShopController extends Controller {

    public function buyProducts(Request $request) {
        Log::info(json_decode($request->getContent(), true));
        $dataCard = $request->datacard ? $request->datacard : null;

        if (!Auth::check()) {
            return response()->json(array('success' => false, 'msg' => 'You must be logged in to buy products'), 401);
        }

        Log::info(`User: ` . Auth::user()->id);
        if ($request->hasCookie('_cartid')) {
            Log::info(`hasCookie: ` . $request->hasCookie('_cartid'));
            Cart::session(Cookie::get('_cartid'));
        }

        $products = Cart::getContent();
        Log::info(`products: ` . $products);
        $fee = 0;
        $countProducts = count($products);
        Log::info(`countProducts: ` . $countProducts);
        if ($countProducts == 0) {
            return response()->json(array('success' => false, 'msg' => 'Empty=> ' . $products), 200);
        }

        $fedex_service = $request->fedex_name;
        Log::info(`fedex_service: ` . $fedex_service);

        $fedex_price = $request->fedex_price ? $request->fedex_price : 0;
        Log::info(`fedex_service: ` . $fedex_service);

        $currency = Currency::where('currencies.code', $request->currency)->first();
        Log::info(`currency: ` . $currency);
        if (!$currency) {
            return response()->json(array('success' => false, 'msg' => 'Currency not found'), 404);
        }

        $userCashDepositBalance = Helper::getCashDepositUserBalance(Auth::user()->id, $currency->code);
        Log::info('userBalance: ' . json_encode($userCashDepositBalance));

        $userCashBalance = $userCashDepositBalance['total'] > 0 ? $userCashDepositBalance['total'] : 0;
        Log::info(`userCashBalance: ` . $userCashBalance);

        $price = $fedex_price + Cart::getTotal();
        Log::info(`price: ` . $price);

        // Create Order
        $productOrder = new ProductOrder();
        $productOrder->user_id = Auth::user()->id;
        $productOrder->shipping_option_id = $request->delivery_option;
        $productOrder->status_id = OrderStatus::PENDING;
        $productOrder->notes = $request->notes;
        $productOrder->by_admin = 0;
        $productOrder->currency_id = $currency->id;
        $productOrder->save();

        // Create deposit order
        $depositOrder = new DepositOrder();
        $depositOrder->order_type = "Shop";
        $depositOrder->table_name = "product_orders";
        $depositOrder->order_id = $productOrder->id;
        $depositOrder->save();

        $pricecc = 0;

        if ($dataCard == null || $dataCard == '') {
            $cashWithdrawal = new CashWithdrawal();
            $cashWithdrawal->user_id = Auth::user()->id;
            $cashWithdrawal->currency_id = $currency->id;
            $cashWithdrawal->payment_method_id = PaymentOptions::BALANCE;
            $cashWithdrawal->status_id = OrderStatus::PAID;
            $cashWithdrawal->order_id = $productOrder->id;

            $depositOrderPay = new DepositOrderPayment();
            $depositOrderPay->deposit_order_id = $depositOrder->id;
            $depositOrderPay->currency_id = $currency->id;
            $depositOrderPay->value = $cashWithdrawal->value;

            if ($price < $userCashBalance) {
                $cashWithdrawal->value = $price;
                $depositOrderPay->payment_method_id = PaymentOptions::BALANCE;
                $productOrder->status_id = OrderStatus::PAID;
                $productOrder->save();
            } else {
                $cashWithdrawal->value = $userCashBalance;
                $depositOrderPay->payment_method_id = PaymentOptions::BALANCE;
            }
            $depositOrderPay->save();
            $cashWithdrawal->save();
        } else {
            // Payment Page

            // Just charge 10% of the total price
            $pricecc = ($price * 0.10);

            // Calculate fee
            $fee = $pricecc * 0.0375;

            // If the user has enough balance, charge the total price
            if ($userCashBalance > 0) {

                // Create cash withdrawal
                $cashWithdrawal = new CashWithdrawal();
                $cashWithdrawal->user_id = Auth::user()->id;
                $cashWithdrawal->currency_id = $currency->id;
                $cashWithdrawal->value = $userCashBalance;
                $cashWithdrawal->payment_method_id = PaymentOptions::BALANCE;
                $cashWithdrawal->status_id = OrderStatus::PAID;
                $cashWithdrawal->order_id = $productOrder->id;
                $cashWithdrawal->save();

                // Create deposit order payment
                $depositOrderPay = new DepositOrderPayment();
                $depositOrderPay->deposit_order_id = $depositOrder->id;
                $depositOrderPay->currency_id = $currency->id;
                $depositOrderPay->value = $userCashBalance;
                $depositOrderPay->payment_method_id = PaymentOptions::BALANCE;
                $depositOrderPay->save();
            }
            $depositOrderPay = new DepositOrderPayment();
            $depositOrderPay->deposit_order_id = $depositOrder->id;
            $depositOrderPay->currency_id = $currency->id;
            // Charge the remaining amount
            $depositOrderPay->value = $pricecc - ($userCashBalance > 0 ? $userCashBalance : 0);
            $depositOrderPay->payment_method_id = PaymentOptions::CREDIT_CARD;
            $depositOrderPay->save();

            $productOrder->status_id = OrderStatus::PENDING;
            $productOrder->save();
        }

        if ($request->delivery_option == 1) {
            // When is 'Delivery'
            $fedex = new Fedex();
            $fedex->order_id = $depositOrderPay->id;
            $fedex->service = $fedex_service;
            $fedex->price = $fedex_price;
            $fedex->currency = $currency->code;
            $fedex->save();
            $productOrder->shipping_status_id = ShippingStatus::PENDING;
        } else {
            // When is 'Pickup' or 'Add to Storage'
            $productOrder->shipping_status_id = ShippingStatus::IN_STORAGE;
        }
        $productOrder->save();

        $orderProductsList = [];
        foreach ($products as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $productOrder->id;
            $orderProduct->product_id = $product->id;
            $orderProduct->quantity = $product->quantity;
            $orderProduct->price = $product->price;
            $orderProduct->currency_id = $currency->id;
            $orderProduct->save();
            $orderProductsList[] = $orderProduct;
        }

        $shipping_options = ShippingOption::where('id', $request->delivery_option)->first();
        if (!$shipping_options) {
            return response()->json(array('success' => false, 'msg' => 'Shipping option not found'), 404);
        }
        $accountUser = Account::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        if (!$accountUser) {
            return response()->json(array('success' => false, 'msg' => 'Account not found'), 404);
        }

        $total = Cart::getTotal();

        $data = [
            'fname' => Auth::user()->name,
            'email' => Auth::user()->email,
            'account_number' => $accountUser->number,
            'address' => $accountUser->address_line1,
            'city' => $accountUser->city,
            'phone' => $accountUser->phone,
            'products' => $orderProductsList,
            'currency' => $currency->code,
            'totalprice' => $total,
            'ordertype' => "Shop",
            'orderid' => $productOrder->order_id,
            'orderDate' => $productOrder->created_at,
            'shipping_options' => $shipping_options->name,
            'fedex_service' => $fedex_service,
            'fedex_price' => $fedex_price,
            'metalOrder' => $productOrder->id,
            'pending' => $total - $depositOrderPay->value,
            'due' => $depositOrderPay->value,
            'fee' => $fee,
            'pricecc' => $pricecc,
        ];
        if (config('app.env') != 'testing') {
            Mail::to(Auth::user()->email)->send(new UserProductTransactionCompletedMail($data));
            $admins = User::whereIn('role_id', [1])->pluck('email');
            Mail::to($admins)->send(new AdminProductTransactionCompletedMail($data));
        }
        Cart::clear();
        return response()->json(array('success' => true, 'msg' => '', 'item_type' => 'product', 'order_id' => $productOrder->id), 200);
    }
}
