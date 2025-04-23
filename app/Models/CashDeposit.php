<?php

namespace App\Models;

use App\Enums\TransactionTypes;
use Illuminate\Database\Eloquent\Model;
use App\Models\MetalOrder;
use App\Models\ProductOrder;
use App\Models\PaymentMethod;
use App\Models\Status;
use App\Helper\Helper;


class CashDeposit extends Model {
    protected $table = "cash_deposits";
    protected $appends = ['has_fee', 'product', 'date', 'currency', 'payment_method', 'status', 'type'];

    protected static function boot() {
        parent::boot();
        static::created(function ($cashDeposit) {
            $depo = $cashDeposit->value;
            $newDepo = $depo;
            $currency = $cashDeposit->currency_id;
            $metalPaysPendings = MetalOrder::where('user_id', $cashDeposit->user_id)->where('status_id', 1)
                ->where('currency_id', $cashDeposit->currency_id)->orderBy('created_at')->get();
            $productPaysPendings = ProductOrder::where('user_id', $cashDeposit->user_id)->where('status_id', 1)
                ->where('currency_id', $cashDeposit->currency_id)->orderBy('created_at')->get();
            $metalPendings = [];
            $productPendings = [];
            //            foreach($metalPaysPendings as $k => $v){
            //                $metalPendings[$k] = $v;
            //            }
            //            foreach($productPaysPendings as $k => $v){
            //                $productPendings[$k] = $v;
            //            }
            if (count($metalPaysPendings) > 0) {
                $newDepo = Helper::updatePayments($depo, $metalPaysPendings, "metal_orders", $currency);
            }
            if ($newDepo > 0 && count($productPaysPendings) > 0) {
                Helper::updatePayments($newDepo, $productPaysPendings, "product_orders", $currency);
            }
        });
    }

    public function getDateAttribute() {
        return date($this->created_at);
    }

    // User
    public function getEmailAttribute() {
        $user = User::find($this->user_id);
        return $user ? $user->email : 'N/A';
    }

    public function getProductAttribute() {
        $data['name'] = Currency::find($this->currency_id)->code . ' cash deposit';
        $data['quantity'] = $this->value;
        $data['price'] = $this->value;
        return $data;
    }

    public function getHasFeeAttribute() {
        return $this->payment_method_id == 3 ? true : false;
    }

    public function getCurrencyAttribute() {
        return Currency::find($this->currency_id)->code;
    }

    public function getPaymentMethodAttribute() {
        if ($this->payment_method_id != null) {
            return PaymentMethod::find($this->payment_method_id)->name;
        }
        return "N/A";
    }

    public function getStatusAttribute() {
        return Status::find($this->status_id)->name;
    }

    public function getTypeAttribute() {
        return 'cash';
    }

    public function getModeAttribute() {
        return TransactionTypes::DEPOSIT;
    }
}
