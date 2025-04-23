<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\MetalOrder;
use Illuminate\Http\Request;

class AdminMetalOrderController extends Controller {


    public function index() {

        $metalOrders = MetalOrder::orderBy('id', 'desc')->get();
        return view('admin.orders.metals.index')
            ->with('metalOrders', $metalOrders);
    }

    public function edit($id) {
        $metalOrder = MetalOrder::find($id);
        $orderStatuses = OrderStatus::getStatuses();

        return view('admin.orders.metals.update')
            ->with('metalOrder', $metalOrder)
            ->with('orderStatuses', $orderStatuses);
    }

    public function update(Request $request, $id) {
        $metalOrder = MetalOrder::find($id);
        $metalOrder->status_id = $request->status;
        $metalOrder->save();
        return response()->json(['message' => 'Metal Updated']);
    }
}
