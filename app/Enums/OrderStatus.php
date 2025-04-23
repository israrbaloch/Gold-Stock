<?php

namespace App\Enums;

class OrderStatus {

    const PENDING = 1;
    const PROCESSING = 2;
    const ON_HOLD = 3;
    const COMPLETED = 4;
    const SHIPPED = 5;
    const AWAITING_PICK_UP = 6;
    const CANCELED = 7;
    const REFUNDED = 8;
    const FAILED = 9;
    const RETURNED = 10;
    const PARTIALLY_REFUNDED = 11;
    const AWAITING_STOCK = 12;
    const PAYMENT_PENDING = 13;
    const PAYMENT_RECEIVED = 14;
    const PAYMENT_COMPLETE = 15;
    const WAITING_FOR_APPROVAL = 16;
    // Changes Approved
    const MODIFICATION_APPROVED = 17;
    // Changes Rejected
    const MODIFICATION_REJECTED = 18;


    public static function getStatus($status) {
        switch ($status) {
            case self::PENDING:
                return 'Pending';
            case self::PROCESSING:
                return 'Processing';
            case self::ON_HOLD:
                return 'On hold';
            case self::COMPLETED:
                return 'Completed';
            case self::SHIPPED:
                return 'Shipped';
            case self::AWAITING_PICK_UP:
                return 'Awaiting pick up';
            case self::CANCELED:
                return 'Canceled';
            case self::REFUNDED:
                return 'Refunded';
            case self::FAILED:
                return 'Failed';
            case self::RETURNED:
                return 'Returned';
            case self::PARTIALLY_REFUNDED:
                return 'Partially refunded';
            case self::AWAITING_STOCK:
                return 'Awaiting stock';
            case self::PAYMENT_PENDING:
                return 'Payment pending';
            case self::PAYMENT_RECEIVED:
                return 'Payment received';
            case self::PAYMENT_COMPLETE:
                return 'Payment complete';
            case self::WAITING_FOR_APPROVAL:
                return 'Waiting for approval';
            case self::MODIFICATION_APPROVED:
                return 'Modification approved';
            case self::MODIFICATION_REJECTED:
                return 'Modification rejected';
            default:
                return 'N/A';
        }
    }

    public static function getStatuses(): array {
        return [
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::ON_HOLD => 'On hold',
            self::COMPLETED => 'Completed',
            self::SHIPPED => 'Shipped',
            self::AWAITING_PICK_UP => 'Awaiting pick up',
            self::CANCELED => 'Canceled',
            self::REFUNDED => 'Refunded',
            self::FAILED => 'Failed',
            self::RETURNED => 'Returned',
            self::PARTIALLY_REFUNDED => 'Partially refunded',
            self::AWAITING_STOCK => 'Awaiting stock',
            self::PAYMENT_PENDING => 'Payment pending',
            self::PAYMENT_RECEIVED => 'Payment received',
            self::PAYMENT_COMPLETE => 'Payment complete',
            self::WAITING_FOR_APPROVAL => 'Waiting for approval',
            self::MODIFICATION_APPROVED => 'Modification approved',
            self::MODIFICATION_REJECTED => 'Modification rejected',
        ];
    }
}
