<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\CashWithdrawal;
use App\Models\MetalWithdrawal;
use Log;

class TransactionHistoryController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    function getView() {
        $account = Account::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();
        if ($account) {
            $userid = auth()->user()->id;
            $depositRows = $userid ? Helper::depositUser($userid) : null;
            // $withdrawalRows = $userid ? Helper::WithdrawalsUser($userid) : null;

            $cashWithdrawal = CashWithdrawal::where('user_id', $userid)->get();
            $metalWithdrawal = MetalWithdrawal::where('user_id', $userid)->get();
            Log::info($cashWithdrawal);
            Log::info($metalWithdrawal);

            $withdrawalRows = array_merge($cashWithdrawal->toArray(), $metalWithdrawal->toArray());
            // dd($withdrawalRows);
            $drs = array();
            $wrs = array();

            usort($withdrawalRows, function ($x, $y) {
                return $y['created_at'] <=> $x['created_at'];
            });

            foreach ($depositRows as $dr) {
                $drs[] = (array)$dr;
            }
            foreach ($withdrawalRows as $dr) {
                $wrs[] = (array)$dr;
            }
            $withdrawalRows = $wrs;
            return view('transaction-history')->with('depositRows', $depositRows)->with('withdrawalRows', $withdrawalRows)
                ->with('drs', $drs)->with('wrs', $wrs);
        } else {
            return redirect()->route('profile');
        }
    }

    function getDetailTransaction($product, $type, $id) {
        if ($type == "deposit") {

            if ($product != 'Gold' || $product != 'Silver' || $product != 'Platinum' || $product != 'Palladium') {
                $detail = Helper::MetalDeposit($id);
            } else {
                $detail = Helper::CashDeposit($id);
            }
        } else {
            if ($product != 'Gold' || $product != 'Silver' || $product != 'Platinum' || $product != 'Palladium') {
                $detail = Helper::WithdrawalMetal($id);
            } else {
                $detail = Helper::WithdrawalCash($id);
            }
        }

        return $detail;
    }
}
