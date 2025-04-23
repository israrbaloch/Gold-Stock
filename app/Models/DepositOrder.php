<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DepositOrder extends Model
{
    use HasFactory;
    protected $table = "deposit_order";
    protected $appends = ['order_payments', 'fedex_id', 'date'];
    
    public function getOrderPaymentsAttribute() {
        $depoOrder = DepositOrderPayment::where('deposit_order_id', $this->id)->get();
        return $depoOrder ? $depoOrder : null;
    }
    public function getFedexIdAttribute() {
        $fedex = null;
        foreach($this->order_payments as $payment){
            if(!$fedex){
                $fedex = DB::table('ic_fedex')->where('order_id',$payment->id)->first();
            }
        }
        return $fedex ? $fedex->id : null;
    }
    
    public function getDateAttribute(){
        return date($this->created_at);
    }
}
