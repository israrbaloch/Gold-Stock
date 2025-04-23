<?php

namespace App\Console\Commands;

use App\Models\PriceAlert;
use App\Notifications\PriceAlertTriggered;
use Illuminate\Console\Command;
use Notification;

class CheckPriceAlerts extends Command
{
    protected $signature = 'alerts:check';
    protected $description = 'Check price alerts and notify users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $alerts = PriceAlert::where('status', 1)->get();

        foreach ($alerts as $alert) {
            if (!$this->isAlertDue($alert)) {
                continue;
            }

            if ($alert->type == 1) {
                $product = $alert->product;
                $currentPrice = $product->CurrencyPrice($alert->currency);

                if ($this->shouldTriggerAlert($alert, $currentPrice)) {
                    Notification::send($alert->user, new PriceAlertTriggered($alert));
                    $alert->update(['last_sent_at' => now()]);
                    if ($alert->frequency == "real_time") {
                        $alert->update(['status' => 0]);
                    }
                }
            } else {
                $metal = $alert->metal;
                $currentPrice = $metal->CurrencyPrice($alert->currency);
                $currentChange = $metal->currentChange();

                if ($this->shouldTriggerAlert($alert, $currentPrice, $currentChange)) {
                    Notification::send($alert->user, new PriceAlertTriggered($alert));
                    $alert->update(['last_sent_at' => now()]);
                    if ($alert->frequency == "real_time") {
                        $alert->update(['status' => 0]);
                    }
                }
            }
        }
    }

    private function isAlertDue($alert)
    {
        if (!$alert->last_sent_at) {
            return true;
        }

        switch ($alert->frequency) {
            case 'real_time':
                return true;
            case 'daily':
                return $alert->last_sent_at->lt(now()->startOfDay());
            case 'weekly':
                return $alert->last_sent_at->lt(now()->startOfWeek());
            case 'monthly':
                return $alert->last_sent_at->lt(now()->startOfMonth());
            default:
                return false;
        }
    }

    private function shouldTriggerAlert($alert, $currentPrice, $currentChange = null)
    {
        if ($alert->type == 1) {
            switch ($alert->alert_type) {
                case 'price_reaches':
                    return $currentPrice == $alert->value;
                case 'price_rises_above':
                    return $currentPrice > $alert->value;
                case 'price_drops_to':
                    return $currentPrice < $alert->value;
                default:
                    return false;
            }
        } else {
            switch ($alert->alert_type) {
                case 'price_reaches':
                    return $currentPrice == $alert->value;
                case 'price_rises_above':
                    return $currentPrice > $alert->value;
                case 'price_drops_to':
                    return $currentPrice < $alert->value;
                case 'change_is_over':
                    return $currentChange > $alert->value;
                case 'change_is_under':
                    return $currentChange < $alert->value;
                case '24h_change_is_over':
                    return $currentChange > $alert->value;
                default:
                    return false;
            }
        }
    }
}