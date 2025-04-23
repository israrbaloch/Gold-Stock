<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMetalTransactionCompletedMail extends Mailable {
    use Queueable, SerializesModels;

    public $fname;
    public $email;
    public $account_number;
    public $address;
    public $city;
    public $phone;
    public $metal;
    public $currency;
    public $totalmetal;
    public $price_per_oz;
    public $totalprice;
    public $ordertype;
    public $orderid;
    public $orderDate;
    public $metalOrder;
    public $due;
    public $fee;
    public $pending;

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
        $this->metal = $data['metal'];
        $this->currency = $data['currency'];
        $this->totalmetal = $data['totalmetal'];
        $this->price_per_oz = $data['price_per_oz'];
        $this->totalprice = $data['totalprice'];
        $this->ordertype = $data['ordertype'];
        $this->orderid = $data['orderid'];
        $this->orderDate = $data['orderDate'];
        $this->metalOrder = $data['metalOrder'];
        $this->due = $data['due'];
        $this->fee = $data['fee'];
        $this->pending = $data['pending'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.user.metal-transaction-completed')
            ->subject('Gold Stock Canada - Metal Transaction Completed!');
    }
}
