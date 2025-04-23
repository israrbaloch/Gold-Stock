<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\PromoCode;
use App\Models\ShippingOption;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller {

    public function index(Request $request) {
        $user = Auth::user();
        $userBalances = array();
        $currencies = Currency::select('code')->get();
        $balances = ($user) ? Helper::getUserBalances($user->id) : null;

        if ($user) {
            foreach ($balances['cash'] as $cashbalance) {
                $userBalances[$cashbalance->currency] = $cashbalance->total;
            }
        }
        foreach ($currencies as $currency) {
            if (!array_key_exists($currency->code, $userBalances)) {
                $userBalances[$currency->code] = 0;
            }
        }



        $cartId = null;
        if ($request->hasCookie('_cartid')) {
            Cart::session(Cookie::get('_cartid'));
            $cartId = Cookie::get('_cartid');
        }

        $shippingOptions = ShippingOption::select('id', 'name')->where('deleted_at', 'not', null)->get();
        if ($request->hasCookie('cart_currency') && Cookie::get('cart_currency') != "") {
            $curr = Cookie::get('cart_currency');
        } else if ($request->hasCookie('currency')) {
            $curr = Cookie::get('currency');
            Cookie::queue('cart_currency', $curr);
            Cart::clear();
        } else {
            $curr = 'CAD';
            Cart::clear();
            Cookie::queue('cart_currency', 'CAD');
            Cookie::queue('currency', 'CAD');
        }
        $currency = $curr;

        $products = Product::whereIn('id', Cart::getContent()->keys())->get();

        // set quantity for each product
        foreach ($products as $product) {
            $product->quantity = Cart::get($product->id)->quantity;
        }

        // dd(session()->all());

        // payment_method
        if (!session()->has('payment_method')) {
            session()->put('payment_method', 3);
        }

        // Change the product prices according to the selected payment method
        $paymentMethod = session('payment_method');

        $cartItems = Cart::getContent();

        $percent_interval_prefix = $paymentMethod == 2 ? 'percent_interval_' : 'percent_interval_cc_';

        foreach ($cartItems as $item) {
            $product = Product::find($item->id);
            $interval = $percent_interval_prefix . Helper::getPercentInterval($item->quantity);
            $item->price = $product->PaymentMethodPrice($interval);
        }

        return view('cart.index')
            ->with('balance', $userBalances ? $userBalances[$currency] : 0)
            ->with('products', $products)
            ->with('currency', $currency)
            ->with('shippingOptions', $shippingOptions)
            ->with('cartId', $cartId)
            ->with('percent_interval_prefix', $percent_interval_prefix);
    }

    public function quantity(Request $request) {
        if ($request->hasCookie('_cartid')) {
            Cart::session(Cookie::get('_cartid'));
        }
        $items = Cart::getContent();
        $totalQuantity = 0;
        foreach ($items as $item) {
            $totalQuantity += $item->quantity;
        }
        return response()->json(array('totalQuantity' => $totalQuantity), 200);
    }

    public function setCartCookies(Request $request) {
        if ($request->shipping_id !== null) {
            Cookie::queue('shipping_id', $request->shipping_id);
        }
        if ($request->currency !== null) {
            Cookie::queue('cart_currency', $request->currency);
        }
        if ($request->delivery_option !== null) {
            Cookie::queue('delivery_option', $request->delivery_option);
        }
        return response()->json(array('success' => true), 200);
    }

    public function add(Request $request) {
        // dd($request->all());
        if (Cookie::has('_cartid')) {
            Cart::session(Cookie::get('_cartid'));
        } else {
            $cartId = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);
            Cart::session($cartId);
            Cookie::queue('_cartid', $cartId);
            Cookie::queue('cart_currency', $request->currency);
        }

        $product = Product::where('id', $request->product_id)
            ->where('enabled', true)
            ->where('in_stock', true)
            ->first();

        if (!$product) {
            return back()
                ->with('cart-success', "Product not in stock");
        }
        $imagesData = json_decode($product->images);

        // Check if the decoded value is an array
        if (is_array($imagesData)) {
            // Select the first image in the array
            $image = $imagesData[0];
            // Replace backslashes with forward slashes in the image path and prepend the 'storage/' directory
            $image = '/storage/' . str_replace('\\', '/', $image);
        } else {
            // Assume the decoded value is a comma-separated list of image paths
            $exp = explode(',', $product->images);
            // Select the first image in the list
            $image = $exp[0];
        }
        Cart::add(
            array(
                'id' => $product->id,
                'name' => $product->name,
                'price' => round($request->current_price, 2),
                'quantity' => $request->quantity,
                'attributes' => array(
                    'time' => Carbon::now(),
                    'image' => $image,
                    'currency' => $request->currency,
                    'type' => "product"
                )
            )
        );
        return back()
            ->with('cart-success', "$product->name has been added successfully!");
    }

    public function addMetal(Request $request) {
        $hasCookie = $request->hasCookie('_cartid');
        $hasCartContent = false;
        if ($hasCookie) {
            $cookie = Cookie::get('_cartid');
            Cart::session($cookie);
            $hasCartContent = Cart::isEmpty() ? $hasCartContent : true;
        }

        if ($hasCartContent) {
            return response()->json(array('success' => false, 'reason' => 'noempty', 'request' => $request->total), 200);
        } else {
            $priceoz = $request->currentprice;
            $metals = ['gold' => 'Gold', 'silver' => 'Silver', 'plat' => 'Platinum', 'pall' => 'Palladium'];
            $metalname = $metals[$request->metalid];
            $metalid = (DB::table('metals')->select('id')->where('metals.name', $metalname)->first())->id;
            $qtymetal = $request->amount;
            $cartId = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);
            Cart::session($cartId);
            Cookie::queue('_cartid', $cartId);
            $imgs = [1183 => 'Gold.png', 1677 => 'Silver.png', 1681 => 'Platinum.png', 1682 => 'Palladium.png'];
            $img = '/img/' . $imgs[$metalid];
            Cart::add(
                array(
                    'id' => $metalid,
                    'name' => $metalname,
                    'price' => round($priceoz, 2),
                    'quantity' => $qtymetal,
                    'attributes' => array(
                        'time' => Carbon::now(),
                        'image' => $img,
                        'currency' => $request->currency,
                        'weight' => $qtymetal,
                        'type' => "metal"
                    )
                )
            );
            return response()->json(array('success' => true, 'product_name' => $metalname . ' (' . $qtymetal . '/oz) '), 200);
        }
    }

    public function addCash(Request $request) {
        $hasCookie = $request->hasCookie('_cartid');
        $hasCartContent = false;
        if ($hasCookie) {
            $cookie = Cookie::get('_cartid');
            Cart::session($cookie);
            $hasCartContent = Cart::isEmpty() ? $hasCartContent : true;
        }

        if ($hasCartContent) {
            return response()->json(array('success' => false, 'reason' => 'noempty', 'request' => $request->total), 200);
        } else {
            $cartId = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);
            Cart::session($cartId);
            Cookie::queue('_cartid', $cartId);
            $price = $request->value;
            $img = '/img/money_sign.svg';
            Cart::add(
                array(
                    'id' => 999,
                    'name' => $request->currency . ' Cash Deposit',
                    'price' => round($price, 2),
                    'quantity' => 1,
                    'attributes' => array(
                        'time' => Carbon::now(),
                        'image' => $img,
                        'currency' => $request->currency,
                        'weight' => 0,
                        'type' => "cash"
                    )
                )
            );
            return response()->json(array('success' => true, 'product_name' => $request->currency . ' Cash Deposit' . ' ($ ' . number_format($price, 2) . ') '), 200);
        }
    }

    /**
     * Check cart timing
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function checkCartTiming(Request $request) {
        $action = false;
        $cookie = $request->cookie('_cartid');

        if ($cookie) {
            Cart::session($cookie);

            $cartCollection = Cart::getContent();
            foreach ($cartCollection as $product) {
                if (Carbon::now()->diffInMinutes($product->attributes->time) > 10) {
                    $action = true;
                    Cart::remove($product->id);
                }
            }
            if (Cart::isEmpty()) {
                $cookie = Cookie::forget('_cartid');
            }
        }

        $response = response()->json(['action' => $action], 200);
        if ($cookie) {
            $response->withCookie($cookie);
        }
        return $response;
    }

    public function update(Request $request) {
        Cart::session(Cookie::get('_cartid'));

        $products = json_decode($request->products);

        foreach ($products as $product) {
            Cart::update(
                $product->id,
                array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => "" . $product->qty
                    ),
                )
            );
        }
        return response()->json(array('msg' => 'Cart updated!'), 200);
    }

    public function remove(Request $request) {
        $cookie = Cookie::get('_cartid');
        Cart::session($cookie);
        //        dd(Cookie::get('_cartid'));

        Cart::remove($request->pid);
        if (Cart::isEmpty()) {
            $cookie = Cookie::forget('_cartid');
        }
        return redirect()->route('cart')
            ->with('cart-success', 'Item removed!')
            ->withCookie($cookie);
    }

    public function clear() {
        Cart::session(Cookie::get('_cartid'));

        Cart::clear();
        $cookie = Cookie::forget('_cartid');
        return redirect()->route('cart')
            ->with('cart-success', 'Cart is cleared!')
            ->withCookie($cookie);
    }

    public function getFedex(Request $request) {
        $userId = Auth::user()->id;
        $weight = Helper::getTotalWeight();

        $fedexController = new FedexController();
        $data = $fedexController->getFedex($userId, $weight);
        $currency = (Cookie::get('currency')) ? Cookie::get('currency') : "CAD";
        $rate = $this->getRate($currency);
        $resp['success'] = false;



        $fs_to_return = array();
        if (is_array($data)) {
            foreach ($data as $fs) {
                $fstr = array();
                $service_name = ucfirst(strtolower(str_replace("_", " ", $fs->ServiceType)));
                if (sizeof($fs->RatedShipmentDetails) > 1) {
                    $service_price =  $fs->RatedShipmentDetails[1]->ShipmentRateDetail->TotalNetCharge->Amount * $rate;
                } else {
                    $service_price =  $fs->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount * $rate;
                }

                $fstr['service_name'] = $service_name;
                $fstr['service_price'] = number_format($service_price, 2);
                $fstr['service_currency'] = Cookie::get('currency');

                $fs_to_return[] = $fstr;
            }

            $resp['success'] = true;
            $resp['shipping_services'] = $fs_to_return;
        }
        return response()->json(array('data' => $resp, 'currency' => $currency), 200);
    }

    private function getRate($currency) {
        if ($currency != 'USD') {
            $col = strtolower($currency)  . '_rate';
        } else {
            $col = 'us_rate';
        }
        $rates = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();
        Log::info('Rates: ' . json_encode($rates));
        Log::info('Rates: ' . $rates->$col);
        return $rates->$col;
    }

    // applyPromo
    public function applyPromo(Request $request) {
        $promo = $request->promo_code;
        $cartId = Cookie::get('_cartid');
        Cart::session($cartId);
        $cart = Cart::getContent();

        // dd($cart);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item->price * $item->quantity;
        }
        $promo = PromoCode::where('code', $promo)->first();
        if ($promo && $promo->isValid()) {

            // check users product orders for promo code
            $productOrders = ProductOrder::where('user_id', Auth::user()->id)
                ->where('promo_code', $promo->code)
                ->get();

            if ($productOrders->count() > 0) {
                return response()->json(array('success' => false, 'total' => $total, 'message' => 'Promo code already used'), 200);
            }


            // Apply the discount to the total amount
            $discountedAmount = $promo->getDiscountedAmount($total);

            // add the promo code to the cart
            // Cookie::queue('promocode', $promo->code);

            session(['promocode' => $promo->code]);

            // Return the response with the discounted total
            return response()->json([
                'success' => true,
                'total' => $discountedAmount,
                'original_total' => $total,
                'discount' => $promo->getDiscountAmount($total),
                'currency' => Cookie::get('cart_currency')
            ], 200);
        }

        session()->forget('promocode');
        return response()->json(array('success' => false, 'total' => $total, 'message' => 'Invalid promo code'), 200);

    }

    // updatePaymentMethod
    public function updatePaymentMethod(Request $request) {
        session()->put('payment_method', request('payment_method'));
        $cartId = Cookie::get('_cartid');
        Cart::session($cartId);
        $cart = Cart::getContent();

        // dd($cart);

        $total = 0;
        // foreach ($cart as $item) {
        //     $total += $item->price * $item->quantity;
        // }


        $products = Product::whereIn('id', Cart::getContent()->keys())->get();
        
        $paymentMethod = session('payment_method');
        $percent_interval_prefix = $paymentMethod == 2 ? 'percent_interval_' : 'percent_interval_cc_';

        foreach ($products as $product) {
            $product->quantity = Cart::get($product->id)->quantity;
            $total += $product->PaymentMethodPrice($percent_interval_prefix . \App\Helper\Helper::getPercentInterval($product->quantity)) * $product->quantity;
        }

        $promocode = session('promocode');
        $promoCodeDiscount = 0;
        if ($promocode) {
            $promoCodeDiscount = Helper::getPromoCodeDiscount($promocode, $total);
            $total -= $promoCodeDiscount;
        }
        
        if ($paymentMethod == 2) {
            $initialDeposit = floor($total * 0.1 * 100) / 100;
            $fee = floor($initialDeposit * 0.0375 * 100) / 100;
        }else {
            $initialDeposit = $total;
            $fee = 0;
        }
        // $userBalance = $balance <= 0 ? 0 : round($balance, 2);
        // $dueNow = $initialDeposit + $fee - $userBalance;
        $dueNow = $initialDeposit + $fee;
        $total += $fee;
        // Total Calculation

        $html = view('cart.total-table', compact('dueNow', 'total', 'paymentMethod', 'fee', 'promoCodeDiscount', 'initialDeposit'))->render();

        $productsHtml = view('cart.products-tables', compact('products', 'percent_interval_prefix'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'productsHtml' => $productsHtml
        ]);
    }
}
