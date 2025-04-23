<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserWelcomeMail extends Mailable {
    use Queueable, SerializesModels;

    // nane
    public $name;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $type) {
        $this->name = $name;
        $this->type = $type;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        if ($this->type == 'individual') {
            return $this
            ->view('emails.user.welcome', ['name' => $this->name])
            ->subject('Welcome to Gold Stock Canada!');
        } else {
            return $this
            ->view('emails.user.welcome-business', ['name' => $this->name])
            ->subject('Welcome to Gold Stock Canada!');
        }
    }
}
