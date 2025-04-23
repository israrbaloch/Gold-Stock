<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminProductTransactionCompletedMail extends UserProductTransactionCompletedMail {
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.admin.products-transaction-completed')
            ->subject("New Customer Order - " . $this->orderid);
    }
}
