<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserProductTransactionCompletedMail extends Mailable {
    use Queueable, SerializesModels;

    public $fname;
    public $email;
    public $account_number;
    public $address;
    public $city;
    public $phone;
    public $products;
    public $currency;
    public $orderid;
    public $orderDate;
    public $shippingOption;
    public $due;
    public $fee;
    public $subTotal;
    public $initialDeposit;
    public $dueNow;
    public $pending;
    public $total;
    public $paymentMethod;
    public $promoCodeDiscount;


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
        $this->orderid = $data['orderid'];
        $this->orderDate = $data['orderDate'];
        $this->shippingOption = $data['shippingOption'];
        $this->due = $data['due'];
        $this->fee = $data['fee'];
        $this->subTotal = $data['subTotal'] ?? null;
        $this->initialDeposit = $data['initialDeposit'] ?? null;
        $this->dueNow = $data['dueNow'] ?? null;
        $this->pending = $data['pending'];
        $this->total = $data['total'];
        $this->paymentMethod = $data['paymentMethod'];
        $this->promoCodeDiscount = $data['promoCodeDiscount'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->view('emails.user.products-transaction-completed')
            ->subject('Gold Stock Canada - Your Order Purchase! 🌟');
    }
}
