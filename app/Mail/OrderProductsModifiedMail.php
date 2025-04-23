<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderProductsModifiedMail extends Mailable {
    use Queueable, SerializesModels;

    // nane
    public $order;
    public $oldProducts;
    public $oldTotal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $oldProducts, $oldTotal) {
        $this->order = $order;
        $this->oldProducts = $oldProducts;
        $this->oldTotal = $oldTotal;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.user.order-modified', ['order' => $this->order, 'oldProducts' => $this->oldProducts, 'oldTotal' => $this->oldTotal])
        ->subject('Order Modified');
    }
}
