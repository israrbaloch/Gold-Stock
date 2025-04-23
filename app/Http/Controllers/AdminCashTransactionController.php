<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\TransactionTypes;
use App\Models\CashDeposit;
use App\Models\CashWithdrawal;
use Illuminate\Http\Request;

class AdminCashTransactionController extends Controller {

    public function index() {
        $cashDeposits = CashDeposit::orderBy('id', 'desc')->get();
        $cashWithdrawals = CashWithdrawal::orderBy('id', 'desc')->get();

        // Merge the two collections
        $cashTransactions = $cashWithdrawals->merge($cashDeposits)->sortByDesc('created_at');

        return view('admin.transactions.cash.index')
            ->with('cashTransactions', $cashTransactions);
    }

    public function edit($id, $type) {

        switch ($type) {
            case TransactionTypes::DEPOSIT:
                $cashTransaction = CashDeposit::where('id', $id)->first();
                break;
            case TransactionTypes::WITHDRAWAL:
                $cashTransaction = CashWithdrawal::where('id', $id)->first();
                break;
            default:
                $cashTransaction = null;
                break;
        }

        if (!$cashTransaction) {
            return redirect()->route('admin.transactions.cash');
        }

        $orderStatuses = OrderStatus::getStatuses();

        return view('admin.transactions.cash.update')
            ->with('cashTransaction', $cashTransaction)
            ->with('orderStatuses', $orderStatuses);
    }

    public function update(Request $request, $id, $type) {
        switch ($type) {
            case TransactionTypes::DEPOSIT:
                $cashTransaction = CashDeposit::where('id', $id)->first();
                break;
            case TransactionTypes::WITHDRAWAL:
                $cashTransaction = CashWithdrawal::where('id', $id)->first();
                break;
            default:
                $cashTransaction = null;
                break;
        }

        if (!$cashTransaction) {
            return redirect()->route('admin.transactions.cash');
        }

        $cashTransaction->status_id = $request->status;
        $cashTransaction->save();
        return response()->json(['message' => 'Transaction updated successfully']);
    }
}
