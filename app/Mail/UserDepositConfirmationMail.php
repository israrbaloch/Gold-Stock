<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDepositConfirmationMail extends Mailable {
    use Queueable, SerializesModels;


    public $fname;
    public $email;
    public $date;
    public $ordertype;
    public $curr_or_metal;
    public $total;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->fname = $data['fname'];
        $this->email = $data['email'];
        $this->date = $data['date'];
        $this->ordertype = $data['ordertype'];
        $this->curr_or_metal = $data['curr_or_metal'];
        $this->total = $data['total'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->view('emails.user.deposit-confirmation')
            ->subject('Gold Stock Canada - Your New Cash Deposit!');
    }
}
