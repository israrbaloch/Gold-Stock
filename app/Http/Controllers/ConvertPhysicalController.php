<?php

namespace App\Http\Controllers;

use App\Models\Metal;
use App\Helper\Helper;
use App\Mail\AdminPhysicalConversionMail;
use App\Mail\UserPhysicalConversionMail;
use App\Models\Account;
use App\Models\Product;
use App\Models\Currency;
use App\Models\DepositOrder;
use App\Models\OrderProduct;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Models\CashWithdrawal;
use App\Models\ShippingOption;
use App\Models\MetalWithdrawal;
use Illuminate\Support\Facades\DB;
use App\Models\DepositOrderPayment;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class ConvertPhysicalController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    function getView(Request $request) {
        $currency = Cookie::get('currency');
        $metal = $request->metal;
        $metalid = DB::table('metals')->where('metals.name', $metal)->first();
        $metalid = $metalid->id;
        $userid = auth()->user()->id;
        $usermetalbalance = $userid ? Helper::getMetalDepositUserBalance($userid, $metal) : null;
        $usercashbalance = $userid ? Helper::getCashDepositUserBalance($userid, $currency) : null;
        $products = Product::where('products.metal_id', $metalid)->get();
        $products = $products->toArray();
        $i = 0;
        foreach ($products as $product) {
            $products[$i]["real_conversion"] = $this->realConversionPrice($currency, $product['physical_price']);
            $i++;
        }
        // dd($usercashbalance, $usermetalbalance, $products);
        return view('convert-to-physical')
            ->with('usermetalbalance', $usermetalbalance)
            ->with('usercashbalance', $usercashbalance)
            ->with('products', $products);
    }
    public function realConversionPrice($currency, $physicalprice) {
        $rates = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();
        $ratevalue = $rates->us_rate;

        if ($currency == 'EUR') {
            $ratevalue = $rates->eur_rate;
        }
        if ($currency == 'CAD') {
            $ratevalue = $rates->cad_rate;
        }

        return $physicalprice * $ratevalue;;
    }

    public function saveConvertion(Request $request) {
        $usercashbalance = $request->cash_funds;
        $price = $request->price;
        $percent = $price * 0.10;
        // dd($request);
        $products = $request->products;
        $currency = $request->currency;
        $currency = Currency::where('currencies.code', $currency)->first();
        $userid = auth()->user()->id;
        $delivery_option = ShippingOption::find(intval($request->delivery_option));
        $balance = 0;

        if ($usercashbalance >= $percent) {
            $metalwithdrawals = new MetalWithdrawal();
            $metalwithdrawals->user_id = $userid;
            $metalwithdrawals->metal_id = $request->metal_id;
            $metalwithdrawals->oz = $request->value;
            $metalwithdrawals->method_payment_id = intval($request->payment_method);
            $metalwithdrawals->status_id = 2;
            $metalwithdrawals->save();

            if ($price < $usercashbalance) {
                //realiza el retiro de dinero
                $cashwhitdrawal = new CashWithdrawal();
                $cashwhitdrawal->user_id = $userid;
                $cashwhitdrawal->currency_id = $currency->id;
                $cashwhitdrawal->value = $request->total;
                $cashwhitdrawal->payment_method_id = intval($request->payment_method);
                $cashwhitdrawal->status_id = 2;
                $cashwhitdrawal->bank_address = $request->bank_address;
                $cashwhitdrawal->account_number = $request->account_number;
                $cashwhitdrawal->institution_number = $request->institution_number;
                $cashwhitdrawal->transit_number = $request->transit_number;
                $cashwhitdrawal->bank_name = $request->bank_name;
                $cashwhitdrawal->save();

                // Se crea la orden
                $productorder = new ProductOrder();
                $productorder->user_id = $userid;
                $productorder->shipping_option_id = $request->delivery_option;
                $productorder->shipping_status_id;
                $productorder->status_id = 2;
                $productorder->currency_id = $currency->id;
                $productorder->save();
                $metalwithdrawals->order_id = $productorder->id;
                $metalwithdrawals->save();
                $cashwhitdrawal->order_id = $productorder->id;
                $cashwhitdrawal->save();

                //se crea el registro del tipo de deposito
                $depositorder = new DepositOrder();
                $depositorder->order_type = "Convert";
                $depositorder->table_name = "product_orders";
                $depositorder->order_id = $productorder->id;
                $depositorder->save();

                //se realiza el cargue
                $depositorderpay = new DepositOrderPayment();
                $depositorderpay->deposit_order_id = $depositorder->id;
                $depositorderpay->currency_id = $currency->id;
                $depositorderpay->value = $cashwhitdrawal->value;
                $depositorderpay->payment_method_id = 5;
                $depositorderpay->save();

                $accountuser = Account::where('user_id', $userid)->orderBy('id', 'desc')->first();
                $data = array(
                    'fname' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'account_number' => $accountuser->number,
                    'address' => $accountuser->address_line1,
                    'city' => $accountuser->city,
                    'phone' => $accountuser->phone,
                    'products' => $products,
                    'currency' => $request->currency,
                    'totalmetal' => $request->value,
                    'totalprice' => $request->price,
                    'due' => $balance,
                    'delivery'   => $delivery_option->name,
                    'productOrder'   => $productorder->id
                );
                Mail::to($data['email'])->send(new UserPhysicalConversionMail($data));
                $admins = User::whereIn('role_id', [1])->pluck('email');
                Mail::to($admins)->send(new AdminPhysicalConversionMail($data));
            } else {
                $cashwhitdrawal = new CashWithdrawal();
                $cashwhitdrawal->user_id = $userid;
                $cashwhitdrawal->currency_id = $currency->id;
                $cashwhitdrawal->value = $usercashbalance;
                $cashwhitdrawal->payment_method_id = intval($request->payment_method);
                $cashwhitdrawal->status_id = 2;
                $cashwhitdrawal->bank_address = $request->bank_address;
                $cashwhitdrawal->account_number = $request->account_number;
                $cashwhitdrawal->institution_number = $request->institution_number;
                $cashwhitdrawal->transit_number = $request->transit_number;
                $cashwhitdrawal->bank_name = $request->bank_name;
                $cashwhitdrawal->save();

                $productorder = new ProductOrder();
                $productorder->user_id = $userid;
                $productorder->shipping_option_id = $request->delivery_option;
                $productorder->shipping_status_id;
                $productorder->status_id = 1;
                $productorder->currency_id = $currency->id;
                $productorder->save();
                $metalwithdrawals->order_id = $productorder->id;
                $metalwithdrawals->save();
                $cashwhitdrawal->order_id = $productorder->id;
                $cashwhitdrawal->save();

                // $balance = $price - $usercashbalance;
                // $cashwhitdrawal = new CashWithdrawal();
                // $cashwhitdrawal->user_id = $userid;
                // $cashwhitdrawal->currency_id = $currency->id;
                // $cashwhitdrawal->value = $balance;
                // $cashwhitdrawal->payment_method_id = intval($request->payment_method);
                // $cashwhitdrawal->status_id = 1;
                // $cashwhitdrawal->bank_address = $request->bank_address;
                // $cashwhitdrawal->account_number = $request->account_number;
                // $cashwhitdrawal->institution_number = $request->institution_number;
                // $cashwhitdrawal->transit_number = $request->transit_number;
                // $cashwhitdrawal->bank_name = $request->bank_name;
                // $cashwhitdrawal->order_id = $productorder->id;
                // $cashwhitdrawal->save();

                $depositorder = new DepositOrder();
                $depositorder->order_type = "Convert";
                $depositorder->table_name = "product_orders";
                $depositorder->order_id = $productorder->id;
                $depositorder->save();

                $depositorderpay = new DepositOrderPayment();
                $depositorderpay->deposit_order_id = $depositorder->id;
                $depositorderpay->currency_id = $currency->id;
                $depositorderpay->value = $usercashbalance;
                $depositorderpay->payment_method_id = 5;
                $depositorderpay->save();

                $accountuser = Account::where('user_id', $userid)->orderBy('id', 'desc')->first();
                $data = array(
                    'fname' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'account_number' => $accountuser->number,
                    'address' => $accountuser->address_line1,
                    'city' => $accountuser->city,
                    'phone' => $accountuser->phone,
                    'products' => $products,
                    'currency' => $request->currency,
                    'totalmetal' => $request->value,
                    'totalprice' => $request->price,
                    'due' => $balance,
                    'delivery'   => $delivery_option->name,
                    'productOrder'   => $productorder->id
                );
                Mail::to($data['email'])->send(new UserPhysicalConversionMail($data));
                $admins = User::whereIn('role_id', [1])->pluck('email');
                Mail::to($admins)->send(new AdminPhysicalConversionMail($data));
            }

            foreach ($products as $product) {
                $orderproducts = new OrderProduct();
                $orderproducts->order_id = $productorder->id;
                $orderproducts->product_id = $product['id_product'];
                $orderproducts->quantity = $product['quantity'];
                $orderproducts->price = $product['price'];
                $orderproducts->currency_id = $currency->id;
                $orderproducts->save();
            }
            return response()->json(array('success' => true), 200);
        } else {
            return response()->json(array('success' => false), 200);
        }
    }

    public function convert() {
        $metals = Metal::all();
        $metals = $metals->toArray();
        return view('convert')->with('metals', $metals);
    }
}
