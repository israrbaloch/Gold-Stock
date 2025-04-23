<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount', 'valid_from', 'valid_until', 'is_active', 'discount_type'];

    protected $dates = ['valid_from', 'valid_until'];

    public function isValid()
    {
        $now = now();
        return $this->is_active &&
               (!$this->valid_from || $this->valid_from <= $now) &&
               (!$this->valid_until || $this->valid_until >= $now);
    }

    public function getDiscountAmount($amount)
    {
        if ($this->discount_type === 'percentage') {
            return $amount * $this->discount / 100;
        } else {
            return $this->discount;
        }
    }

    public function getDiscountedAmount($amount)
    {
        return $amount - $this->getDiscountAmount($amount);
    }

    // getDiscountAmountString()
    public function getDiscountAmountWords()
    {
        if ($this->discount_type === 'percentage') {
            return round($this->discount) . '%';
        } else {
            return '$' . $this->discount;
        }
    }
}
