<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoginSecurity;
use App\Models\User;
use App\Models\ProductOrder;
use App\Models\MetalOrder;

class Account extends Model {
    protected $appends = ['has_google', 'has_email', 'name_for_admins', 'orders', 'balances', 'email'];

    // identification field must show url
    public function getIdentificationAttribute($value) {
        return $value ? url('storage/' . $value) : null;
    }

    public function getHasGoogleAttribute() {
        $ls = LoginSecurity::where('user_id', $this->user_id)->first();
        $has = $ls ? $ls->google2fa_enable : 0;
        return $has;
    }

    public function getEmailAttribute() {
        return User::find($this->user_id)->email;
    }
    public function getHasEmailAttribute() {
        $ls = LoginSecurity::where('user_id', $this->user_id)->first();
        $has = $ls ? $ls->email2fa_enable : 0;
        return $has;
    }

    public function getNameForAdminsAttribute() {
        $user = User::find($this->user_id);
        if ($user) {
            $nfa = $user->name_for_admins;
            $oremail = $nfa != "" ? $nfa : $user->email;
            if ($oremail != "") {
                return $oremail;
            } else {
                return;
            }
        }
        return;
    }

    public function getOrdersAttribute() {
        $pOrders = ProductOrder::where('user_id', $this->user_id)->get()->toArray();
        $mOrders = MetalOrder::where('user_id', $this->user_id)->get()->toArray();

        return array_merge($pOrders, $mOrders);
    }

    public function getBalancesAttribute() {
        $user = User::find($this->user_id);
        return $user->balances;
    }

    public function scopeUnique($query) {
        $allAccounts = Account::whereIn('id', function ($query) {
            $query->select('id')->from('accounts')->groupBy('user_id')->havingRaw('count(*) > 1');
        })->get();
        $excludeIds = [];
        foreach ($allAccounts as $acc) {
            $accounts = Account::where('user_id', $acc->user_id)->get();
            $count = count($accounts);
            $i = 1;
            foreach ($accounts as $account) {
                if ($i < $count) {
                    $excludeIds[] = $account->id;
                }
                $i++;
            }
        }
        return $query->whereNotIn('id', $excludeIds);
    }
}
