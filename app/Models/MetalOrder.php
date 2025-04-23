<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentMethod;
use App\Models\DepositOrderPayment;
use App\Models\DepositOrder;
use Log;

class MetalOrder extends Model {
    protected $table = "metal_orders";

    protected $fillable = [
        'user_id',
        'metal_id',
        'quantity_oz',
        'price_per_oz',
        'fee',
        'currency_id',
        'status_id',
    ];

    protected $appends = [
        'paid',
        'orderid',
        'shipping',
        'email',
        'currency',
        'product',
        'priceproduct',
        'nameuser',
        'quantity',
        'type',
        'shipping_status',
        'payment_status',
        'shipping_option',
        'fedex_details',
        'subtotal',
        'payments',
        'date',
        'mtp',
        'metal_name',
        'order_type',
        'has_fee',
        'paid_fee'
    ];

    public function getPaidAttribute() {
        $paid = 0;
        $payments = $this->payments;
        if ($payments != "") {
            foreach ($payments as $payment) {
                $paid += $payment['value'];
            }
        }
        return $paid;
    }

    public function getOrderidAttribute() {
        return 'MT' . $this->id;
    }

    public function getStatusAttribute() {
        return OrderStatus::getStatus($this->status_id);
    }

    public function getShippingAttribute() {
        return '';
    }

    public function getMtpAttribute() {
        return 'metal';
    }

    public function getEmailAttribute() {
        return User::find($this->user_id)->email;
    }

    public function getCurrencyAttribute() {
        return Currency::find($this->currency_id)->code;
    }

    public function getProductAttribute(): Metal {
        return Metal::find($this->metal_id);
    }

    public function getMetalAttribute(): Metal {
        return Metal::find($this->metal_id);
    }

    public function getMetalNameAttribute() {
        return $this->getProductAttribute()->name;
    }

    public function getPriceproductAttribute() {
        return $this->quantity_oz * $this->price_per_oz;
    }

    public function getNameuserAttribute() {
        return DB::table('users')->where('id', $this->user_id)->first()->name;
    }

    public function getQuantityAttribute() {
        return $this->quantity_oz;
    }

    public function getTypeAttribute() {
        $do = DB::table('deposit_order')->where('id', $this->id)->first();
        return ($do) ? $do->order_type : null;
    }

    public function getShippingStatusAttribute() {
        return null;
    }

    public function getPaymentStatusAttribute() {
        return DB::table('statuses')->where('id', $this->status_id)->first()->name;
    }

    public function getShippingOptionAttribute() {
        return null;
    }

    public function getFedexDetailsAttribute() {
        return null;
    }

    public function getSubtotalAttribute() {
        return $this->priceproduct;
    }

    public function getPaymentsAttribute() {
        $payments = [];
        $depoOrder = DepositOrder::where('order_id', $this->id)->where(
            'table_name',
            'metal_orders'
        )->first();
        $paymentsRows = $depoOrder ?  DepositOrderPayment::where('deposit_order_id', $depoOrder->id)->get() : null;
        if ($paymentsRows) {
            $i = 0;
            foreach ($paymentsRows->toArray() as $p) {
                $payments[$i]['payment_method_id'] = null;
                foreach ($p as $k => $v) {
                    $payments[$i][$k] = $v;
                }
                $i++;
            }
            $i = 0;
            foreach ($payments as $payment) {
                if ($payment['payment_method_id']) {
                    $method = PaymentMethod::find($payment['payment_method_id']);
                    $payments[$i]['method'] = $method->name;
                }
                $i++;
            }
            return $payments;
        } else {
            return "";
        }
    }

    public function getDateAttribute() {
        return date($this->created_at);
    }

    public function getOrderTypeAttribute() {
        $order = DepositOrder::where('order_id', $this->id)->where(
            'table_name',
            'metal_orders'
        )->first();
        return $order ? $order->order_type : 'Sell';
    }

    public function getHasFeeAttribute() {
        $has = false;
        if ($this->payments) {
            foreach ($this->payments as $payment) {
                $has = $payment['payment_method_id'] == 3 ? true : $has;
            }
        }
        return $has;
    }

    public function getPaidFeeAttribute() {
        $fee = 0;
        if ($this->has_fee) {
            foreach ($this->payments as $payment) {
                if ($payment['payment_method_id'] == 3) {
                    $fee = round($payment['value'] * 0.0375, 2);
                }
            }
        }
        return $fee;
    }
}
