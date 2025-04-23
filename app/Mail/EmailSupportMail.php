<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSupportMail extends Mailable {
    use Queueable, SerializesModels;
    public $fname;
    public $lname;
    public $email;
    public $option;
    public $msg;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        // $this->fname = $data['fname'];
        // $this->lname = $data['lname'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        // $this->option = $data['option'];
        $this->msg = $data['message'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->view('emails.admin.support-contact')
            ->subject('New Customer Enquiry');
    }
}
