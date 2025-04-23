<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminPhysicalConversionMail extends UserPhysicalConversionMail {
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->view('emails.user.physical-conversion')
            ->subject("New Physical Conversion Order - " . $this->productOrder);
    }
}
