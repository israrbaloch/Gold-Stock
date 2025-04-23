<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\CashDeposit;
use App\Models\CashWithdrawal;
use App\Models\Currency;
use App\Models\Metal;
use App\Models\MetalDeposit;
use App\Models\MetalWithdrawal;
use Illuminate\Support\Facades\DB;

class UserBalancesCompilationController extends Controller
{
    function getView(){
        if(auth()->user()){
            $data = Helper::getDataMetalWithdraws();
            //$usersbalances = Helper::UsersBalancesCompilation();
            
            $cashdepos = CashDeposit::where('status_id', 2)->get();
            $cashwithd = CashWithdrawal::where('status_id', 2)->get();
            $allCurrencies = Currency::get();
            foreach ($allCurrencies as $currency){
                $currencies[$currency->id] = $currency->code;
            }
            $usersWithDepos = DB::table('cash_deposits')->select('user_id')->distinct()->get();
            foreach($usersWithDepos as $userWD){
                $account = Account::where('user_id', $userWD->user_id)->first()->toArray();
                foreach($currencies as $k => $v){
                    $total = 0;
                    foreach($cashdepos as $deposit){
                        if($deposit->user_id == $userWD->user_id && $deposit->currency_id == $k){
                            $total += $deposit->value;
                        }
                    }
                    foreach($cashwithd as $withdraw){                        
                        if($withdraw->user_id == $userWD->user_id && $withdraw->currency_id == $k){
                            $total -= $withdraw->value;
                        }                        
                    }
                    $usersbalances['cash'][$userWD->user_id][$v]['total'] = $total > 0.009 ? $total : 0;
                    foreach($account as $key => $val){
                        $usersbalances['cash'][$userWD->user_id][$v][$key] = $val;
                    }
                }
            }
            $metaldepos = MetalDeposit::where('status_id', 2)->get();
            $metalwithd = MetalWithdrawal::where('status_id', 2)->get();
            $usersWithDepos = DB::table('metal_deposits')->select('user_id')->distinct()->get();
            $allMetals = Metal::get();
            foreach ($allMetals as $metal){
                $metals[$metal->id] = $metal->name;
            }
            foreach($usersWithDepos as $userWD){
                $account = Account::where('user_id', $userWD->user_id)->first()->toArray();
                foreach($metals as $k => $v){
                    $total = 0;
                    foreach($metaldepos as $deposit){
                        if($deposit->user_id == $userWD->user_id && $deposit->metal_id == $k){
                            $total += $deposit->oz;
                        }
                    }
                    foreach($metalwithd as $withdraw){
                        if($withdraw->user_id == $userWD->user_id && $withdraw->metal_id == $k){
                            $total -= $withdraw->oz;
                        }
                    }
                    $usersbalances['metals'][$userWD->user_id][$v]['total'] = $total > 0 ? $total : 0;
                    foreach($account as $key => $val){
                        $usersbalances['metals'][$userWD->user_id][$v][$key] = $val;
                    }
                }
            }
            return view('users-balances-compilation', $data)->with('usersbalances',$usersbalances);
        } else {
            return redirect("/admin/login");
        }
    }
}
