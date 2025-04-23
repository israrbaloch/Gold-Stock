<?php

namespace App\Enums;

class TransactionTypes {

    const DEPOSIT = 'deposit';
    const WITHDRAWAL = 'withdrawal';

    public static function getType($status) {
        switch ($status) {
            case self::DEPOSIT:
                return 'Deposit';
            case self::WITHDRAWAL:
                return 'Withdrawal';
            default:
                return 'N/A';
        }
    }

    public static function getStatuses(): array {
        return [
            self::DEPOSIT => self::getType(self::DEPOSIT),
            self::WITHDRAWAL => self::getType(self::WITHDRAWAL),
        ];
    }
}
