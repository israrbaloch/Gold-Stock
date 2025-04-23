<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;

use App\Models\MetalDeposit;
use App\Models\MetalWithdrawal;
use App\Models\CashDeposit;
use App\Models\CashWithdrawal;
use App\Models\Metal;
use App\Models\User;
use App\Models\Currency;

class UsersBalancesController extends Controller {
    function getView() {
        if (auth()->user()) {
            $users = User::get();
            // dd($data);
            return view('users-balances')->with('users', $users);
        } else {
            return redirect("/admin/login");
        }
    }

    function getData($id = 0) {
        $user = User::find($id);
        return $user->balances;
    }

    private function _getMetalDeposits() {
        $items = MetalDeposit::get();
        return $items;
    }

    private function _getMetalWithdrawals() {
        $items = MetalWithdrawal::get();
        return $items;
    }

    private function _getCashDeposits() {
        $items = CashDeposit::get();
        return $items;
    }

    private function _getCashWithdrawals() {
        $items = CashWithdrawal::get();
        return $items;
    }
}
