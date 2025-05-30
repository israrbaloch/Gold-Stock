<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompletedMail extends Mailable {
    use Queueable, SerializesModels;

    // nane
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order) {
        $this->order = $order;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.user.order-completed', ['order' => $this->order])
        ->subject('Order Completed');
    }
}
