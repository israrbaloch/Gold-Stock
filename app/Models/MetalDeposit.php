<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentOptions;
use App\Enums\TransactionTypes;
use App\Models\Metal;
use Illuminate\Database\Eloquent\Model;


class MetalDeposit extends Model {
    protected $table = "metal_deposits";
    protected $appends = ['has_fee', 'product', 'date', 'currency', 'payment_method', 'status', 'type'];

    public function getDateAttribute() {
        return date($this->created_at);
    }

    public function getTypeAttribute() {
        return 'metal';
    }

    public function getModeAttribute() {
        return TransactionTypes::DEPOSIT;
    }

    public function getHasFeeAttribute() {
        return $this->payment_method_id == 3 ? true : false;
    }

    public function getCurrencyAttribute() {
        /**
         * @deprecated
         */
        return Metal::find($this->metal_id)->name;
    }

    public function getMetalAttribute() {
        return Metal::find($this->metal_id)->name;
    }

    public function getPaymentMethodAttribute() {
        return PaymentOptions::getOption($this->method_payment_id);
    }

    public function getStatusAttribute() {
        return OrderStatus::getStatus($this->status_id);
    }

    // User
    public function getEmailAttribute() {
        $user = User::find($this->user_id);
        return $user ? $user->email : 'N/A';
    }

    // Metal
    public function getMetalNameAttribute() {
        return Metal::find($this->metal_id)->name;
    }

    public function getProductAttribute() {
        $data['name'] = Metal::find($this->metal_id)->name . ' deposit';
        $data['quantity'] = $this->oz;
        $data['price'] = $this->oz;
        return $data;
    }
}
