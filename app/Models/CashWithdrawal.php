<?php

namespace App\Models;

use App\Enums\TransactionTypes;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductOrder;
use App\Models\Currency;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class CashWithdrawal extends Model {
    protected $table = "cash_withdrawals";

    protected $appends = ['product_order', 'currency', 'payment_method', 'status', 'date', 'product', 'type'];

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
            $product_order['shipping'] = $this->payment_method;
            return $product_order;
        }
    }

    public function getDateAttribute() {
        return date($this->created_at);
    }

    // User
    public function getEmailAttribute() {
        $user = User::find($this->user_id);
        return $user ? $user->email : 'N/A';
    }

    public function getCurrencyAttribute() {
        $currency = Currency::find($this->currency_id)->code;
        return $currency;
    }

    public function getPaymentMethodAttribute() {
        return PaymentMethod::find($this->payment_method_id)->name;
    }

    public function getStatusAttribute() {
        return Status::find($this->status_id)->name;
    }

    public function getProductAttribute() {
        $data['name'] = Currency::find($this->currency_id)->code . ' cash withdrawal';
        $data['quantity'] = $this->value;
        $data['price'] = $this->value;
        return $data;
    }

    public function getTypeAttribute() {
        return 'cash';
    }

    public function getModeAttribute() {
        return TransactionTypes::WITHDRAWAL;
    }
}
