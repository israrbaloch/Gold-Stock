<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMetalTransactionCompletedMail extends UserMetalTransactionCompletedMail {
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->view('emails.admin.metal-transaction-completed')
            ->subject("New Metal Order - " . $this->orderid);
    }
}
