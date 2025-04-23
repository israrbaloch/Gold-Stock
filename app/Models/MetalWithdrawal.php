<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentOptions;
use App\Enums\TransactionTypes;
use Illuminate\Database\Eloquent\Model;


class MetalWithdrawal extends Model {
    protected $table = "metal_withdrawals";

    protected $appends = ['product_order', 'currency', 'payment_method', 'status', 'date', 'product', 'type'];

    public function getTypeAttribute() {
        return 'metal';
    }

    public function getModeAttribute() {
        return TransactionTypes::WITHDRAWAL;
    }

    public function getCurrencyAttribute() {
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

    public function getProductOrderAttribute() {

        if ($this->order_id || $this->metal_order_id) {
            if ($this->order_id) {
                $product_order = ProductOrder::where('id', $this->order_id)->first();
                if ($product_order) {
                    return $product_order->toArray();
                }
            } else {
                $metal_order = MetalOrder::where('id', $this->metal_order_id)->first();
                $metal = Metal::where('id', $metal_order->metal_id)->first();
                $product_order['product'] = array();
                $product_order['product']['name'] = $metal->name;
                $product_order['product']['price'] = $metal_order->price_per_oz;
                $product_order['product']['quantity'] = $metal_order->quantity_oz;
                $product_order['shipping'] = $this->payment_method;
                return $product_order;
            }
        } else {
            $product_order = array();
            $product_order['product'] = array();
            $product_order['product']['name'] = $this->currency;
            $product_order['product']['price'] = $this->value;
            $product_order['product']['quantity'] = $this->value;
            $product_order['shipping'] = ['PICK UP IN STORE'];
            return $product_order;
        }
    }

    public function getDateAttribute() {
        return date($this->created_at);
    }

    public function getProductAttribute() {
        $data['name'] = Metal::find($this->metal_id)->name . ' withdrawal';
        $data['quantity'] = $this->oz;
        $data['price'] = $this->oz;
        return $data;
    }
}
