<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PriceAlertMail extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    // nane
    public $alert;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alert) {
        $this->alert = $alert;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.user.price-alert', ['alert' => $this->alert])
        ->subject('Price Alert Triggered');
    }
}
