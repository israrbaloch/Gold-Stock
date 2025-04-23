<?php

namespace App\Notifications;

use App\Mail\PriceAlertMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;


// class PriceAlertTriggered extends Notification implements ShouldQueue
class PriceAlertTriggered extends Notification
{
    use Queueable;

    protected $alert;

    public function __construct($alert)
    {
        $this->alert = $alert;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Sends both email & in-app notification
    }

    public function toMail($notifiable)
    {

        return (new PriceAlertMail($this->alert))->to($notifiable->email);

        return (new MailMessage)
            ->subject('Price Alert Triggered')
            ->line("Your price alert for **" . $this->formatAlertType($this->alert->alert_type) . "** at **$"."{$this->alert->value} {$this->alert->currency}** has been triggered.")
            ->action('View Alert', url('/'))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Price Alert Triggered',
            'message' => "Your price alert for " . $this->formatAlertType($this->alert->alert_type) . " at $"."{$this->alert->value} {$this->alert->currency} has been triggered.",
            'url' => url('/'),
        ];
    }

    private function formatAlertType($type)
    {
        $types = [
            'price_reaches' => 'Price reaches',
            'price_rises_above' => 'Price rises above',
            'price_drops_to' => 'Price drops to',
            'change_is_over' => 'Change is over',
            'change_is_under' => 'Change is under',
            '24h_change_is_over' => '24H change is over'
        ];

        return $types[$type] ?? ucfirst(str_replace('_', ' ', $type));
    }
}
