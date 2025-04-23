<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Helper;


use App\Models\ProductOrder;
use App\Models\MetalOrder;
use App\Models\User;

class UsersOrdersCompilationController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    function getView() {
        if (auth()->user()) {
            $users = User::get();
            return view('users-orders-compilation')->with('users', $users);
        } else {
            return redirect("/admin/login");
        }
    }

    function getDataOrderProducts($id) {
        $data = Helper::getDataOrderProducts($id);
        return $data;
    }

    function getDataOrderMetals($userId) {
        $data = Helper::getDataOrderMetals($userId);
        return $data;
    }

    private function _getProductOrders() {
        $product_orders = ProductOrder::get();
        return $product_orders;
    }

    private function _getMetalOrders() {
        $metal_orders = MetalOrder::get();
        return $metal_orders;
    }
}
