<?php

namespace App\Http\Controllers;

use App\Enums\PaymentOptions;
use App\Enums\ShippingStatus;
use App\Helper\Helper;
use App\Mail\AdminProductTransactionCompletedMail;
use App\Mail\OrderConfirmMail;
use App\Mail\OrderPendingPaymentMail;
use App\Mail\UserProductTransactionCompletedMail;
use App\Models\Account;
use App\Models\Currency;
use App\Models\DepositOrder;
use App\Models\DepositOrderPayment;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Province;
use App\Models\ShippingOption;
use App\Models\User;
use Cart;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mail;

class PaymentController extends Controller {

    public function preload(Request $request) {

        if (app()->environment('production')) {
            $store_id = config('services.moneris.store');
            $api_token = config('services.moneris.token');
            $checkout = config('services.moneris.checkout');
            $env = "prod";
        } else {
            $store_id = config('services.moneris.test.store');
            $api_token = config('services.moneris.test.token');
            $checkout = config('services.moneris.test.checkout');
            $env = "qa";
        }

        Log::info($_POST);
        $account = Account::where('user_id', Auth::user()->id)->first();
        if ($account == null) {
            Log::info("Account not found");
            return response()->json(404);
        }

        $email = Auth::user()->email;
        if ($email == null) {
            Log::info("Email not found");
            return response()->json(404);
        }
        $first_name = $account->fname;
        $last_name = $account->lname;
        $phone = $account->phone;

        if ($request->hasCookie('_cartid')) {
            Log::info('hasCookie: ' . $request->hasCookie('_cartid'));
            Cart::session(Cookie::get('_cartid'));
        }

        // ===========================================
        $shippingId = Cookie::get('shipping_id', 1);
        $shippingOption = ShippingOption::where('id', $shippingId)->first();
        $userBalances = array();
        $currencies = Currency::select('code')->get();
        $balances = Helper::getUserBalances(Auth::user()->id);
        foreach ($balances['cash'] as $cashbalance) {
            $userBalances[$cashbalance->currency] = $cashbalance->total;
        }
        foreach ($currencies as $currency) {
            if (!array_key_exists($currency->code, $userBalances)) {
                $userBalances[$currency->code] = 0;
            }
        }

        if (Cookie::has('cart_currency')) {
            $currency = Cookie::get('cart_currency');
        } else if (Cookie::has('currency')) {
            $currency = Cookie::get('currency');
        }
        Log::info($_COOKIE);
        Log::info("Currency: " . $currency);
        Log::info(json_encode($userBalances));
        $balance = $userBalances ? $userBalances[$currency] : 0;
        // ===========================================

        $products = Product::whereIn('id', Cart::getContent()->keys())->get();
        // set quantity for each product
        foreach ($products as $product) {
            $product->quantity = Cart::get($product->id)->quantity;
        }

        $paymentMethod = session('payment_method');
        $percent_interval_prefix = $paymentMethod == 2 ? 'percent_interval_' : 'percent_interval_cc_';

        $subTotal = 0;
        foreach ($products as $product) {
            // $subTotal += $product->real_price * $product->quantity;
            $subTotal += $product->PaymentMethodPrice($percent_interval_prefix . \App\Helper\Helper::getPercentInterval($product->quantity)) * $product->quantity;

        }

        $promocode = session('promocode');
        $promoCodeDiscount = 0;
        if ($promocode) {
            $promoCodeDiscount = Helper::getPromoCodeDiscount($promocode, $subTotal);
            $subTotal -= $promoCodeDiscount;
        }

        $userBalance = $balance <= 0 ? 0 : round($balance, 2);

        $paymentMethod = session('payment_method');


        if ($paymentMethod == 2) {
            $initialDeposit = floor($subTotal * 0.1 * 100) / 100;
        }else {
            $initialDeposit = $subTotal;
        }

        // $initialDeposit = floor($subTotal * 0.1 * 100) / 100;
        // if ($subTotal > $shippingOption->free_from) {
        //     $initialDeposit += $shippingOption->price * 0.1;
        // }

        if ($subTotal > $shippingOption->free_from) {
            if ($paymentMethod == 2) {
                $initialDeposit += $shippingOption->price * 0.1;
            } else {
                $initialDeposit += $shippingOption->price;
            }
            
        }
        
        if ($paymentMethod == 2) {
            $fee = floor($initialDeposit * 0.0375 * 100) / 100;
        } else {
            $fee = 0;
        }

        $total = round($subTotal, 2);
        // $dueNow = $initialDeposit + $fee - $userBalance;
        $dueNow = $initialDeposit + $fee;
        if ($subTotal > $shippingOption->free_from) {
            $total += $shippingOption->price;
        }
        $pending = $total - $initialDeposit;
        $total += $fee;

        // ===========================================
        Log::info("Cart: " . Cart::getContent());

        $province = Province::where('id', $account->province_id)->first();
        Log::info("dueNow: " . $dueNow);

        if (!$province || !$account->address_line1 || !$account->city || !$account->postcode || !$account->phone || !$account->fname || !$account->lname) {
            return response()->json(
                array('success' => false, 'error' => "Please Complete your shipping details to proceed. Go to <a href='/checkout?step=shipping'>Shipping Step</a>", 'title' => 'Shipping Details:'),
            );
        }

        $items = [];
        foreach ($products as $item) {
            $items[] = [
                "product_code" => strval($item->id),
                "description" => preg_replace('/[<>$%=?^{}\[\]\\\]/', '', $item->name),
                // "unit_cost" => strval($item->real_price),
                "unit_cost" => strval($item->PaymentMethodPrice($percent_interval_prefix . \App\Helper\Helper::getPercentInterval($item->quantity))),
                "quantity" => strval($item->quantity),
            ];
        }

        $data = [
            "store_id" => $store_id,
            "api_token" => $api_token,
            "checkout_id" => $checkout,
            "txn_total" => number_format($dueNow, 2, '.', ''),
            "environment" => $env,
            "action" => "preload",
            "order_no" => "",
            "cust_id" => Auth::user()->id,
            "dynamic_descriptor" => "dyndesc",
            "language" => "en",
            "cart" => [
                "items" => $items
            ],
            "contact_details" => [
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "phone" => $phone
            ],
            "shipping_details" => [
                "address_1" => $account->address_line1,
                // "address_2" => "Unit 2012",
                "city" => $account->city,
                "province" => $province->abbrev,
                "country" => "CA",
                "postal_code" => $account->postcode ? $account->postcode : 'N/A',
            ],
            "billing_details" => [
                "address_1" => $account->address_line1,
                // "address_2" => "Unit 2000",
                "city" => $account->city,
                "province" => $province->abbrev,
                "country" => "CA",
                "postal_code" => $account->postcode ? $account->postcode : 'N/A',
            ]
        ];

        // dd($data);

        Log::info("Data: " . json_encode($data));

        if (app()->environment('production')) {
            $response = Http::post('https://gateway.moneris.com/chktv2/request/request.php', $data);
        } else {
            $response = Http::post('https://gatewayt.moneris.com/chktv2/request/request.php', $data);
        }

        if ($response['response']['success'] === 'true') {
            return response()->json($response['response'], 200);
        } else {
            return response()->json($response['response'], 400);
        }
    }

    public function check(Request $request) {
        if (app()->environment('production')) {
            $store_id = config('services.moneris.store');
            $api_token = config('services.moneris.token');
            $checkout = config('services.moneris.checkout');
            $env = "prod";
        } else {
            $store_id = config('services.moneris.test.store');
            $api_token = config('services.moneris.test.token');
            $checkout = config('services.moneris.test.checkout');
            $env = "qa";
        }

        $data = [
            "store_id" => $store_id,
            "api_token" => $api_token,
            "checkout_id" => $checkout,
            "ticket" => $request->ticket,
            "environment" => $env,
            "action" => "receipt"
        ];

        if (app()->environment('production')) {
            $response = Http::post('https://gateway.moneris.com/chktv2/request/request.php', $data);
        } else {
            $response = Http::post('https://gatewayt.moneris.com/chktv2/request/request.php', $data);
        }

        // dd($response->json());

        Log::info("Check: " . $response);
        if ($response['response']['success'] !== 'true') {
            return response()->json($response['response'], 400);
        }

        if (app()->environment('production')) {
            Log::info("Check Code: " . $response['response']['receipt']['cc']['response_code']);

            $approved = false;
            switch ($response['response']['receipt']['cc']['response_code']) {
                case '000':
                case '001':
                case '002':
                case '003':
                case '004':
                case '005':
                case '006':
                case '007':
                case '008':
                case '009':
                case '010':
                case '023':
                case '024':
                case '025':
                case '026':
                case '027':
                case '027':
                case '028':
                case '029':
                    $approved = true;
                    break;
                default:
                    $approved = false;
                    break;
            }
            
            if (!$approved) {
                return response()->json($response, 400);
            }
        }

        Log::info('User: ' . Auth::user()->id);
        if ($request->hasCookie('_cartid')) {
            Log::info('hasCookie: ' . $request->hasCookie('_cartid'));
            Cart::session(Cookie::get('_cartid'));
        }

        // Get the products
        $products = $response['response']['request']['cart']['items'];
        Log::info('products: ' . json_encode($products));

        // check the products exists
        foreach ($products as $product) {
            $productExists = Product::where('id', $product['product_code'])
                ->where('enabled', true)
                ->where('in_stock', true)
                ->first();
            if (!$productExists) {
                return response()->json(array('success' => false, 'msg' => 'Product not found'), 404);
            }
        }

        $subTotal = 0;
        foreach ($products as $product) {
            $subTotal += floatval($product['unit_cost']) * intval($product['quantity']);
        }


        Log::info('Sub Total: ' . $subTotal);


        // Check if the cart is empty
        $countProducts = count($products);
        Log::info('countProducts: ' . $countProducts);
        if ($countProducts == 0) {
            return response()->json(array('success' => false, 'msg' => 'Empty=> ' . $products), 200);
        }

        // Get the shipping option
        $shippingOption = ShippingOption::where('id', $request->delivery_option)->first();
        if (!$shippingOption) {
            return response()->json(array('success' => false, 'msg' => 'Shipping option not found'), 404);
        }

        $currency = Currency::where('currencies.code', $request->currency)->first();
        Log::info('Currency: ' . $currency);
        if (!$currency) {
            return response()->json(array('success' => false, 'msg' => 'Currency not found'), 404);
        }

        $accountUser = Account::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        if (!$accountUser) {
            return response()->json(array('success' => false, 'msg' => 'Account not found'), 404);
        }

        $details = $response['response']['request'];

        $fee = 0;
        $total = round($subTotal, 2);
        $dueNow = 0;
        $pending = 0;

        $promocode = session('promocode');
        $promoCodeDiscount = 0;
        if ($promocode) {
            $promoCodeDiscount = Helper::getPromoCodeDiscount($promocode, $total);
            $total -= $promoCodeDiscount;
        }

        $paymentMethod = session('payment_method');

        if ($paymentMethod == 2) {
            $initialDeposit = floor($total * 0.1 * 100) / 100;
        }else {
            $initialDeposit = $total;
        }

        // Payment Page
        // $initialDeposit = floor($total * 0.1 * 100) / 100;
        // if ($subTotal > $shippingOption->free_from) {
        //     $initialDeposit += $shippingOption->price * 0.1;
        // }

        if ($subTotal > $shippingOption->free_from) {
            if ($paymentMethod == 2) {
                $initialDeposit += $shippingOption->price * 0.1;
            } else {
                $initialDeposit += $shippingOption->price;
            }
            
        }
        
        if ($paymentMethod == 2) {
            $fee = floor($initialDeposit * 3.75) / 100;
        } else {
            $fee = 0;
        }
        

        // $dueNow = $initialDeposit + $fee - $userBalance;
        $dueNow = $initialDeposit + $fee;
        if ($subTotal > $shippingOption->free_from) {
            // $dueNow += $shippingOption->price * 0.1;
            $total += $shippingOption->price;
        }
        $pending = $total - $dueNow;
        // if ($subTotal > $shippingOption->free_from) {
        //     $pending -= $shippingOption->price * 0.1;
        // }
        $total += $fee;

        // Create Order
        $productOrder = new ProductOrder();
        $productOrder->user_id = Auth::user()->id;
        $productOrder->payment_method = session('payment_method');
        $productOrder->shipping_option_id = $request->delivery_option;
        $productOrder->status_id = 1;
        $productOrder->notes = $request->notes;
        $productOrder->by_admin = 0;
        $productOrder->fee = $fee;
        $productOrder->currency_id = $currency->id;

        $productOrder->first_name = $details['cust_info']['first_name'];
        $productOrder->last_name = $details['cust_info']['last_name'];
        $productOrder->email = $details['cust_info']['email'];
        $productOrder->phone = $details['cust_info']['phone'];
        $productOrder->shipping_address_1 = $details['shipping']['address_1'];
        if (array_key_exists('address_2', $details['shipping'])) {
            $productOrder->shipping_address_2 = $details['shipping']['address_2'];
        }
        $productOrder->shipping_city = $details['shipping']['city'];
        $productOrder->shipping_country = $details['shipping']['country'];
        $productOrder->shipping_province = $details['shipping']['province'];
        $productOrder->shipping_postal_code = $details['shipping']['postal_code'];
        $productOrder->billing_address_1 = $details['billing']['address_1'];
        if (array_key_exists('address_2', $details['billing'])) {
            $productOrder->billing_address_2 = $details['billing']['address_2'];
        }
        $productOrder->billing_city = $details['billing']['city'];
        $productOrder->billing_country = $details['billing']['country'];
        $productOrder->billing_province = $details['billing']['province'];
        $productOrder->billing_postal_code = $details['billing']['postal_code'];
        $productOrder->payed = $details['txn_total'];
        $productOrder->total = $total;
        $productOrder->promo_code = $promocode;
        // promo_code_discount
        $productOrder->promo_code_discount = $promoCodeDiscount;
        $productOrder->moneris_order_id = $details['order_no'];
        $productOrder->moneris_ticket = $details['ticket'];
        $productOrder->save();

        session()->forget('promocode');
        session()->forget('payment_method');

        // Create deposit order
        $depositOrder = new DepositOrder();
        $depositOrder->order_type = "Shop";
        $depositOrder->table_name = "product_orders";
        $depositOrder->order_id = $productOrder->id;
        $depositOrder->save();
        Log::info('Deposit Order: ' . $depositOrder);


        $depositOrderPay = new DepositOrderPayment();
        $depositOrderPay->deposit_order_id = $depositOrder->id;
        $depositOrderPay->currency_id = $currency->id;
        // Charge the remaining amount
        // $depositOrderPay->value = $initialDeposit - ($userBalance > 0 ? $userBalance : 0);
        $depositOrderPay->value = $dueNow;
        $depositOrderPay->payment_method_id = PaymentOptions::CREDIT_CARD;
        $depositOrderPay->save();
        Log::info('Deposit Order Payment: ' . $depositOrderPay);

        $productOrder->status_id = 1;
        $productOrder->save();
        Log::info('Product Order: ' . $productOrder);

        if ($request->delivery_option == 1) {
            $productOrder->shipping_status_id = ShippingStatus::PENDING;
        } else {
            // When is 'Pickup' or 'Add to Storage'
            $productOrder->shipping_status_id = ShippingStatus::IN_STORAGE;
        }
        $productOrder->save();
        Log::info('Product Order: ' . $productOrder);

        $orderProductsList = [];
        foreach ($products as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $productOrder->id;
            $orderProduct->product_id = $product['product_code'];
            $orderProduct->quantity = $product['quantity'];
            $orderProduct->price = $product['unit_cost'];
            $orderProduct->currency_id = $currency->id;
            $orderProduct->save();
            Log::info('Order Product: ' . $orderProduct);
            $orderProductsList[] = $orderProduct;
        }

        Log::info('Initial Deposit: ' . $initialDeposit);
        Log::info('System Fee: ' . $fee);

        $data = [
            'account_number' => $accountUser->number,
            'fname' => Auth::user()->name,
            'email' => Auth::user()->email,
            'address' => $accountUser->address_line1,
            'city' => $accountUser->city,
            'phone' => $accountUser->phone,
            'currency' => $currency->code,
            'products' => $orderProductsList,
            'orderid' => $productOrder->order_id,
            'orderDate' => $productOrder->created_at,
            'shippingOption' => $shippingOption,
            'due' => $depositOrderPay->value,
            'fee' => $fee,
            'subTotal' => $subTotal,
            'initialDeposit' => $initialDeposit,
            'dueNow' => $dueNow,
            'pending' => $productOrder->total - $productOrder->payed,
            'total' => $productOrder->total,
            'paymentMethod' => $productOrder->payment_method,
            'promoCodeDiscount' => $productOrder->promo_code_discount,
        ];
        // Mail::to(Auth::user()->email)->send(new UserProductTransactionCompletedMail($data));
        try {
            // Send the Order Confirmation Mail immediately
            Mail::to(Auth::user()->email)->send(new OrderConfirmMail($productOrder));
        
            // Send the Order Pending Payment Mail after 5 minutes
            if ($productOrder->payment_method == 2) {
                Mail::to($productOrder->user->email)->later(now()->addMinutes(5), new OrderPendingPaymentMail($productOrder));
            }
        } catch (\Throwable $th) {
            \Log::error($th);

            throw $th;
        }
        

        if (app()->environment('production')) {
            $admins = User::whereIn('role_id', [1])->pluck('email');
        }else{
            $admins = ['muhammadrehanj@gmail.com'];
        }

        try {
            Mail::to($admins)->send(new AdminProductTransactionCompletedMail($data));
        } catch (\Throwable $th) {
            \Log::error($th);
            // throw $th;
        }
        Cart::clear();
        return response()->json(array('success' => true, 'msg' => '', 'item_type' => 'product', 'order_id' => $productOrder->id), 200);
    }
}
