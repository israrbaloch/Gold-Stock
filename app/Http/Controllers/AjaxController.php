<?php

namespace App\Http\Controllers;

use Cart;
use Cookie;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Metal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{

    public function setCookie(Request $request)
    {
        Cookie::queue('currency', $request->currency);
        if ($request->hasCookie('_cartid')) {
            Cart::session(Cookie::get('_cartid'));
        }
        if (!Cart::isEmpty()) {
            $products = Cart::getContent();
            foreach ($products as $product) {
                $newPrice = $this->_getNewAmount($product->price, $product->attributes->currency, $request->currency);
                Cart::update(
                    $product->id,
                    array(
                        'price' => round($newPrice, 2),
                        'name' => $product->name,
                        'quantity' => array(
                            'relative' => false,
                            'value' => $product->quantity
                        ),
                        'attributes' => array(
                            'time' => Carbon::now(),
                            'image' => $product->attributes->image,
                            'currency' => $request->currency,
                            'weight' => $product->attributes->weight,
                            'type' => $product->attributes->product
                        )
                    )
                );
            }
            Cookie::queue('cart_currency', $request->currency);
        }

        return response()->json(array('msg' => $request->currency, "cookie" => $request->cookie("currency")), 200);
    }

    public function getProducts()
    {
        return response()->json(array('success' => true, "products" => Product::where('enabled', '1')->get()), 200);
    }

    public function getMetals()
    {
        return response()->json(array('success' => true, "products" => Metal::get()), 200);
    }

    private function _getNewAmount($amount, $oldCurr, $newCurr)
    {

        if ($oldCurr == "USD") {
            $true_value = $newCurr == "CAD" ? $amount * $this->_getRate("CAD") : $amount * $this->_getRate("EUR");
        } else if ($oldCurr == "CAD") {
            $usdPrice = $amount * $this->_getRate("cad_inverse");
            $true_value = $newCurr == "USD" ? $usdPrice : $usdPrice * $this->_getRate("EUR");
        } else {
            $usdPrice = $amount * $this->_getRate("eur_inverse");
            $true_value = $newCurr == "USD" ? $usdPrice : $usdPrice * $this->_getRate("CAD");
        }

        return round($true_value, 2, PHP_ROUND_HALF_UP);
    }

    private function _getRate($currency)
    {
        $rates = DB::table('ic_historical_rate')->orderBy('id', 'desc')->first();

        if (strtolower($currency) == "us" || strtolower($currency) == "usd") {
            return $rates->us_rate;
        } elseif (strtolower($currency) == "cad") {
            return $rates->cad_rate;
        } elseif (strtolower($currency) == "eur") {
            return $rates->eur_rate;
        } elseif (strtolower($currency) == "cad_inverse") {
            return $rates->cad_rate_inverse;
        } elseif (strtolower($currency) == "eur_inverse") {
            return $rates->eur_rate_inverse;
        } else {
            return 0;
        }
    }

    // users select 2
    public function getSelect2Data(Request $request)
    {
        $search = $request->search;
    
        // Fetch users matching the search query
        $users = DB::table('users')
            ->select('id', 'name', 'email')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            })
            ->limit(10) // Limit results for better performance
            ->get();
    
        // Format the data for Select2
        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,  // Value for the option
                'text' => "{$user->name} ({$user->email})", // Displayed text
            ];
        });
    
        return response()->json($data);
    }    
}
