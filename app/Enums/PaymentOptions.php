<?php

namespace App\Enums;

class PaymentOptions {

    const CASH = 1;
    const BANK = 2;
    const CREDIT_CARD = 3;
    const PAYPAL = 4;
    const BALANCE = 5;
    const E_TRANSFER = 6;
    const DEBIT = 7;

    public static function getOption($option) {
        $text = null;
        switch ($option) {
            case self::CASH:
                $text =  'Cash drop off in store';
                break;
            case self::BANK:
                $text =  'Bank transfer';
                break;
            case self::CREDIT_CARD:
                $text =  'Credit card';
                break;
            case self::PAYPAL:
                $text = 'Pay/Pal';
                break;
            case self::BALANCE:
                $text = 'From Balance Account';
                break;
            case self::E_TRANSFER:
                $text = 'E-Transfer';
                break;
            case self::DEBIT:
                $text = 'Debit in store';
                break;
            default:
                $text = 'N/A';
                break;
        }
        return $text;
    }

    public static function getOptions(): array {
        return [
            self::CASH => 'Cash drop off in store',
            self::BANK => 'Bank transfer',
            self::CREDIT_CARD => 'Credit card',
            self::PAYPAL => 'Pay/Pal',
            self::BALANCE => 'From Balance Account',
            self::E_TRANSFER => 'EE-Transfer',
            self::DEBIT => 'DDebit in store',
        ];
    }
}
