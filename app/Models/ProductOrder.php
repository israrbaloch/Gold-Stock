<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\ShippingStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;
use Log;

class ProductOrder extends Model {
    protected $table = "product_orders";

    protected $fillable = [
        'user_id',
        'shipping_option_id',
        'shipping_status_id',
        'status_id',
        'currency_id',
        'notes',
        'by_admin',
        'created_by',

        'first_name',
        'last_name',
        'email',
        'phone',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_country',
        'shipping_province',
        'shipping_postal_code',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_country',
        'billing_province',
        'billing_postal_code',
        'payed',
        'total',
        'promo_code',
        'moneris_order_id',
        'moneris_ticket',
    ];

    protected $appends = [
        'paid',
        'orderid',
        'shipping',
        'currency',
        'product',
        'products',
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
        'metal_id',
        'mtp',
        'order_type',
        'has_fee',
        'paid_fee',
        'fedex_price'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // reviews
    public function reviews() {
        return $this->hasMany(Review::class, 'order_id');
    }

    public function shippingOption() {
        return $this->belongsTo(ShippingOption::class, 'shipping_option_id');
    }

    public function getStatusAttribute() {
        return OrderStatus::getStatus($this->status_id);
    }

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
        return 'PR' . $this->id;
    }

    public function getMetalIdAttribute() {
        return 'N/A';
    }

    public function getMtpAttribute() {
        return 'product';
    }

    public function getShippingAttribute() {
        $shippingOption = DB::table('shipping_options')->select('name')->where('id', $this->shipping_option_id)->first();
        if ($shippingOption) {
            return $shippingOption->name;
        } else {
            return 'N/A';
        }
    }

    public function getCurrencyAttribute() {
        return Currency::find($this->currency_id)->code;
    }

    // Products
    public function getProductAttribute() {
        /**
         * @deprecated
         */
        return OrderProduct::where('order_id', $this->id)->get();
    }

    public function getProductsAttribute() {
        return OrderProduct::where('order_id', $this->id)->get();
    }

    public function getPriceproductAttribute() {
        $total = 0;
        foreach ($this->product as $product) {
            $total += $product->price * $product->quantity;
        }
        return $total;
    }

    public function getNameuserAttribute() {
        return DB::table('users')->where('id', $this->user_id)->first() ? DB::table('users')->where('id', $this->user_id)->first()->name : 'N/A';
    }

    public function getQuantityAttribute() {
        $total = 0;
        foreach ($this->product as $product) {
            $total += $product->quantity;
        }
        return $total;
    }

    public function getTypeAttribute() {
        $do = DB::table('deposit_order')->where('id', $this->id)->first();
        return ($do) ? $do->order_type : null;
    }

    public function getShippingStatusAttribute() {
        return ShippingStatus::getStatus($this->shipping_status_id);
    }

    public function getShippingOptionAttribute() {
        $shippingOption = ShippingOption::where('id', $this->shipping_option_id)->first();
        if ($shippingOption) {
            return $shippingOption->name;
        } else {
            return 'N/A';
        }
    }

    public function getPaymentStatusAttribute() {
        $name = null;
        // $status = Status::where('id', $this->status_id)->first();
        // if ($status && $status->type == "transaction") {
        //     $name = $status->name;
        // } else {
        //     $name = 'PAYMENT COMPLETE';
        // }
        // return $name;
        $orderStatus = OrderStatus::getStatus($this->status_id);
        return $orderStatus;
    }

    public function getFedexDetailsAttribute() {
        $fedex = null;
        $order = DepositOrder::where('order_id', $this->id)->where('table_name', 'product_orders')->first();
        if ($order) {
            $fedexRows = DB::table('ic_fedex')->where('id', $order->fedex_id)->first();
            $fedex = $fedexRows ? $fedexRows : null;
        }
        return $fedex;
    }

    public function getFedexPriceAttribute() {
        $fedex = null;
        $order = DepositOrder::where('order_id', $this->id)->where('table_name', 'product_orders')->first();
        if ($order) {
            $fedexRows = DB::table('ic_fedex')->where('id', $order->fedex_id)->first();
            $fedex = $fedexRows ? $fedexRows->price : null;
        }
        return $fedex;
    }

    public function getSubtotalAttribute() {
        $fedexPrice = ($this->fedex_details) ? $this->fedex_details->price : 0;
        return $fedexPrice + $this->priceproduct;
    }

    public function getPaymentsAttribute() {
        $payments = [];
        $depositOrder = DepositOrder::where('order_id', $this->id)
            ->where('table_name', 'product_orders')
            ->first();
        $deposits =
            $depositOrder ?
            DepositOrderPayment::where('deposit_order_id', $depositOrder->id)
            ->get()
            : null;

        if ($deposits) {
            // Set deposit order payment data
            $i = 0;
            foreach ($deposits->toArray() as $deposit) {
                $payments[$i]['payment_method_id'] = null;
                foreach ($deposit as $key => $value) {
                    $payments[$i][$key] = $value;
                }
                $i++;
            }

            // Set payment method name
            $i = 0;
            foreach ($payments as $payment) {
                if ($payment['payment_method_id']) {
                    $paymentMethod = PaymentMethod::find($payment['payment_method_id']);
                    $payments[$i]['method'] = $paymentMethod->name;
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
        try {
            return DepositOrder::where('order_id', $this->id)->where('table_name', 'product_orders')->first()->order_type;
        } catch (\Throwable $th) {
            Log::info($this->id);
            Log::error($th);
            return null;
        }
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
                    $fee = number_format(floor($payment['value'] * 0.0375 * 100) / 100, 2);
                }
            }
        }
        return $fee;
    }
}
