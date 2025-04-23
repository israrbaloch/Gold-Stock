<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;

use App\Models\MetalDeposit;
use App\Models\MetalWithdrawal;
use App\Models\CashDeposit;
use App\Models\CashWithdrawal;

class UsersTransactionsCompilationController extends Controller
{
    function getView()
    {
        if(auth()->user()){
            $deposits = Helper::depositGeneral();
            $withdrawals = Helper::WithdrawalsGeneral();
            $totaldeposits = sizeof($deposits);
            $totalwithdrawals = sizeof($withdrawals);
            $completedeposits = [];
            $pendingdeposits = [];
            $completewithdrawals = [];
            $pendingwithdrawals = [];

            foreach ($deposits as $deposit) {
                if ($deposit->statusid == 2) {
                    $completedeposits[] = $deposit;
                } elseif ($deposit->statusid == 1) {
                    $pendingdeposits[] = $deposit;
                }
            }

            foreach ($withdrawals as $whitdrawal) {
                if ($whitdrawal->statusid == 2) {
                    $completewithdrawals[] = $whitdrawal;
                } elseif ($whitdrawal->statusid == 1) {
                    $pendingwithdrawals[] = $whitdrawal;
                }
            }
            $totalcompletedeposits = sizeof($completedeposits);
            $totalpendingdeposits = sizeof($pendingdeposits);
            $totalcompletewithdrawals = sizeof($completewithdrawals);
            $totalpendigwithdrawals = sizeof($pendingwithdrawals);

            return view('users-transactions-compilation')
                ->with('deposits', $deposits)
                ->with('withdrawals', $withdrawals)
                ->with('totaldeposits', $totaldeposits)
                ->with('totalwithdrawals', $totalwithdrawals)
                ->with('completedeposits', $completedeposits)
                ->with('completewithdrawals', $completewithdrawals)
                ->with('pendingdeposits', $pendingdeposits)
                ->with('pendingwithdrawals', $pendingwithdrawals)
                ->with('totalcompletedeposits', $totalcompletedeposits)
                ->with('totalpendingdeposits', $totalpendingdeposits)
                ->with('totalcompletewithdrawals', $totalcompletewithdrawals)
                ->with('totalpendigwithdrawals', $totalpendigwithdrawals);
            } else {
                return redirect("/admin/login");
            }
    }
}
