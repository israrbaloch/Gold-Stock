<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;

class AdminProductController extends Controller {

    // index
    function index() {
        if (auth()->user()) {
            $products = Product::orderBy('id', 'desc')->paginate(10);
            return view('admin.products.list')->with('products', $products);
        } else {
            return redirect("/admin/login");
        }
    }

    function getProducts($search) {
        if (auth()->user()) {
            $products = Product::where('id', $search)
                ->orWhere(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->take(10)
                ->get();
            return response()->json($products);
        } else {
            return redirect("/admin/login");
        }
    }

    function getUsers($search) {
        if (auth()->user()) {
            $users = User::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
                ->where('subscribed', true)
                ->take(10)
                ->get();
            return response()->json($users);
        } else {
            return redirect("/admin/login");
        }
    }
}
