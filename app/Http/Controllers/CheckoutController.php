<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Account;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Province;
use App\Models\ShippingOption;
use Auth;
use Cart;
use Cookie;
use Illuminate\Http\Request;

class CheckoutController extends Controller {

    public function index(Request $request) {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $account = Account::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();

        // dd($account);
        if (!$account) {
            // return redirect()->route('account');
            $account = new Account();
            $account->user_id = Auth::user()->id;
            $account->number = Account::max('number') + 1;
            $account->last_login_time = now();
            $account->last_ip_address = $request->ip();
            $account->save();            
        }

        $userid = (auth()->user()) ? auth()->user()->id : null;
        $userBalances = array();
        $currencies = Currency::select('code')->get();
        $balances = ($userid) ? Helper::getUserBalances($userid) : null;

        foreach ($balances['cash'] as $cashbalance) {
            $userBalances[$cashbalance->currency] = $cashbalance->total;
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
        $allProvinces = Province::select('name', 'id')->get();
        $provinces = [];
        foreach ($allProvinces as $province) {
            $provinces[$province->id] = $province->name;
        }
        if ($request->hasCookie('cart_currency')) {
            $currency = Cookie::get('cart_currency');
        } else if ($request->hasCookie('currency')) {
            $currency = Cookie::get('currency');
            Cookie::queue('cart_currency', $currency);
            Cart::clear();
        } else {
            $currency = 'CAD';
            Cart::clear();
            Cookie::queue('cart_currency', 'CAD');
            Cookie::queue('currency', 'CAD');
        }
        $shippingOptions = ShippingOption::all();

        $shippingId = Cookie::get('shipping_id', 1);
        $shippingOption = ShippingOption::where('id', $shippingId)->first();

        $products = Product::whereIn('id', Cart::getContent()->keys())->get();

        // set quantity for each product
        foreach ($products as $product) {
            $product->quantity = Cart::get($product->id)->quantity;
        }

        // dd(Cart::getContent());
        // session put payment_method
        if (!session()->has('payment_method')) {
            session()->put('payment_method', 3);
        }

        return view('checkout.index')
            ->with('balance', $userBalances ? $userBalances[$currency] : 0)
            ->with('currency', Cookie::get('cart_currency'))
            ->with('account', $account)
            ->with('cartId', $cartId)
            ->with('products', $products)
            ->with('provinces', $allProvinces)
            ->with('shippingOptions', $shippingOptions)
            ->with('shippingOption', $shippingOption)
            ->with('provinces_list', $provinces);
    }

    // checkShippingAddress
    public function checkShippingAddress(Request $request) {
        $user = Auth::user();

        $account = Account::where('user_id', $user->id)->orderBy('id', 'desc')->first();

        if ($account) {
            // province_id
            if ($account->province_id == null || $account->address_line1 == null || $account->postcode == null || $account->phone == null || $account->city == null || $account->lname == null || $account->fname == null) {
                return response()->json(['success' => false, 'message' => 'Please update your shipping address before proceeding.']);
            }else{
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Please update your shipping address before proceeding.']);

    }
}
