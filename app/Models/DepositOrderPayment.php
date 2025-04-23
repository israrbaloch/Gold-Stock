<?php

namespace App\Models;

use App\Mail\UserDepositCompletedMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DepositOrder;
use App\Models\ProductOrder;
use App\Models\MetalOrder;
use App\Models\CashDeposit;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DepositOrderPayment extends Model {
    use HasFactory;
    protected $table = "deposit_order_payment";
    protected $appends = ['order', 'date'];

    public function getOrderAttribute() {
        $depositOrder = DepositOrder::find($this->deposit_order_id);
        return DB::table($depositOrder->table_name)
            ->select('*')
            ->where('id', $depositOrder->order_id)
            ->first();
    }

    public function getDateAttribute() {
        return date($this->created_at);
    }

    protected static function boot() {
        parent::boot();
        static::updated(function ($payment) {
            $user = Auth::user();
            if ($payment->wasChanged('confirmed') && $user->role_id == 3) {
                $depoorder = DepositOrder::find($payment->deposit_order_id);
                if ($depoorder->table_name == 'product_orders') {
                    $productorder = ProductOrder::find($depoorder->order_id);
                } else if ($depoorder->table_name == 'metal_orders') {
                    $productorder = MetalOrder::find($depoorder->order_id);
                } else if ($depoorder->table_name == 'cash_deposits') {
                    $productorder = CashDeposit::find($depoorder->order_id);
                }
                if ($payment->confirmed == 1) {
                    $userid = $productorder->user_id;
                    $accountuser = Account::where('user_id', $userid)->orderBy('id', 'desc')->first();
                    $products = $productorder->product;

                    $data = array(
                        'fname' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        'account_number' => $accountuser->number,
                        'address' => $accountuser->address_line1,
                        'city' => $accountuser->city,
                        'phone' => $accountuser->phone,
                        'products' => $products,
                        'currency' => $productorder->currency,
                        'totalprice' => $productorder->priceproduct,
                        'ordertype' => $payment->order_type,
                        'orderid' => $productorder->order_id,
                        'orderDate' => $productorder->created_at,
                        'shipping_options' => $productorder->shipping_option,
                        'fedex_service' => $productorder->shipping,
                        'fedex_price' => $productorder->fedex_price,
                        'metalOrder' => $productorder->id,
                        'pending' => $productorder->priceproduct - $payment->value,
                        'due' => $payment->value,
                        'fee' => 0,
                    );
                    Mail::to($data['email'])->send(new UserDepositCompletedMail($data));
                    $admins = User::whereIn('role_id', [1])->pluck('email');
                    Mail::to($admins)->send(new UserDepositCompletedMail($data));
                }
            }
        });
    }
}
