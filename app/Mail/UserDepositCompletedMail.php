<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDepositCompletedMail extends Mailable {
    use Queueable, SerializesModels;

    public $fname;
    public $email;
    public $account_number;
    public $address;
    public $city;
    public $phone;
    public $products;
    public $currency;
    public $totalprice;
    public $ordertype;
    public $orderid;
    public $orderDate;
    public $shipping_options;
    public $fedex_service;
    public $fedex_price;
    public $metalOrder;
    public $pending;
    public $due;
    public $fee;

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
        $this->totalprice = $data['totalprice'];
        $this->ordertype = $data['ordertype'];
        $this->orderid = $data['orderid'];
        $this->orderDate = $data['orderDate'];
        $this->shipping_options = $data['shipping_options'];
        $this->fedex_service = $data['fedex_service'];
        $this->fedex_price = $data['fedex_price'];
        $this->metalOrder = $data['metalOrder'];
        $this->pending = $data['pending'];
        $this->due = $data['due'];
        $this->fee = $data['fee'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->view('emails.user.deposit-completed')
            ->subject('Gold Stock Canada - Your Transaction is Completed!');
    }
}
