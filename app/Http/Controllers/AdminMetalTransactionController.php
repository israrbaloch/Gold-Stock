<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\ShippingStatus;
use App\Enums\TransactionTypes;
use App\Models\MetalDeposit;
use App\Models\MetalOrder;
use App\Models\MetalWithdrawal;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ShippingOption;
use Illuminate\Http\Request;

class AdminMetalTransactionController extends Controller {

    public function index() {
        $metalDeposits = MetalDeposit::orderBy('id', 'desc')->get();
        $metalWithdrawals = MetalWithdrawal::orderBy('id', 'desc')->get();

        // Merge the two collections
        $metalTransactions = $metalDeposits->merge($metalWithdrawals)->sortByDesc('created_at');

        return view('admin.transactions.metals.index')
            ->with('metalTransactions', $metalTransactions);
    }

    public function edit($id, $type) {

        switch ($type) {
            case TransactionTypes::DEPOSIT:
                $metalTransaction = MetalDeposit::where('id', $id)->first();
                break;
            case TransactionTypes::WITHDRAWAL:
                $metalTransaction = MetalWithdrawal::where('id', $id)->first();
                break;
            default:
                $metalTransaction = null;
                break;
        }

        if (!$metalTransaction) {
            return redirect()->route('admin.transactions.metals');
        }

        $orderStatuses = OrderStatus::getStatuses();

        return view('admin.transactions.metals.update')
            ->with('metalTransaction', $metalTransaction)
            ->with('orderStatuses', $orderStatuses);
    }

    public function update(Request $request, $id, $type) {
        switch ($type) {
            case TransactionTypes::DEPOSIT:
                $metalTransaction = MetalDeposit::where('id', $id)->first();
                break;
            case TransactionTypes::WITHDRAWAL:
                $metalTransaction = MetalWithdrawal::where('id', $id)->first();
                break;
            default:
                $metalTransaction = null;
                break;
        }

        if (!$metalTransaction) {
            return redirect()->route('admin.transactions.metals');
        }

        $metalTransaction->status_id = $request->status;
        $metalTransaction->save();
        return response()->json(['message' => 'Transaction updated successfully']);
    }
}
