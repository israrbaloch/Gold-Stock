<?php

namespace App\Enums;

class ShippingStatus {

    const PENDING = 3;
    const COMPLETED = 4;
    const IN_STORAGE = 5;
    const DELIVERED = 6;

    public static function getStatus($status) {
        $text = null;
        switch ($status) {
            case self::PENDING:
                $text =  'Pending';
                break;
            case self::COMPLETED:
                $text =  'Completed';
                break;
            case self::IN_STORAGE:
                $text =  'In Storage';
                break;
            case self::DELIVERED:
                $text = 'Delivered';
                break;
            default:
                $text = 'N/A';
                break;
        }
        return $text;
    }

    public static function getStatuses(): array {
        return [
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
            self::IN_STORAGE => 'In Storage',
            self::DELIVERED => 'Delivered',
        ];
    }
}
