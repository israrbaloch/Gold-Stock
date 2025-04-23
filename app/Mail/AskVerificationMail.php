<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AskVerificationMail extends Mailable {
    use Queueable, SerializesModels;

    // nane
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user) {
        $this->user = $user;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.user.ask-verification', ['user' => $this->user])
        ->subject('Document Verification Request');
    }
}
