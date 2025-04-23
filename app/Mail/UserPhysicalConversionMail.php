<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPhysicalConversionMail extends Mailable {
    use Queueable, SerializesModels;

    public $fname;
    public $email;
    public $account_number;
    public $address;
    public $city;
    public $phone;
    public $products;
    public $currency;
    public $totalmetal;
    public $totalprice;
    public $due;
    public $delivery;
    public $productOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->fname = $data['fname'];
        $this->email = $data['email'];
        $this->account_number = $data['account_number'];
        $this->address = $data['address'];
        $this->city = $data['city'];
        $this->phone = $data['phone'];
        $this->products = $data['products'];
        $this->currency = $data['currency'];
        $this->totalmetal = $data['totalmetal'];
        $this->totalprice = $data['totalprice'];
        $this->due = $data['due'];
        $this->delivery = $data['delivery'];
        $this->productOrder = $data['productOrder'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->view('emails.user.physical-conversion')
            ->subject("Gold Stock Canada - Your Physic Conversion is Complete! 🌟");
    }
}
